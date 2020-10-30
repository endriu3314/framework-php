<?php

namespace App\Core;

use PDO;
use ReflectionClass;
use ReflectionProperty;

abstract class Modelll extends Database
{
    private $stmt;
    private $data = [];
    private $conditions = [];
    private $sql;
    private $where;
    private $fields;
    private $count;
    private $fetch;
    private $lastId;

    private static $tableName;
    private static $primaryKey;

    public function __construct()
    {
        parent::__construct();
        self::$tableName = $this->getTableName(new ReflectionClass($this));
        self::$primaryKey = $this->getPrimaryKey(new ReflectionClass($this));
    }

    private function getTableName(ReflectionClass $class): string
    {
        return $class->getStaticPropertyValue('tableName');
    }

    private function getPrimaryKey(ReflectionClass $class): string
    {
        try {
            return $class->getStaticPropertyValue('primaryKey');
        } catch (\Exception $e) {
            return "id";
        }
    }

    private function getFieldNamesArray(ReflectionClass $class): array
    {
        $fields = [];

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $field) {
            $fields[] = $field->getName();
        }

        return $fields;
    }

    private function getFieldNamesString(ReflectionClass $class): string
    {
        return implode(",", $this->getFieldNamesArray($class));
    }

    private function getFieldValuesArray(ReflectionClass $class): array
    {
        $fields = [];

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $field) {
            $fieldName = $field->getName();

            if ($this->{$fieldName} != "")
                $fields[] = $this->{$fieldName};
        }

        return $fields;
    }

    private function getFieldValuesString(ReflectionClass $class): string
    {
        return implode(",", $this->getFieldValuesArray($class));
    }

    private function getFieldsArray(ReflectionClass $class): array
    {
        $fields = [];

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $field) {
            $fieldName = $field->getName();

            if ($this->{$fieldName} != "")
                $fields[$fieldName] = $this->{$fieldName};
        }

        return $fields;
    }

    private function param($data = null)
    {
        foreach ($data as $k => $v) {
            $tipo = (is_int($v)) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $this->stmt->bindValue(":{$k}", $v, $tipo);
        }
    }

    private function fields($data = null)
    {
        if (empty($data) && isset($this->data["fields"])) {
            return implode(",", $this->data["fields"]);
        }

        $fields = [];

        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $fields[] = $k;
            }

            return implode(",", $fields);
        }

        return "*";
    }

    private function bind($array, $separator)
    {
        $param = [];

        foreach ($array as $k => $v) {
            $param[] = "${k} = :${k}";
        }

        return implode($separator, $param);
    }

    private function conditions($separator)
    {
        $param = [];

        foreach ($this->conditions as $k => $v) {
            $param[] = "${k} = :${k}";
        }

        return implode($separator, $param);
    }

    private function values()
    {
        foreach ($this->data as $k => $v) {
            $values[] = ":{$k}";
        }

        return implode(",", $values);
    }

    private function where()
    {
        return $this->where = (isset($this->data["conditions"])) ? "WHERE " . $this->conditions(" AND ") : "";
    }

    private function find()
    {
        $sql = "SELECT " . $this->fields() . " FROM " . self::$tableName . " " . $this->where;
        $this->stmt = $this->conn->prepare($sql);

        if (!empty($this->where)) {
            $this->param();
        }

        $this->stmt->execute();
        return $this;
    }

    private function insertQueryString()
    {
        $fields = $this->fields($this->data);
        $values = $this->values();

        return "INSERT INTO " . self::$tableName . " " . "(" . $fields . ")" . " VALUES " . "(" . $values . ")";
    }

    private function updateQueryString($data)
    {
        $fields = $this->bind($data, ',');

        return "UPDATE " . self::$tableName . " SET " . $fields . " " . $this->where;
    }

    private function updateWhere($data)
    {
        $this->conditions = [self::$primaryKey => $data[self::$primaryKey]];

        $where = "WHERE " . $this->bind($this->conditions, '');

        return $where;
    }

    public function findAll($data = null)
    {
        $this->data = $data;
        return $this->find()->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //    public function findOne($data)
    //    {
    //        $this->data["conditions"] = $data;
    //        return $this->fetch = $this->find()->stmt->fetch(PDO::FETCH_ASSOC);
    //    }

    //    public function findByPk($pk)
    //    {
    //        return $this->findOne([self::$primaryKey => $pk]);
    //    }

    public function updateWhereString()
    {
        $this->where = "WHERE " . $this->bind($this->conditions, '');
    }

    private function bindParams()
    {
        foreach ($this->conditions as $key => $value) {
            $type = (is_int($value)) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $this->stmt->bindValue(":{$key}", $value, $type);
        }

        foreach ($data as $k => $v) {
            $tipo = (is_int($v)) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $this->stmt->bindValue(":{$k}", $v, $tipo);
        }
    }

    public function findd()
    {
        $sql = "SELECT " . $this->getFieldNamesString(new ReflectionClass($this)) . " FROM " . self::$tableName . " " . $this->where;
        $this->stmt = $this->conn->prepare($sql);

        var_dump(!empty($this->where));

        if (!empty($this->where)) {
            $this->bindParams();
        }

        var_dump($this->stmt);

        $this->stmt->execute();
        return $this;
    }


    public function findOneWhere()
    {
        $this->updateWhereString();
        return $this->findd();
    }

    public function findByPk($primaryKey)
    {
        $this->conditions = [self::$primaryKey => $primaryKey];

        $this->findOneWhere();
        var_dump($this->stmt);
    }

    public function exists($id)
    {
        if (is_array($id)) {
            return $this->findOne($id);
        }

        return $this->findByPk($id);
    }

    public function fetch()
    {
        return $this->fetch;
    }

    public function lastId()
    {
        $id = $this->conn->lastInsertId();
        return ($id) ? $id : $this->lastId;
    }

    public function query($sql)
    {
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->execute();
        $result = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->count = count($result);

        return $result;
    }

    public function create()
    {
        $class = new ReflectionClass($this);
        $this->data = $this->getFieldsArray($class);

        $this->stmt = $this->conn->prepare($this->insertQueryString());
        $this->param($this->data);

        $this->stmt->execute();
        $this->count = $this->stmt->rowCount();
    }

    public function update()
    {
        $class = new ReflectionClass($this);
        $this->data = $this->getFieldsArray($class);

        if (!array_key_exists(self::$primaryKey, $this->data)) {
            return false;
        }

        $param = $this->data;
        $this->where = $this->updateWhere($this->data);
        $this->stmt = $this->conn->prepare($this->updateQueryString($this->data));

        $this->param($param);
        $this->stmt->execute();
        $this->count = $this->stmt->rowCount();
    }

    public function save()
    {
        $class = new ReflectionClass($this);
        $this->data = $this->getFieldsArray($class);

        if (array_key_exists(self::$primaryKey, $this->data)) {
            $this->count = $this->findOne([self::$primaryKey => $this->data[self::$primaryKey]]);
            $this->lastId = $this->data[$this->pk];
        }

        if (!empty($this->count)) {
            return $this->update();
        }

        return $this->create();
    }

    public function delete()
    {
        $class = new ReflectionClass($this);
        $this->data = $this->getFieldsArray($class);

        $this->where = $this->updateWhere($this->data);

        $sql = "DELETE FROM " . self::$tableName . " " . $this->where;
        $this->stmt = $this->conn->prepare($sql);

        if (!empty($this->where)) {
            $this->param($this->conditions);
        }

        $this->stmt->execute();
        $this->count = $this->stmt->rowCount();
    }
}
