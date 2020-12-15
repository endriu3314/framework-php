# Model

## Despre

- 

---

## Utilizare

`php cli make model User`

```php
$users = new User();
$users = $users->all()->do()->get();

foreach ($users as $user) {
    var_dump($user->id);
}
```

---

## Template

- Fiecare clasa continue 2 atribute private statice
    - `$tableName` Reprezinta numele tabelului in baza de date
    - `$primaryKey` Reprezinta PK al tabelului, default este id
    
- Pe langa acele atribute, pentru fiecare coloana exista un atribut public cu numele coloanei

```php
class User extends Model
{
    private static $tableName = 'users';
    private static $primaryKey = 'id';
    
    public $id;
    public $username;
    public $email;
}
```

---

## Models

# `collections`

Functia de select `all()` returneaza mai multe valori din baza de date.
In loc sa intoarca inapoi un array returneaza o instanta de `App\Core\ORM\Collection`.

Se foloseste clasa `Collection` pentru a avea access la functii de filtrare si de manipulare a datelor precum `reverse()`

```php
$users = new User();
$users = $users->all()->do()->get();
```

#### Functii

> `get()` trebuie adaugat pentru a returna valoriile din colectie
- `get()` Returneaza valoriile din colectie

- `reverse()` Invarte colectia

- `count()` Numara elementele din colectie

---

> Fiecare comanda de manipulare a datelor trebuie urmata de `do()` pentru executare

# `insert`

Salveaza in baza de date

Returneaza `bool` in functie de statusul insertiei

```php
$user = new User();
$user->username = "andrei";
$user->email = "a.croitoru3@icloud.com";
$user->password = password_hash('1235678', PASSWORD_BCRYPT);
$user->create()->do();
```

---

# `update`

Updateaza o valoare din baza de date

Returneaza `bool` in functie de statusul updatelui

```php
$user = new User();
$user->id = 6;
$user->username = "updated_andrei";
$user->update()->do();
```

Alternativ se poate folosii where pentru mass-update normal, adaugand doar PK in clauza

```php
$user = new User();
$user->username = "updated_andrei";
$user->update()->where('id', '=', 6)->do();
```

```php
$user = new User();
$user->activated = false;
$user->update()->where('id', '>', 3)->do();
```

---

# `delete`

Sterge o valoare din baza de date

Returneaza `bool` in functie de statusul stergerii

```php
$user = new User();
$user->id = 6;
$user->delete()->do();
```

Ca la `update`, se poate folosii clauza where pentru mass-delete sau pentru a adauga conditia de PK

```php
$user = new User();
$user->delete()->where('id', '=', '6')->do();
```

```php
$user = new User();
$user->delete()->where('id', '>=', 3)->do();
```

---

# `where`

Where se poate adauga la orice interogare, de cate ori este necesar

Adaugarea unui `where()` nou se va face prin apenduire cu `AND`

Daca dorim appenduire cu `OR` avem varianta `whereOr()`

```php
$users = new User();
$users = $users->all()
    ->where('id', '>=', 1)
    ->where('id', '<', 4)
    ->do()->reverse()->get();
```

```php
$users = new User();
$users = $users->all()
    ->where('id', '>', 1)
    ->whereOr('username', '=', 'andrei')
    ->do()->get();
```
