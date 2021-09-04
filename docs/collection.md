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
```php
$collect = new Collection(['asd', 'bsd', 'csd']); 
$collect = $collect->first(); //return false if array empty
var_dump($collect);

// string 'asd' (length=3)
```

# `last`
```php
$collect = new Collection(['asd', 'bsd', 'csd']);
$collect = $collect->last(); //return false if array empty
var_dump($collect);

// string 'csd' (length=3)
```

---

# `firstFilter`
Filter is a callback of type `Closure` with the following parameters `$item` & `$key`

```php
$collect = new Collection(['asd', 'bsd', 'csd']);
$collect = $collect->firstFilter(function ($item, $key) {
    return $item === 'bsd';
});
var_dump($collect);

// string 'bsd' (length=3)
```

```php
$collect = new Collection([1,2,3,4,5,6,7,8,9]);
$collect = $collect->firstFilter(function ($item, $key){
    return $item > 2;
});
var_dump($collect);

// int 3
```

> If the collection is empty it returns false

```php
$collect = new Collection([]); //return false
$collect = $collect->firstFilter(function ($item, $key){
    return $item > 2;
});
var_dump($collect);

// boolean false
```

# `lastFilter`
```php
$collect = new Collection(['asd', 'bsd', 'csd']);
$collect = $collect->lastFilter(function ($item, $key) {
    return $item === 'bsd';
});
var_dump($collect);

// string 'bsd' (length=3)
```

```php
$collect = new Collection([1,2,3,4,5,6,7,8,9]);
$collect = $collect->lastFilter(function ($item, $key){
    return $item < 8;
});
var_dump($collect);

// int 7
```

```php
$collect = new Collection([]); //return false
$collect = $collect->lastFilter(function ($item, $key){
    return $item > 2;
});
var_dump($collect);

// boolean false
```
---
# `map`
```php
$collect = new Collection([1,2,3,4,5,6,7,8,9]);
$collect = $collect->map(function ($item, $key) {
    return $item * 2;
});
var_dump($collect->get());

// array (size=9)
//   0 => int 2
//   1 => int 4
//   2 => int 6
//   3 => int 8
//   4 => int 10
//   5 => int 12
//   6 => int 14
//   7 => int 16
//   8 => int 18
```
---
# `filter`
```php
$collect = new Collection([1,2,3,4,5,6,7,8,9]);
$collect = $collect->filter(function ($item, $key) {
    return $item > 5;
});
var_dump($collect->get());

// array (size=4)
//   5 => int 6
//   6 => int 7
//   7 => int 8
//   8 => int 9
```

```php
$collect = new Collection([1, 2, 3, null, false, '', 0, []]);
$collect = $collect->filter();
var_dump($collect->get());

// array (size=3)
//   0 => int 1
//   1 => int 2
//   2 => int 3
```
---
# `only`
```php
$collect = new Collection([
    'name' => 'andrei croitoru',
    'username' => 'endriu3314',
    'age' => 17
]);
$collect = $collect->only(['name', 'age']);
var_dump($collect->get());

// array (size=2)
//   'name' => string 'andrei croitoru' (length=15)
//   'age' => int 17
```
# `except`
```php
$collect = new Collection([
    'name' => 'andrei croitoru', 
    'username' => 'endriu3314', 
    'age' => 17
]);
$collect = $collect->except(['name', 'age']);
var_dump($collect->get());

// array (size=1)
//   'username' => string 'endriu3314' (length=10)
```
---
# `has`
```php
$collect = new Collection([
    'name' => 'andrei croitoru',
    'age' => 17
]);
var_dump($collect->has('name', 'age'));

// boolean true
```

```php
$collect = new Collection([
    'name' => 'andrei croitoru',
    'age' => 17
]);
var_dump($collect->has('namee', 'ae'));

// boolean false
```

```php
$collect = new Collection([
    'name' => 'andrei croitoru',
    'age' => 17
]);
var_dump($collect->has('name', 'ae'));

// boolean false
```
---
# `reverse`
```php
$collect = new Collection([1,2,3,4]);
$collect = $collect->reverse();
var_dump($collect->get());

// array (size=4)
//   0 => int 4
//   1 => int 3
//   2 => int 2
//   3 => int 1
```
---
# `value`
```php
$collect = new Collection([
    'name' => 'andrei croitoru',
    'age' => 17
]);
var_dump($collect->value('name'));
var_dump($collect->get());

// string 'andrei croitoru' (length=15)

// array (size=2)
//   'name' => string 'andrei croitoru' (length=15)
//   'age' => int 17
```

# `values`
```php
$collect = new Collection([
    'name' => 'andrei croitoru', 
    'username' => 'endriu3314', 
    'age' => 17
]);
$collect = $collect->values('name', 'age');
var_dump($collect->get());

// array (size=2)
//   'name' => string 'andrei croitoru' (length=15)
//   'age' => int 17
```
---
# `chunk`
```php
$collect = new Collection([1,2,3,4,5,6,7,8,9]);
$collect = $collect->chunk(3);
var_dump($collect->get());

// array (size=3)
//   0 => 
//     object(App\Core\ORM\Collection)[9]
//       protected 'items' => 
//         array (size=3)
//           0 => int 1
//           1 => int 2
//           2 => int 3
//   1 => 
//     object(App\Core\ORM\Collection)[10]
//       protected 'items' => 
//         array (size=3)
//           3 => int 4
//           4 => int 5
//           5 => int 6
//   2 => 
//     object(App\Core\ORM\Collection)[11]
//       protected 'items' => 
//         array (size=3)
//           6 => int 7
//           7 => int 8
//           8 => int 9
```
# `group`
```php
$collect = new Collection([1,2,3,4,5,6,7,8,9]);
$collect = $collect->group(2);
var_dump($collect->get());

// array (size=5)
//   0 => 
//     object(App\Core\ORM\Collection)[9]
//       protected 'items' => 
//         array (size=2)
//           0 => int 1
//           1 => int 2
//   1 => 
//     object(App\Core\ORM\Collection)[10]
//       protected 'items' => 
//         array (size=2)
//           2 => int 3
//           3 => int 4
//   2 => 
//     object(App\Core\ORM\Collection)[11]
//       protected 'items' => 
//         array (size=2)
//           4 => int 5
//           5 => int 6
//   3 => 
//     object(App\Core\ORM\Collection)[12]
//       protected 'items' => 
//         array (size=2)
//           6 => int 7
//           7 => int 8
//   4 => 
//     object(App\Core\ORM\Collection)[13]
//       protected 'items' => 
//         array (size=1)
//           8 => int 9
```
# `slice`
```php
$collect = new Collection([1,2,3,4,5]);
$collect = $collect->slice(2);
var_dump($collect->get());

// array (size=3)
//   2 => int 3
//   3 => int 4
//   4 => int 5
```

