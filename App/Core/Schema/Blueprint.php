<?php

namespace App\Core\Schema;

use App\Helpers\StringHelper;

class Blueprint
{
    protected $incrementFlag = false;
    protected $PrimaryKeyFlag = false;
    private $columns = [];

    public function __call($columnType, $arguments)
    {
        $columnName = $arguments[0];
        $columnMax = isset($arguments[1]) ? $arguments[1] : "";

        $this->columns[$columnName] = new Column($columnName, $columnType, $columnMax);

        return $this->columns[$columnName];
    }

    public function generate($name)
    {
        $baseSQL = "CREATE TABLE $name ( %s )";

        $columns = "";
        foreach ($this->columns as $key => $column) {
            $columns .= $column->getName() . " " .
                $column->getType() . " " .
                $column->getIncrements() . " " .
                $column->getMax() . " " .
                $column->getPrimary() . " " .
                $column->getDefault() . " " .
                $column->getNullable() . ",";
        }

        echo StringHelper::removeLastOccurrence(preg_replace("/\s+/", " ", sprintf($baseSQL, $columns, "")), ",");
    }
}
