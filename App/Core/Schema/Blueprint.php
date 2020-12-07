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
        $columnMax = $arguments[1] ?? '';

        $this->columns[$columnName] = new Column($columnName, $columnType, $columnMax);

        return $this->columns[$columnName];
    }

    /**
     * Generate SQL for table
     *
     * @param $name
     */
    public function generate($name): void
    {
        $baseSQL = "CREATE TABLE {$name}\n(\n%s\n);";

        $columns = '';

        foreach ($this->columns as $column) {
            $columns .=
                $column->getName() . ' ' .
                $column->getType() . '' .
                $column->getMax() . ' ' .
                $column->getNullable() . ' ' .
                $column->getIncrements() . ' ' .
                $column->getPrimary() . ' ' .
                $column->getUnique() . ' ' .
                $column->getDefault() . ',' . "\n";

            if (($column->getForeign() !== '')) {
                $columns .= $column->getForeign() . ',' . "\n";
            }
        }

        echo StringHelper::removeLastOccurrence(preg_replace("/\s+/", ' ', sprintf($baseSQL, $columns, '')), ',');
    }
}
