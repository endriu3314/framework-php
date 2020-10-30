<?php

namespace App\Core\xd;

use App\Helpers\DebugPDO;
use App\Http\Model\Post;
use PDO;

abstract class Model
{
    private static $db = null;

    private static $tableName;

    public function __construct()
    {
        try {
            self::$db = self::openDatabaseConnection();
        } catch (\PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    static private function openDatabaseConnection()
    {
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        if (DB_TYPE == "pgsql") {
            $databaseEncodingenc = " options='--client_encoding=" . DB_CHARSET . "'";
        } else {
            $databaseEncodingenc = "; charset=" . DB_CHARSET;
        }

        return new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . $databaseEncodingenc, DB_USER, DB_PASS, $options);
    }

    private static function getFieldNames(\ReflectionClass $class): array
    {
        $fields = [];

        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $field) {
            $fields[] = $field->getName();
        }

        return $fields;
    }

    private static function getFieldNamesString(\ReflectionClass $class): string
    {
        return implode(",", self::getFieldNames($class));
    }

    private function getFields(\ReflectionClass $class): array
    {
        $fields = [];

        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $field) {
            $fieldName = $field->getName();

            if ($this->{$fieldName} != "")
                $fields[$fieldName] = $this->{$fieldName};
        }

        return $fields;
    }

    private static function getTableName(\ReflectionClass $class): string
    {
        return $class->getStaticPropertyValue('tableName');
    }

    public function insert()
    {
        $class = new \ReflectionClass($this);
        $tableName = $this->getTableName($class);

        $propsToImplode = $this->getFields($class);

        $tableFieldsString = implode(",", array_keys($propsToImplode));
        $tableValuesString = implode(",", array_map(function ($value) {
            return "'" . $value . "'";
        }, $propsToImplode));

        $sqlQuery = "INSERT INTO " . $tableName . "(" . $tableFieldsString . ")" . " VALUES " . "(" . $tableValuesString . ")" . ";";

        echo $sqlQuery;
        //$this->db->exec($sqlQuery);

        //$this->id = (int)$this->db->lastInsertId();
    }

    public function update()
    {
        $class = new \ReflectionClass($this);
        $tableName = $this->getTableName($class);

        $propsToImplode = $this->getFields($class);

        foreach ($propsToImplode as $key => $prop)
            $propsToImplode[$key] = "'" . $prop . "'";

        $str = '';
        foreach ($propsToImplode as $key => $item) {
            $str .= $key . '=' . $item . ',';
        }
        $str = rtrim($str, ',');

        $sqlQuery = "UPDATE " . $tableName . " SET " . $str . " WHERE id = " . $this->id;

        echo $sqlQuery;
    }

    public function save()
    {
        if ($this->id > 0) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    public static function find(int $id)
    {
        $class = new \ReflectionClass(get_called_class());

        $tableName = self::getTableName($class);
        $fields = self::getFieldNamesString($class);

        $sql = "SELECT " . $fields . " FROM " . $tableName . " WHERE id = " . $id . ";";

        echo $sql;
    }

    public static function first()
    {
        $class = new \ReflectionClass(get_called_class());

        $tableName = self::getTableName($class);
        $fields = self::getFieldNamesString($class);

        $sql = "SELECT " . $fields . " FROM " . $tableName . " ORDER BY id ASC LIMIT 1";

        echo $sql;
    }

    public static function last()
    {
        $class = new \ReflectionClass(get_called_class());

        $tableName = self::getTableName($class);
        $fields = self::getFieldNamesString($class);

        $sql = "SELECT " . $fields . " FROM " . $tableName . " ORDER BY id DESC LIMIT 1";

        echo $sql;
    }

    public static function where($options = [])
    {
        $class = new \ReflectionClass(get_called_class());

        $tableName = self::getTableName($class);
        $fields = self::getFieldNamesString($class);

        $options = [
            ['votes', '>', 1]
        ];

        $options = [
            ['votes', '>', 1],
            ['xd', '=', 1],
        ];

        echo $tableName . " " . $fields;
    }

    private static $sql = "";

    public static function select()
    {
        $class = new \ReflectionClass(get_called_class());

        $tableName = self::getTableName($class);
        $fields = self::getFieldNamesString($class);

        self::$sql = "SELECT " . $fields . " FROM " . $tableName . ";";
    }

    public static function get()
    {
        $class = new \ReflectionClass(get_called_class());
        echo self::$sql;

        return new Post;
    }

    public function fi0nd($options = [])
    {
        $result = [];
        $query = '';

        if (is_array($options)) {
            $whereConditions = [];
            foreach ($options as $key => $value) {
                $whereConditions[] = '`' . $key . '` = "' . $value . '"';
            }
            $query = " WHERE " . implode(' AND ', $whereConditions);
        } elseif (is_string($options)) {
            $query = 'WHERE ' . $options;
        } else {
            throw new \Exception('Wrong parameter type of options');
        }

        echo $query;

        $raw = self::$db->exec($query);
        foreach ($raw as $rawRow) {
            $result[] = self::morph($rawRow);
        }

        return $result;
    }

    public static function morph(array $object)
    {
        $class = new \ReflectionClass(get_called_class());

        $entity = $class->newInstance();

        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $prop) {
            if (isset($object[$prop->getName()])) {
                $prop->setValue($entity, $object[$prop->getName()]);
            }
        }

        $entity->initialize(); // soft magic

        return $entity;
    }

    protected function sanitize(string $input): string
    {
        return htmlspecialchars($input, ENT_QUOTES);
    }
}
