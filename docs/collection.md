# Collection

## Despre

- Clasa cu functii suplimentare fata de un array

---

## Utilizare

- [`first`](#first) - Get value of the first element in Collection
- [`last`](#last) - Get value of the last element in Collection
- [`firstFiler`](#firstFiler) - Get value of the first element in Collection, with a Closure callback
- [`lastFiler`](#lastFiler) - Get value of the last element in Collection, with a Closure callback
- [`map`](#map) - Modify each value trough a Closure callback
- [`filter`](#filter) - Filter items with a Closure callback
- [`only`](#only) - Returns a new Collection including only requested values from Collection
- [`except`](#except) - Returns a new Collection without the requested values from Collection
- [`has`](#has) - Check if one or multiple Collection key exists
- [`value`](#value) - Get value of key from Collection
- [`values`](#values) - Get value of keys from Collection
- [`chunk`](#chunk) - Transform a Collection into multiple Collections of a certain size
- [`slice`](#slice) - Return a new Collection removing a number of elements from Collection
- [`take`](#take) - Return a new Collection with a number of elements
- [`skip`](#skip) - Return a new Collection skipping the first x elements
- [`flip`](#flip) - Return a new Collection with values swaped with keys
- [`shuffle`](#shuffle) - Return a new Collection but shuffled
- [`group`](#group) - Alias for chunk
- [`unique`](#unique) - Return a new Collection with unique elements
- [`duplicates`](#duplicates) - Return a new Collection, only with duplicates
- [`sortByValueAsc`](#sortByValueAsc) - Sorts Collection by Value
- [`sortByValueDesc`](#sortByValueDesc) - Sorts Collection by Value, Reverse
- [`sortByKeyAsc`](#sortByKeyAsc) - Sorts Collection by Keys
- [`sortByKeyDesc`](#sortByKeyDesc) - Sorts Colleciton by Keys, Reverse
- [`add`](#add) - Add elements to end of Collection
- [`unshift`](#unshift) - Add elements to start of Collection

---

# `first`

Valoarea primului element din colectie.

```php
$collect = new Collection(['asd', 'bsd', 'csd']); 
$collect = $collect->first(); //return false if array empty
var_dump($collect);
```

```php
string 'asd' (length=3)
```

---

# `last`

Valoarea ultimului element din colectie.

```php
$collect = new Collection(['asd', 'bsd', 'csd']);
$collect = $collect->last(); //return false if array empty
var_dump($collect);
```

```php
string 'csd' (length=3)
```

---

# `firstFilter`

Valoarea primului element din colectie care respecta filtrul aplicat.

Filtrul este un callback de tip `Closure` cu parametrii `$item` & `$key`

```php
$collect = new Collection(['asd', 'bsd', 'csd']);
$collect = $collect->firstFilter(function ($item, $key) {
    return $item === 'bsd';
});
var_dump($collect);
```

```php
string 'bsd' (length=3)
```

```php
$collect = new Collection([1,2,3,4,5,6,7,8,9]);
$collect = $collect->firstFilter(function ($item, $key){
    return $item > 2;
});
var_dump($collect);
```

```php
int 3
```

> In cazul unei colectii goale, returneaza false

```php
$collect = new Collection([]); //return false
$collect = $collect->firstFilter(function ($item, $key){
    return $item > 2;
});
var_dump($collect);
```

```php
boolean false
```

# `lastFilter`
```php
$collect = new Collection(['asd', 'bsd', 'csd']);
$collect = $collect->lastFilter(function ($item, $key) {
    return $item === 'bsd';
});
var_dump($collect);
```

```php
$collect = new Collection([1,2,3,4,5,6,7,8,9]);
$collect = $collect->lastFilter(function ($item, $key){
    return $item < 8;
});
var_dump($collect);
```

```php
$collect = new Collection([]); //return false
$collect = $collect->lastFilter(function ($item, $key){
    return $item > 2;
});
var_dump($collect);
```

# `map`
```php
$collect = new Collection([1,2,3,4,5,6,7,8,9]);
$collect = $collect->map(function ($item, $key) {
    return $item * 2;
});
var_dump($collect->get());
```

# `filter`
```php
$collect = new Collection([1,2,3,4,5,6,7,8,9]);
$collect = $collect->filter(function ($item, $key) {
    return $item > 5;
});
var_dump($collect->get());
```

```php
$collect = new Collection([1, 2, 3, null, false, '', 0, []]);
$collect = $collect->filter();
var_dump($collect->get());
```

# `only`
```php
$collect = new Collection(['name' => 'andrei croitoru', 'username' => 'endriu3314', 'age' => 17]);
$collect = $collect->only(['name', 'age']);
var_dump($collect->get());
```

# `except`
```php
$collect = new Collection(['name' => 'andrei croitoru', 'username' => 'endriu3314', 'age' => 17]);
$collect = $collect->except(['name', 'age']);
var_dump($collect->get());
```

# `has`
```php
$collect = new Collection(['name' => 'andrei croitoru', 'age' => 17]);
var_dump($collect->has('name', 'age'));
```

```php
$collect = new Collection(['name' => 'andrei croitoru', 'age' => 17]);
var_dump($collect->has('namee', 'ae'));
```

```php
$collect = new Collection(['name' => 'andrei croitoru', 'age' => 17]);
var_dump($collect->has('name', 'ae'));
```

# `reverse`
```php
$collect = new Collection([1,2,3,4]);
$collect = $collect->reverse();
var_dump($collect->get());
```

# `value`
```php
$collect = new Collection(['name' => 'andrei croitoru', 'age' => 17]);
var_dump($collect->value('name'));
var_dump($collect->get());
```

# `values`
```php
$collect = new Collection(['name' => 'andrei croitoru', 'username' => 'endriu3314', 'age' => 17]);
$collect = $collect->values('name', 'age');
var_dump($collect->get());
```

# `chunk`
```php
$collect = new Collection([1,2,3,4,5,6,7,8,9]);
$collect = $collect->chunk(3);
var_dump($collect->get());
```

# `slice`
```php
$collect = new Collection([1,2,3,4,5]);
$collect = $collect->slice(2);
var_dump($collect->get());
```

# `slice`
```php
$collect = new Collection([1,2,3,4,5]);
$collect = $collect->slice(-2);
var_dump($collect->get());
```

```php
$collect = new Collection([1,2,3,4,5]);
$collect = $collect->slice(-2, 2);
var_dump($collect->get());
```

# `take`
```php
$collect = new Collection([1,2,3,4,5,6,7,8,9]);
$collect = $collect->take(3);
var_dump($collect->get());
```

```php
$collect = new Collection([1,2,3,4,5,6,7,8,9]);
$collect = $collect->take(-3);
var_dump($collect->get());
```

# `skip`
```php
$collect = new Collection([1,2,3,4,5]);
$collect = $collect->skip(2);
var_dump($collect->get());
```

# `flip`
```php
$collect = new Collection(['username' => 'endriu3314', 'age' => 17]);
$collect = $collect->flip();
var_dump($collect->get());
```

# `shuffle`
```php
$collect = new Collection([1,2,3,4,5]);
$collect = $collect->shuffle();
var_dump($collect->get());
```

# `group`
```php
$collect = new Collection([1,2,3,4,5,6,7,8,9]);
$collect = $collect->group(2);
var_dump($collect->get());
```

# `unique`
```php
$collect = new Collection(['username' => 'andrei', 'andrei', 'name' => 'andrei', 'hello']);
$collect = $collect->unique();
var_dump($collect->get());
```

# `duplicates`
```php
$collect = new Collection(['andrei', 'username' => 'andrei', 'andrei', 'name' => 'andrei', 'hello', 'xd' => 'hello']);
$collect = $collect->duplicates();
var_dump($collect->get());
```

# `sortByValueAsc`
```php
$collect = new Collection([
    ['age' => 20],
    ['age' => 17]
]);
$collect = $collect->sortByValueAsc();
var_dump($collect->get());
```

# `sortByValueDesc`
```php
$collect = new Collection([
    ['age' => 13],
    ['age' => 17]
]);
$collect = $collect->sortByValueDesc();
var_dump($collect->get());
```

# `sortByKeyAsc`
```php
$collect = new Collection(['xusername' => 'endriu3314', 'username' => 'endriu3314']);
$collect = $collect->sortByKeyAsc();
var_dump($collect->get());
```

# `sortByKeyDesc`
```php
$collect = new Collection(['username' => 'endriu3314', 'xusername' => 'endriu3314']);
$collect = $collect->sortByKeyDesc();
var_dump($collect->get());
```

# `add`
```php
$collect = new Collection([1,2,3,4]);
var_dump($collect->add(5,6)->get());
```

# `unshift`
```php
$collect = new Collection([2,3,4,5]);
var_dump($collect->unshift(1)->get());
```

# `count`
```php
$collect = new Collection([1,2,3,4,5]);
var_dump($collect->count());
```
