# Schema

## Despre

- Create migratii pentru tabele in baza de date

`php cli migrate`

Calea default catre migratii este `App/Migrations`, in acest caz parametrul este optional.

- In caz ca nu se foloseste calea default se adauga parametru cu calea

`php cli migrate App/CustomMigrationsFolder`

---

## Utilizare

Creare migratie noua

`php cli make migration books`

- In folderul `App/Migrations` o sa se creeze un nou fisier `TIMESTAMP_books`

```php
$schema = new Schema();

$schema->create('books', function ($table) {
    $table->BIGINT('id')->primaryKey()->autoIncrement();

})->generate();
```

---

# `type`

- Utilizare `$table->TYPE('column_name', maxValue);`

Exemplu:
```php
$table->VARCHAR('username', 144);
```

---

# `primaryKey`

- Seteaza o coloana ca PK

Exemplu:
```php
$table->BIGINT('id')->primaryKey();
```

---

# `autoIncrement`

- Seteaza AI pentru o coloana

Exemplu:
```php
$table->BIGINT('id')->autoIncrement();
```

---

# `nullable`

- Face o coloana nullable

Exemplu:
```php
$table->VARCHAR('description', 144)->nullable()
```

---

# `defaultValue`

- Seteaza o valoare default pentru o coloana

Exemplu:
```php
$table->TIMESTAMP('register_at')->defaultValue('CURRENT_TIMESTAMP');
```

---

# `unique`

- Seteaza o coloana sa aiba o cheie de tip unica

Exemplu:
```php
$table->VARCHAR('email', 144)->unique();
```

---

# `foreignKey`

- Seteaza coloana ca FK
- Daca o coloana este setata ca FK, nu mai poate fi PK

Exemplu:
```php
$table->BIGINT('user_id')->foreignKey()->references('users.id');
```

---

# `onUpdate`

- Seteaza actiune de ON UPDATE pentru o coloana

Exemplu:
```php
$table->BIGINT('user_id')->foreignKey()->references('users.id')->onUpdate('cascade');
```

---

# `onDelete`

- Seteaza actiune de ON DELETE pentru o coloana

Exemplu:
```php
$table->BIGINT('user_id')->foreignKey()->references('users.id')->onDelete('cascade');
```
