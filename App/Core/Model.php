<?php

namespace App\Core;

abstract class Model extends Database
{
    private $stmt;
    private $lastId;

    private static $tableName;
    private static $primaryKey;

    public function __construct()
    {
        parent::__construct();
        self::$tableName = $this->getTableName(new \ReflectionClass($this));
        self::$primaryKey = $this->getPrimaryKey(new \ReflectionClass($this));
    }

    private function getTableName(\ReflectionClass $param)
    {
        return $param->getStaticPropertyValue("tableName");
    }

    private function getPrimaryKey(\ReflectionClass $param)
    {
        try {
            return $param->getStaticPropertyValue("primaryKey");
        } catch (\Exception $e) {
            return "id";
        }
    }

    private function getFieldsArray(\ReflectionClass $param)
    {
        $fields = [];

        foreach ($param->getProperties(\ReflectionProperty::IS_PUBLIC) as $field) {
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

    private function bindParamsToStmt($params)
    {
        foreach ($params as $key => $value) {
            $type = (is_int($value)) ? \PDO::PARAM_INT : \PDO::PARAM_STR;
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

    private function generateUpdateWhereStatement($data)
    {
        $condition = [self::$primaryKey => $data[self::$primaryKey]];

        return "WHERE " . $this->generateFieldsBindString($condition, '');
    }

    private function setPrimaryKeyToReflectionClass($value)
    {
        $this->{self::$primaryKey} = $value;
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

    public function create()
    {
        $class = new \ReflectionClass($this);

        $dataToInsert = $this->getFieldsArray($class);

        $this->stmt = $this->conn->prepare($this->generateInsertQueryString($dataToInsert));
        $this->bindParamsToStmt($dataToInsert);

        $this->stmt->execute();

        $this->setPrimaryKeyToReflectionClass($this->lastId());
    }

    public function update()
    {
        $class = new \ReflectionClass($this);

        $dataToInsert = $this->getFieldsArray($class);

        if (!array_key_exists(self::$primaryKey, $dataToInsert))
            return false;

        $where = $this->generateUpdateWhereStatement($dataToInsert);
        $this->stmt = $this->conn->prepare($this->generateUpdateQueryString($dataToInsert, $where));

        var_dump($this->stmt);

        $this->bindParamsToStmt($dataToInsert);
        $this->stmt->execute();

        return true;
    }
}
