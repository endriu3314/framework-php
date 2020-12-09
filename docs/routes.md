# Router

## Despre

- Defineste rutele existente si redirectioneaza catre controller.
- Returneaza 404 pentru paginii care nu exista.
- Foloseste un fisier .yml pentru declararea rutelor.
- `php_yaml` is required

## Utilizare

`routes.yml`
```yaml
routes:
  home:
    url: /
    method: GET
    controller: App\Http\Controllers\HomeController
    action: homeView
```

## Proprietati
- `url` - URL
- `method` - Metoda HTTP
- `middleware` - Middleware ce se executa intre request si controller
- `controller` - Controller
- `action` - Functia din controller

## Ruta cu actiune
```yaml
routes:
  home:
    url: /
    method: GET
    controller: App\Http\Controllers\HomeController
    action: homeView
```

## Ruta cu middleware
- Foloseste un middleware pentru a filtra cererile inainte de a ajunge la controller
```yaml
routes:
  dashboard-view:
    url: /dashboard
    method: GET
    middleware: App\Http\Middleware\AuthMiddleware
    controller: App\Http\Controllers\Auth\UserController
    action: dashboardView
```
