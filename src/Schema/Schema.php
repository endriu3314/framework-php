<?php

namespace AndreiCroitoru\FrameworkPhp\Schema;

class Schema
{
    public string $name;
    public Blueprint $blueprint;

    public function create($tableName, $callback): Schema
    {
        $this->name = $tableName;
        $this->blueprint = new Blueprint($tableName);
        $callback($this->blueprint);

        return $this;
    }

    public function generate(): void
    {
        $this->blueprint->generate($this->name);
    }

    public function __destruct()
    {
    }
}
