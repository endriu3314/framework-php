# Router

- [`about`](routes.md#about)
- [`file`](routes.md#file)
- [`example`](routes.md#example)

### `about` [:up:](#Router)

- The router is a feature letting you define existing routes, and returning 404 for non-existing routes. It uses a .yml file for declaration of routes. 

- Installing the YAML PHP Extension is required.

### `file` [:up:](#Router)

File has to be called `routes.yml` and has to be at the tree of the project.

### `example` [:up:](#Router)

Route with **only a view**

```yaml
routes:
    ...
    home:
        url: /
        method: GET
        view: ..\..\HomeView
    ...
```

Route with **action**

```yaml
routes:
    ...
    home-submit:
        url: /submit
        method: POST
        model: ..\..\Model
        view: ..\..\HomeView
        controller: ..\..\Controller
    ...
```