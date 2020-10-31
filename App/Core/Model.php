<?php

namespace App\Core;

use Exception;
use PDO;
use ReflectionClass;
use ReflectionProperty;

abstract class Model extends Database
{
    private $stmt;
    private $lastId;

    private static $tableName;
    private static $primaryKey;

    public function __construct()
    {
        parent::__construct();
        self::$tableName = $this->getTableName(new ReflectionClass($this));
        self::$primaryKey = $this->getPrimaryKey(new ReflectionClass($this));
    }

    private function getTableName(ReflectionClass $param)
    {
        return $param->getStaticPropertyValue("tableName");
    }

    private function getPrimaryKey(ReflectionClass $param)
    {
        try {
            return $param->getStaticPropertyValue("primaryKey");
        } catch (Exception $e) {
            return "id";
        }
    }

    private function getFieldsArray(ReflectionClass $param)
    {
        $fields = [];

        foreach ($param->getProperties(ReflectionProperty::IS_PUBLIC) as $field) {
            $fieldName = $field->getName();

            if ($this->{$fieldName} != "")
                $fields[$fieldName] = $this->{$fieldName};
        }

        return $fields;
    }

    private function generateFieldsString($data = [])
    {
        $fields = [];

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $fields[] = $key;
            }

            return implode(",", $fields);
        }

        return "*";
    }

    private function generateValuesString($data = [])
    {
        $values = [];

        foreach ($data as $key => $value) {
            $values[] = ":{$key}";
        }

        return implode(",", $values);
    }

    private function generateInsertQueryString($data)
    {
        $fields = $this->generateFieldsString($data);
        $values = $this->generateValuesString($data);

        return "INSERT INTO " . self::$tableName . " " . "(" . $fields . ")" . " VALUES " . "(" . $values . ")";
    }

    private function generateUpdateQueryString($data, $where)
    {
        $fields = $this->generateFieldsBindString($data, ',');

        return "UPDATE " . self::$tableName . " SET " . $fields . " " . $where;
    }

    private function generateDeleteQueryString($where)
    {
        return "DELETE FROM " . self::$tableName . " " . $where;
    }

    private function generateSelectQueryString($data, $where = "", $order = "")
    {
        $fields = $this->generateFieldsString($data);

        return "SELECT " . $fields . " FROM " . self::$tableName . " " . $where . " " . $order;
    }

    private function bindParamsToStmt($params)
    {
        foreach ($params as $key => $value) {
            $type = (is_int($value)) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $this->stmt->bindValue(":{$key}", $value, $type);
        }
    }

    private function generateFieldsBindString($array, $separator)
    {
        $param = [];

        foreach ($array as $key => $value) {
            $param[] = "${key} = :${key}";
        }

        return implode($separator, $param);
    }

    private function generateWhereStatement($conditions, $separator = '')
    {
        return "WHERE " . $this->generateFieldsBindString($conditions, $separator);
    }

    private function setPrimaryKeyToReflectionClass($value)
    {
        $this->{self::$primaryKey} = $value;
    }

    private function setFieldsToReflectionClass($array)
    {
        foreach ($array as $key => $value) {
            $this->{$key} = $array[$key];
        }
    }

    private function updateLastId()
    {
        $id = $this->conn->lastInsertId();
        $this->lastId = $id ?? $this->lastId;
    }

    public function lastId()
    {
        $this->updateLastId();
        return $this->lastId;
    }

    public function first()
    {
        $class = new ReflectionClass($this);

        $dataToSelect = $this->getFieldsArray($class);

        $order = " ORDER BY " . self::$primaryKey . " ASC LIMIT 1";

        $this->stmt = $this->conn->prepare($this->generateSelectQueryString($dataToSelect,null,$order));
        $this->stmt->execute();

        $data = $this->stmt->fetch(PDO::FETCH_ASSOC);

        $this->setFieldsToReflectionClass($data);

        //fallback in case user assigns variable
        return $this;
    }

    public function last()
    {
        $class = new ReflectionClass($this);

        $dataToSelect = $this->getFieldsArray($class);

        $order = " ORDER BY " . self::$primaryKey . " DESC LIMIT 1";

        $this->stmt = $this->conn->prepare($this->generateSelectQueryString($dataToSelect,null,$order));
        $this->stmt->execute();

        $data = $this->stmt->fetch(PDO::FETCH_ASSOC);

        $this->setFieldsToReflectionClass($data);

        //fallback in case user assigns variable
        return $this;
    }

    public function find($primaryKeyValue)
    {
        $class = new ReflectionClass($this);

        $dataToSelect = $this->getFieldsArray($class);

        $where = $this->generateWhereStatement([self::$primaryKey => $primaryKeyValue]);

        $this->stmt = $this->conn->prepare($this->generateSelectQueryString($dataToSelect, $where, null));
        $this->bindParamsToStmt([self::$primaryKey => $primaryKeyValue]);
        $this->stmt->execute();

        $data = $this->stmt->fetch(PDO::FETCH_ASSOC);

        $this->setFieldsToReflectionClass($data);

        return $this;
    }

    public function selectAllWhere($conditions = [], $separator = "OR")
    {
        $class = new ReflectionClass($this);

        $dataToselect = $this->getFieldsArray($class);

        $where = $this->generateWhereStatement($conditions, " " . $separator . " ");

        $this->stmt = $this->conn->prepare($this->generateSelectQueryString($dataToselect, $where));
        $this->bindParamsToStmt($conditions);
        $this->stmt->execute();

        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create()
    {
        $class = new ReflectionClass($this);

        $dataToInsert = $this->getFieldsArray($class);

        $this->stmt = $this->conn->prepare($this->generateInsertQueryString($dataToInsert));
        $this->bindParamsToStmt($dataToInsert);

        $this->stmt->execute();

        $this->setPrimaryKeyToReflectionClass($this->lastId());
    }

    public function update()
    {
        $class = new ReflectionClass($this);

        $dataToInsert = $this->getFieldsArray($class);

        if (!array_key_exists(self::$primaryKey, $dataToInsert))
            return false;

        $where = $this->generateWhereStatement([self::$primaryKey => $dataToInsert[self::$primaryKey]]);
        $this->stmt = $this->conn->prepare($this->generateUpdateQueryString($dataToInsert, $where));

        $this->bindParamsToStmt($dataToInsert);
        $this->stmt->execute();

        return true;
    }

    public function delete()
    {
        $class = new ReflectionClass($this);

        $dataToDelete = $this->getFieldsArray($class);

        if (!array_key_exists(self::$primaryKey, $dataToDelete))
            return false;

        $where = $this->generateWhereStatement([self::$primaryKey => $dataToDelete[self::$primaryKey]]);
        $this->stmt = $this->conn->prepare($this->generateDeleteQueryString($where));

        $this->bindParamsToStmt([self::$primaryKey => $dataToDelete[self::$primaryKey]]);

        $this->stmt->execute();
        return true;
    }
}
