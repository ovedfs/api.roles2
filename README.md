# Aplicación para Manejo de Roles y Permisos desde una API 
- Auntenticación con Sanctum 
- Manejo de Roles y Permisos con el package Spatie Laravel Permissions

## Creamos un CRUD para el manejo de Permisos
- **permission** (index, store, show, update, destroy)
- **roles** (index, store, show, update, destroy)

## Creamos un CRUD para el manejo de Roles
- **Roles**: user, editor, admin, superadmin

## Creamos la funcionalidad para sincronizar Permisos a Roles
```php
$role->permissions()->sync($request->permissions);
```
