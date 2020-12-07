<?php

namespace App\Core\Schema;

class Column
{
    protected string $name;
    protected string $default;
    protected string $type;
    protected string $nullable;
    protected string $max;
    protected string $increments;
    protected string $unique;
    protected bool $primary_key;

    protected bool $foreign_key;
    protected string $reference;
    protected string $onupdate;
    protected string $ondelete;

    public function __construct($name, string $type = '', string $max = '')
    {
        $this->name = $name;
        $this->type = $type;
        $this->max = $max;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getNullable(): string
    {
        return ($this->nullable) ? '' : 'NOT NULL';
    }

    public function getMax(): string
    {
        return ($this->max) ? '(' . $this->max . ')' : '';
    }

    public function getIncrements(): string
    {
        return ($this->increments) ? 'AUTO_INCREMENT' : '';
    }

    public function getDefault(): string
    {
        return ($this->default) ? "DEFAULT " . $this->default : '';
    }

    public function getPrimary(): string
    {
        return ($this->primary_key) ? 'PRIMARY KEY' : '';
    }

    public function getOnUpdate(): string
    {
        return ($this->onupdate) ? 'ON UPDATE ' . $this->onupdate : '';
    }

    public function getOnDelete(): string
    {
        return ($this->ondelete) ? 'ON DELETE ' . $this->ondelete : '';
    }

    public function getForeign(): string
    {
        return ($this->foreign_key) ? 'FOREIGN KEY (' . $this->getName() . ') REFERENCES ' . $this->reference . ' ' . $this->getOnUpdate() . ' ' . $this->getOnDelete() : '';
    }

    public function getUnique(): string
    {
        return ($this->unique) ? 'UNIQUE' : '';
    }

    public function autoIncrement(): Column
    {
        $this->increments = true;

        return $this;
    }

    public function nullable(): Column
    {
        $this->nullable = true;

        return $this;
    }

    public function primaryKey(): Column
    {
        $this->primary_key = true;

        return $this;
    }

    public function defaultValue($value): Column
    {
        $this->default = $value;

        return $this;
    }

    public function maxValue($value): Column
    {
        $this->max = $value;

        return $this;
    }

    public function foreignKey(): Column
    {
        $this->foreign_key = true;
        $this->primary_key = false;

        return $this;
    }

    public function references($column): Column
    {
        $this->reference = $column;

        return $this;
    }

    public function onUpdate($update): Column
    {
        $this->onupdate = $update;

        return $this;
    }

    public function onDelete($delete): Column
    {
        $this->ondelete = $delete;

        return $this;
    }

    public function unique(): Column
    {
        $this->unique = true;

        return $this;
    }
}
