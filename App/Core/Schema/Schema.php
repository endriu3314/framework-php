<?php

namespace App\Core\Schema;

class Schema
{
    public $name;
    public $blueprint;

    public function create($tableName, $callback)
    {
        $this->name = $tableName;
        $this->blueprint = new Blueprint($tableName);
        $callback($this->blueprint);
        return $this;
    }

    public function generate()
    {
        $this->blueprint->generate($this->name);
    }
}
