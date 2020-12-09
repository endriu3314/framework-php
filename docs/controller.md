# Controller

## Despre

- Actiuni pentru rute
- Orice controller implementeaza clasa abstracta Controller

---

## Utilizare

`php cli make controller UserController`

---

## Redirect

- Revenire de unde am venit

```php
$this->redirect()->back()->do();
```

- Redirect catre un URL specific

```php
$this->redirect()->url('/dashboard')->do();
```

---

## Validator

- Implementarea validatorului

[Validator](validator.md)

```php
$email = $this->sanitize($_POST['email']);
$password = $this->sanitize($_POST['password']);

$validator = $this->validate([
    $email => 'email',
    $password => 'string,gt:8'
]);

if (!$validator) {
    Template::view('login.html', [
        'errors' => $this->validateErrors
    ]);
    return;
}
```

---

## Functii

# `sanitize`
- Returneaza un string fara HTML si PHP

```php
$this->sanitize($_POST['email']);
```

# `redirect`
- Seteaza proprietatea de redirect pe true
- Controllerul se asteapta sa redirectioneze catre alt URL.

```php
$this->redirect();
```

# `url`
- Seteaza proprietatea de url catre care se face redirect

```php
$this->redirect()->url('/dashboard');
```

# `back`
- In caz ca nu vrei sa mergi catre un anumit URL si vrei sa te intorci de unde ai venit

```php
$this->redirect()->back();
```

# `do`
- Execute redirectul

```php
$this->redirect()->back()->do();
```

# `validate`
- Implementare pentru Validator
- Se trimite ca parametru un array cu valoarea ca cheie si conditiile
- Returneaza boolean cu statusul validarii

[Validator](validator.md)

```php
$this->validate([
    $this->sanitize($_POST['email']) => 'email'
]);
```
