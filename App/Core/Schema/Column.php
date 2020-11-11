<?php

namespace App\Core\Schema;

class Column
{
    protected $name;
    protected $default;
    protected $type;
    protected $nullable;
    protected $max;
    protected $increments;
    protected $primary_key;

    protected $foreign_key;
    protected $reference;
    protected $onupdate;
    protected $ondelete;

    public function __construct($name, string $type = '', string $max = '')
    {
        $this->name = $name;
        $this->type = $type;
        $this->max = $max;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getNullable()
    {
        return ($this->nullable) ? '' : 'NOT NULL';
    }

    public function getMax()
    {
        return ($this->max) ? '('.$this->max.')' : '';
    }

    public function getIncrements()
    {
        return ($this->increments) ? 'AUTO_INCREMENT' : '';
    }

    public function getDefault()
    {
        return ($this->default) ? "DEFAULT \'".$this->default."\'" : '';
    }

    public function getPrimary()
    {
        return ($this->primary_key) ? 'PRIMARY KEY' : '';
    }

    public function getOnUpdate()
    {
        return ($this->onupdate) ? 'ON UPDATE '.$this->onupdate : '';
    }

    public function getOnDelete()
    {
        return ($this->ondelete) ? 'ON DELETE '.$this->ondelete : '';
    }

    public function getForeign()
    {
        return ($this->foreign_key) ? 'FOREIGN KEY ('.$this->getName().') REFERENCES '.$this->reference.' '.$this->getOnUpdate().' '.$this->getOnDelete() : '';
    }

    public function autoIncrement()
    {
        $this->increments = true;

        return $this;
    }

    public function nullable()
    {
        $this->nullable = true;

        return $this;
    }

    public function primaryKey()
    {
        $this->primary_key = true;

        return $this;
    }

    public function defaultValue($value)
    {
        $this->default = $value;

        return $this;
    }

    public function maxValue($value)
    {
        $this->max = $value;

        return $this;
    }

    public function foreignKey()
    {
        $this->foreign_key = true;
        $this->primary_key = false;

        return $this;
    }

    public function references($column)
    {
        $this->reference = $column;

        return $this;
    }

    public function onUpdate($update)
    {
        $this->onupdate = $update;

        return $this;
    }

    public function onDelete($delete)
    {
        $this->ondelete = $delete;

        return $this;
    }
}
