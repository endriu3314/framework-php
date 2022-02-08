# File Helper

## Despre

- Clasa pentru lucrul cu fisere.
- Functiile sunt statice.

## Utilizare

```php
$files = \AndreiCroitoru\FrameworkPhp\Helpers\FileHelper::getFilesRecursive('./Commands');
```

## Functii
# `getFiles`
- Scaneaza folderul in calea data ca parametru
- Returneaza array cu fisierele
- `$path` - parametru de tip **string** cu calea folderului

```php
$files = \AndreiCroitoru\FrameworkPhp\Helpers\FileHelper::getFiles('./Commands');
```

**Raspuns**
```php
array(4) {
  [0]=>
  string(8) "Auth.php"
  [1]=>
  string(8) "Help.php"
  [2]=>
  string(8) "Make.php"
  [3]=>
  string(11) "Migrate.php"
}
```

---

# `getFilesRecursive`
- Scaneaza recursiv in toate folderele regasite in calea data ca parametru
-  Returneaza array cu fisierele
- `$path` - parametru de tip **string** cu calea folderului

```php
$files = \AndreiCroitoru\FrameworkPhp\Helpers\FileHelper::getFilesRecursive('./Commands');
```

**Raspuns**
```php
array(28) {
  [0]=>
  string(20) "AndreiCroitoru\FrameworkPhp\CLI\CLI.php"
  [1]=>
  string(26) "AndreiCroitoru\FrameworkPhp\CLI\CLIHelper.php"
  [2]=>
  string(23) "AndreiCroitoru\FrameworkPhp\CLI\Colors.php"
  [3]=>
  string(34) "AndreiCroitoru\FrameworkPhp\CLI\CommandController.php"
  [4]=>
  string(32) "AndreiCroitoru\FrameworkPhp\CLI\CommandRegistry.php"
  [5]=>
  string(57) "AndreiCroitoru\FrameworkPhp\CLI\Commands\auth\Controller\LoginController.php"
  ...
}
```
