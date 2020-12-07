<?php

namespace App\Core\Schema;

use App\Core\Helpers\StringHelper;

class Blueprint
{
    protected bool $incrementFlag = false;
    protected bool $PrimaryKeyFlag = false;
    private array $columns = [];

    public function __call($columnType, $arguments): Column
    {
        $columnName = $arguments[0];
        $columnMax = isset($arguments[1]) ? $arguments[1] : '';

        $this->columns[$columnName] = new Column($columnName, $columnType, $columnMax);

        return $this->columns[$columnName];
    }

    public function generate($name): void
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
                    $column->getUnique() . ' ' .
                    $column->getDefault() . ',' . "\n";
            } else {
                $columns .=
                    $column->getName() . ' ' .
                    $column->getType() . '' .
                    $column->getMax() . ' ' .
                    $column->getNullable() . ' ' .
                    $column->getIncrements() . ' ' .
                    $column->getPrimary() . ' ' .
                    $column->getUnique() . ' ' .
                    $column->getDefault() . ',' . "\n";
                $columns .=
                    $column->getForeign() . ',' . "\n";
            }
        }

        echo StringHelper::removeLastOccurrence(preg_replace("/\s+/", ' ', sprintf($baseSQL, $columns, '')), ',');
    }
}
