# String Helper

## Despre

- Clasa pentru lucrul cu stringuri.
- Functiile sunt statice

---

## Utilizare

```php
$className = \AndreiCroitoru\FrameworkPhp\Helpers\StringHelper::removeExtension($classFile);
```

---

## Functii
# `toCamelCase`
- Returneaza un string din snake_case in camelCase
- `$string` - parametru de tip **string** reprezinta stringul de tip snake_case ce trebuie convertit
    
```php
\AndreiCroitoru\FrameworkPhp\Helpers\StringHelper::toCamelCase('snake_case');
```   

**Raspuns**

```php
string(9) "snakeCase"
````

---

# `removeExtension`
- Sterge extensia unui fisier dintr-un string
- `$string` - parametru de tip **string** reprezinta numele fisierului cu extensie
    
```php
\AndreiCroitoru\FrameworkPhp\Helpers\StringHelper::removeExtension('App.php');
```

**Raspuns**

```php
string(3) "App"
```

---

# `removeLastOccurrence`
- Sterge ultima aparitie a unui parametru intr-un string
- `$string` - parametru de tip **string** reprezinta stringul in care se face cautarea
- `$toRemove` - parametru de tip **string** reprezinta partea stringului care se cauta pentru a fi stearsa
- Returneaza stringul care exclude parametrul toRemove.

```php
\AndreiCroitoru\FrameworkPhp\Helpers\StringHelper::removeLastOccurrence('App.php.class', '.');
``` 

**Raspuns**
```php
string(12) "App.phpclass"
```

---

# `getFileNameFromPath`
- Returneaza numele fisierului dintr-o cale
- `$path` - parametru de tip **string** reprezinta calea catre fisier
- `$extension` - parametru de tip **string** reprezinta extensia fisierului

```php
\AndreiCroitoru\FrameworkPhp\Helpers\StringHelper::getFileNameFromPath('AndreiCroitoru\FrameworkPhp\App.php.class', '.class');
```

**Raspuns**
```php
string(7) "App.php"
```

```php
\AndreiCroitoru\FrameworkPhp\Helpers\StringHelper::getFileNameFromPath('AndreiCroitoru\FrameworkPhp\App.php.class', '.php');
```

**Raspuns**
```php
string(13) "App.php.class"
```