# `slice`
```php
$collect = new Collection([1,2,3,4,5]);
$collect = $collect->slice(-2);
var_dump($collect->get());

// array (size=2)
//   3 => int 4
//   4 => int 5
```

```php
$collect = new Collection([1,2,3,4,5]);
$collect = $collect->slice(-2, 2);
var_dump($collect->get());

// array (size=2)
//   3 => int 4
//   4 => int 5
```

# `take`
```php
$collect = new Collection([1,2,3,4,5,6,7,8,9]);
$collect = $collect->take(3);
var_dump($collect->get());

// array (size=3)
//   0 => int 1
//   1 => int 2
//   2 => int 3
```

```php
$collect = new Collection([1,2,3,4,5,6,7,8,9]);
$collect = $collect->take(-3);
var_dump($collect->get());

// array (size=3)
//   6 => int 7
//   7 => int 8
//   8 => int 9
```

# `skip`
```php
$collect = new Collection([1,2,3,4,5]);
$collect = $collect->skip(2);
var_dump($collect->get());

// array (size=3)
//   2 => int 3
//   3 => int 4
//   4 => int 5
```
---
# `flip`
```php
$collect = new Collection([
    'username' => 'endriu3314', 
    'age' => 17
]);
$collect = $collect->flip();
var_dump($collect->get());

// array (size=2)
//   'endriu3314' => string 'username' (length=8)
//   17 => string 'age' (length=3)
```
---
# `shuffle`
```php
$collect = new Collection([1,2,3,4,5]);
$collect = $collect->shuffle();
var_dump($collect->get());

// array (size=5)
//   0 => int 5
//   1 => int 3
//   2 => int 2
//   3 => int 1
//   4 => int 4
```
---

# `unique`
```php
$collect = new Collection([
    'username' => 'andrei', 
    'andrei', 
    'name' => 'andrei', 
    'hello'
]);
$collect = $collect->unique();
var_dump($collect->get());

// array (size=2)
//   'username' => string 'andrei' (length=6)
//   1 => string 'hello' (length=5)
```

# `duplicates`
```php
$collect = new Collection([
    'andrei', 
    'username' => 'andrei', 
    'andrei', 
    'name' => 'andrei', 
    'hello',
    'xd' => 'hello'
]);
$collect = $collect->duplicates();
var_dump($collect->get());

// array (size=6)
//   0 => string 'andrei' (length=6)
//   1 => string 'andrei' (length=6)
//   2 => string 'andrei' (length=6)
//   3 => string 'andrei' (length=6)
//   4 => string 'hello' (length=5)
//   5 => string 'hello' (length=5)
```
---
# `sortByValueAsc`
```php
$collect = new Collection([
    ['age' => 20],
    ['age' => 17]
]);
$collect = $collect->sortByValueAsc();
var_dump($collect->get());

// array (size=2)
//   1 => 
//     array (size=1)
//       'age' => int 17
//   0 => 
//     array (size=1)
//       'age' => int 20
```

# `sortByValueDesc`
```php
$collect = new Collection([
    ['age' => 13],
    ['age' => 17]
]);
$collect = $collect->sortByValueDesc();
var_dump($collect->get());

// array (size=2)
//   1 => 
//     array (size=1)
//       'age' => int 17
//   0 => 
//     array (size=1)
//       'age' => int 13
```

# `sortByKeyAsc`
```php
$collect = new Collection([
    'xusername' => 'endriu3314', 
    'username' => 'endriu3314'
]);
$collect = $collect->sortByKeyAsc();
var_dump($collect->get());

// array (size=2)
//   'username' => string 'endriu3314' (length=10)
//   'xusername' => string 'endriu3314' (length=10)
```

# `sortByKeyDesc`
```php
$collect = new Collection([
    'username' => 'endriu3314', 
    'xusername' => 'endriu3314'
]);
$collect = $collect->sortByKeyDesc();
var_dump($collect->get());

// array (size=2)
//   'xusername' => string 'endriu3314' (length=10)
//   'username' => string 'endriu3314' (length=10)
```
---
# `add`
```php
$collect = new Collection([1,2,3,4]);
var_dump($collect->add(5,6)->get());

// array (size=6)
//   0 => int 1
//   1 => int 2
//   2 => int 3
//   3 => int 4
//   4 => int 5
//   5 => int 6
```

# `unshift`
```php
$collect = new Collection([2,3,4,5]);
var_dump($collect->unshift(1)->get());

// array (size=5)
//   0 => int 1
//   1 => int 2
//   2 => int 3
//   3 => int 4
//   4 => int 5
```
---
# `count`
```php
$collect = new Collection([1,2,3,4,5]);
var_dump($collect->count());

// int 5
```
