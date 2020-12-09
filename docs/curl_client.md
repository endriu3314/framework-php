# CURL Client

## Despre

- Clasa pentru requesturile CURL de tip GET & POST.

## Utilizare

```php
$req = new Request();
$req->setUrl('https://postman-echo.com/get?foo1=bar1&foo2=bar2')
    ->get();
```

## Functii
# `setUrl` 
- Seteaza URL catre care se v-a face request

```php
$req->setUrl('https://postman-echo.com/get?foo1=bar1&foo2=bar2');
```

---

# `setHeader` 
- Seteaza Headeruri pentru request, de exemplu Bearer token pentru autentificare

```php
$req->setHeader('Bearer TOKEN');
```

---

# `setBody` 
- Seteaza body pentru request, requesturile de tip POST

```php
$req->setBody([
    'username' => 'test',
    'password' => 'password'
]);
```

---

# `setOptions` 
- Seteaza setari de tip curl pentru php

```php
$req->setOptions([
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true
]);
```

---

# `post` 
- Ruleaza un curl de tip POST cu parametrii deja setati

```php
$req->post();
```

---

# `get` 
- Ruleaza un curl de tip GET cu parametrii deja setati

```php
$req->get();
```

## POST request
```php
$req = new Request();
$req->setUrl('https://postman-echo.com/post')
    ->setBody([
        'username' => 'test',
        'password' => 'password'
    ])->post();
```

## GET request
```php
$req = new Request();
$req->setUrl('https://postman-echo.com/get?foo1=bar1&foo2=bar2')
    ->get();
```
