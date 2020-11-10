# Validator

- [`about`](validator.md#about)
- [`basic usage`](<validator.md#basic usage>)
- [`types`](validator.md#types)
- [`conditions`](validator.md#conditions)

### `about` [:up:](#Validator)

- The validator is a feature letting you validate a data. It will always return a boolean meaning the state of validation, true, it succeded or false, it failed.

### `basic usage` [:up:](#Validator)

```php
Validator::is(1, "int");
# return true

Validator::is("a.croitoru3@icloud.com", "email");
# return true

Validator::is("string", "int");
# return false
```

### `types` [:up:](#Validator)

- Available types
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
- `numeric` - Either `int` or `float` or a `string` representing a number
- `number` - Either `int` or `float`
- `class`
- `interface`
- `trait`

### `conditions` [:up:](#Validator)

**Best used with is function**

*Can be used independent*

<br/>

> Strings will count it's length unless declared as a `numeric`

> Arrays will count elements

<br/>

- **Greater than**
`greaterThan`

Compares two values with `>`

```php
Validator::is(6, "int,gt:5");
# return true

Validator::is(6, "int,gt:6");
# return false
```

<br/>

- **Greater than equal**
`greaterThanEqual`

Compares two values with `>=`

```php
Validator::is(6, "int,gt:6");
# return true
```

<br/>

- **Lower than**
`lowerThan`

Compares two values with `<`

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

<br/>

- **Lower than equal**
`lowerThanEqual`

Compares two values with `<=`

```php
Validator::is(6, "int,blwe:6");
# return true

Validator::is(6, "int,sme:6");
# return true
```

<br/>

- **Equal**
`equal`

Compares two values with `=`

```php
Validator::is(6, "int,eq:6");
# return true
```