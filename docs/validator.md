# Validator

## Despre

- O clasa care te ajuta la validarea datelor
- Returneaza boolean 

---

# Utilizare

```php
Validator::is(1, "int"); 
# return true

Validator::is("a.croitoru3@icloud.com", "email"); 
# return true

Validator::is("string", "int"); 
# return false
```

---

# Tipuri valabile

- `array`
- `bool` \ `boolean`
- `float`
- `int` \ `integer`
- `null`
- `object`
- `string`
- `file`
- `directory`
- `URL`
- `IPv4`
- `IPv6`
- `email`
- `numeric` - `int` sau `float` sau `string` care reprezinta un numar
- `number` - `int` sau `float`
- `class`
- `interface`
- `trait`

---

# Conditii

> Pentru stringuri se va folosii numarul de caractere daca nu este declarat de tip `numeric`

> Pentru arrayuri se va folosii numarul de elemente

# `greaterThan`

Compara doua valori cu operatorul `>`

```php
Validator::is(6, "int,gt:5");
# return true

Validator::is(6, "int,gt:6");
# return false
```

---

# `greaterThanEqual`
- Compara doua valori cu operatorul `>=`

```php
Validator::is(6, "int,gt:6");
# return true
```

---

# `lowerThan`
- Compara doua valori cu operatorul `<`

```php
Validator::is(6, "int,blw:7");
# return true

Validator::is(6, "int,sm:7");
# return true

Validator::is(6, "int,max:7");
# return true

Validator::is(6, "int,sm:6");
# return false
```

---

# `lowerThanEqual`
- Compara doua valori cu operatorul `<=`

```php
Validator::is(6, "int,blwe:6");
# return true

Validator::is(6, "int,sme:6");
# return true
```

---

# `equal`
- Compara doua valori cu operatorul `=`

```php
Validator::is(6, "int,eq:6");
# return true
```
