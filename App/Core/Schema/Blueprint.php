<?php

namespace App\Core\Schema;

use App\Core\Helpers\StringHelper;

class Blueprint
{
    protected $incrementFlag = false;
    protected $PrimaryKeyFlag = false;
    private $columns = [];

    public function __call($columnType, $arguments)
    {
        $columnName = $arguments[0];
        $columnMax = isset($arguments[1]) ? $arguments[1] : '';

        $this->columns[$columnName] = new Column($columnName, $columnType, $columnMax);

        return $this->columns[$columnName];
    }

    public function generate($name)
    {
        $baseSQL = "CREATE TABLE $name\n(\n%s\n);";

        $columns = '';

        foreach ($this->columns as $column) {
            if (!(strlen($column->getForeign()) > 0)) {
                $columns .=
                    $column->getName() . ' ' .
                    $column->getType() . '' .
                    $column->getMax() . ' ' .
                    $column->getNullable() . ' ' .
                    $column->getIncrements() . ' ' .
                    $column->getPrimary() . ' ' .
                    $column->getDefault() . ',' . "\n";
            } else {
                $columns .=
                    $column->getName() . ' ' .
                    $column->getType() . '' .
                    $column->getMax() . ' ' .
                    $column->getNullable() . ' ' .
                    $column->getIncrements() . ' ' .
                    $column->getPrimary() . ' ' .
                    $column->getDefault() . ',' . "\n";
                $columns .=
                    $column->getForeign() . ',' . "\n";
            }
        }

        echo StringHelper::removeLastOccurrence(preg_replace("/\s+/", ' ', sprintf($baseSQL, $columns, '')), ',');
    }
}
