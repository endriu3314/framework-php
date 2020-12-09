# Middleware

## Despre

- Se executa intre request si actiunea din controller
- Se poate folosii la protejarea rutelor
- Extinde clasa abstractizata `App\Core\Middleware`

---

## Utilizare 

`php cli make middleware TestMiddleware`

- Functia `run()` se va executa la rularea unui Middleware.
- Functii ajutatoare se pot construii in interiorul unui Middleware.

---

## Template

```php
namespace App\Http\Middleware;

use App\Core\Middleware;

class TestMiddleware extends Middleware
{
    public function run(): void
    {
        if (true == false) {
            $this->redirect('/login', 303);
        }
    }
}
```

---

## Functii

# `redirect`
- Accepta 2 parametrii
    - `$url` Reprezinta URL catre care se va face redirect
    - `$statusCode = 303` Default 303 reprezinta HTTP Status Code de redirect
    
```php
$this->redirect('/test/', 404);
```

# `run`
- Reprezinta functia ce se va executa la fiecare request pana sa ajunga la Controller

```php
public function run(): void
{
    //logic
    $this->redirect('/login');
}
```
