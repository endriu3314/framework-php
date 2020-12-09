# Model

## Despre

- 

---

## Utilizare

`php cli make model User`

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

## ORM

- Cu utilitatea ORM (Object Relational Mapping) se creaza modele pentru fiecare tabel din baza de date avand functii pentru metode CRUD.

# `create`

```php
$user = new User();

$user->username = 'andrei';
$user->password = hash('sha256', $_POST['password']);

$user->create();
```

---

# `update`
- Returneaza bool 

```php
$user = new User();

$user->id = 1;
$user->username = 'andre_updated';

$user->update();
```

---

# `delete`
- Returneaza bool

```php
$user = new User();
$user->id=1;
$user->delete();
```

---

# `first`
- Returneaza prima valoare din tabel

```php
$user = new User();
$user = $user->first();
```

--- 

# `last`
- Returneaza ultima valoare din tabel

```php
$user = new User();
$user = $user->last();
```

---

# `find`
- Cauta element dupa PK

```php
$user = new User();
$user = $user->find(1);
```
