<?php

namespace App\Core\ORM;

class Collection
{
    protected $items = [];

    public function __construct($items = [])
    {
        $this->items = $items;
    }

    public function reverse(): Collection
    {
        $this->items = array_reverse($this->items);
        return $this;
    }

    public function get()
    {
        return $this->items;
    }
}
