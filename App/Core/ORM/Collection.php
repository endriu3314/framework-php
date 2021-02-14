<?php

namespace App\Core\ORM;

class Collection
{
    protected $items = [];

    public function __construct($items = [])
    {
        $this->items = $items;
    }

    public function first(): mixed
    {
        return reset($this->items);
    }

    public function last(): mixed
    {
        return end($this->items);
    }

    public function firstFilter(\Closure $callback): mixed
    {
        foreach ($this->items as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return false;
    }

    public function lastFilter(\Closure $callback): mixed
    {
        foreach ($this->reverse()->get() as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return false;
    }

    public function map(\Closure $callback): Collection
    {
        $keys = array_keys($this->items);
        $items = array_map($callback, $this->items, $keys);
        return new Collection(array_combine($keys, $items));
    }

    public function filter(\Closure $callback = null): Collection
    {
        return new Collection(array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH));
    }

    public function only(...$keys): Collection
    {
        $keys = $this->getArgs($keys);
        return new Collection(array_intersect_key($this->items, array_flip($keys)));
    }

    public function except(...$keys): Collection
    {
        $keys = $this->getArgs($keys);
        return new Collection(array_diff_key($this->items, array_flip($keys)));
    }

    public function has(...$keys): bool
    {
        $keys = $this->getArgs($keys);

        foreach ($keys as $key) {
            if (!array_key_exists($key, $this->items)) {
                return false;
            }
        }

        return true;
    }

    public function reverse(): Collection
    {
        return new Collection(array_reverse($this->items));
    }

    public function value($key): mixed
    {
        if (array_key_exists($key, $this->items)) {
            return $this->items[$key];
        }

        return false;
    }

    public function values(...$keys): Collection
    {
        $keys = $this->getArgs($keys);

        $arr = [];
        foreach ($keys as $key) {
            if (array_key_exists($key, $this->items)) {
                $arr[$key] = $this->items[$key];
            }
        }

        return new Collection($arr);
    }

    public function chunk(int $size): Collection
    {
        if ($size <= 0) {
            return $this;
        }

        $toReturn = [];
        foreach (array_chunk($this->items, $size, true) as $chunk) {
            $toReturn[] = new Collection($chunk);
        }

        return new Collection($toReturn);
    }

    public function slice(int $size, ?int $length = null): Collection
    {
        return new Collection(array_slice($this->items, $size, $length, true));
    }

    public function take(int $number): Collection
    {
        if ($number < 0) {
            return $this->slice($number, abs($number));
        }

        return $this->slice(0, $number);
    }

    public function skip(int $count): Collection
    {
        return $this->slice($count);
    }

    public function flip(): Collection
    {
        return new Collection(array_flip($this->items));
    }

    public function shuffle(): Collection
    {
        return new Collection(shuffle($this->items));
    }

    public function group(int $count): Collection
    {
        return $this->chunk($count);
    }

    public function unique(): Collection
    {
        return new Collection(array_unique($this->items));
    }

    public function duplicates(): Collection
    {
        $toReturn = new $this();

        foreach ($this->items as $itemIndex => $item) {
            foreach ($this->items as $copyIndex => $checkCopy) {
                if ($item === $checkCopy && $itemIndex !== $copyIndex) {
                    $toReturn->add($item);
                    break;
                }
            }
        }

        return $toReturn;
    }

    public function sortByValueAsc(): Collection
    {
        $duplicate = $this->items;
        asort($duplicate);
        return new Collection($duplicate);
    }

    public function sortByValueDesc(): Collection
    {
        $duplicate = $this->items;
        arsort($duplicate);
        return new Collection($duplicate);
    }

    public function sortByKeyAsc(): Collection
    {
        $duplicate = $this->items;
        ksort($duplicate);
        return new Collection($duplicate);
    }

    public function sortByKeyDesc(): Collection
    {
        $duplicate = $this->items;
        krsort($duplicate);
        return new Collection($duplicate);
    }

    public function get()
    {
        return $this->items;
    }

    public function add(...$values): Collection
    {
        foreach ($values as $value) {
            $this->items[] = $value;
        }

        return $this;
    }

    public function unshift(...$values): Collection
    {
        foreach ($values as $value) {
            array_unshift($this->items, $value);
        }

        return $this;
    }

    public function count(): int
    {
        return count($this->items);
    }

    private function getArgs($keys): array
    {
        if (is_array($keys[0])) {
            $keys = $keys[0];
        }

        return $keys;
    }
}
