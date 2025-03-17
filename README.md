# API para Sistema de Ventas

Esta es una API RESTful desarrollada con Laravel para la gestión de productos, categorías y pedidos. La API implementa autenticación mediante Laravel Sanctum para proteger los endpoints y garantizar el acceso seguro a los recursos. Además, se han definido relaciones Many-to-One y Many-to-Many entre entidades utilizando Eloquent ORM, asegurando la integridad y eficiencia en el acceso a los datos.

## Características principales

- **Gestión de Productos**: Crear, leer, actualizar y eliminar productos.
    
- **Gestión de Categorías**: Crear, leer, actualizar y eliminar categorías.
    
- **Gestión de Pedidos**: Crear, leer, actualizar y eliminar pedidos.
    
- **Autenticación**: Protección de endpoints mediante Laravel Sanctum.
    
- **Validaciones**: Uso de Form Requests para validaciones de datos.
    
- **Manejo de excepciones**: Respuestas personalizadas para errores comunes.
    
- **Relaciones**:
    
    - Un producto pertenece a una categoría (Many-to-One).
        
    - Un pedido puede tener múltiples productos (Many-to-Many).
        

## Requisitos

- PHP >= 8.0
    
- Laravel >= 9.0
    
- Composer
    
- Base de datos (MySQL, PostgreSQL, SQLite, etc.)
    
- Laravel Sanctum (para autenticación)
    

## Instalación

1. Clona el repositorio:

```bash
git clone https://github.com/tu-usuario/tu-repositorio.git
cd tu-repositorio
```
    
2. Instala las dependencias:
``` bash
composer install
```

3. Configura el archivo `.env`:
    
    - Copia el archivo `.env.example` a `.env`.
        
    - Configura las variables de entorno, especialmente las relacionadas con la base de datos.
        
4. Genera la clave de la aplicación:
``` bash
php artisan key:generate
```
    
5. Ejecuta las migraciones y seeders:
``` bash
php artisan migrate --seed
```   
    
6. Instala Laravel Sanctum:
``` bash
php artisan sanctum:install
```  
    
7. Inicia el servidor de desarrollo:
``` bash
php artisan serve
```


## Autenticación

La API utiliza Laravel Sanctum para la autenticación. Para acceder a los endpoints protegidos, debes:

1. Registrar un usuario:
    
    - **Endpoint**: `POST /api/register`
        
    - **Body**:
    
        ```json     
        {
          "name": "Nombre del usuario",
          "email": "usuario@example.com",
          "password": "contraseña",
          "password_confirmation": "contraseña"
        }
        ```

2. Iniciar sesión:
    
    - **Endpoint**: `POST /api/login`
        
    - **Body**:
    
        ```json
        {
          "email": "usuario@example.com",
          "password": "contraseña"
        }
        ```
        
    - **Respuesta**: Se devolverá un token de autenticación que debes incluir en el encabezado `Authorization` de las solicitudes protegidas.
        
3. Cerrar sesión:
    
    - **Endpoint**: `POST /api/logout`
        
    - **Headers**: `Authorization: Bearer {token}`
     

## Endpoints

### Productos

- **Obtener todos los productos**: `GET /api/products`
    
- **Obtener un producto por ID**: `GET /api/products/{id}`
    
- **Crear un producto**: `POST /api/products`
    
- **Actualizar un producto**: `PUT /api/products/{id}`
    
- **Eliminar un producto**: `DELETE /api/products/{id}`
    

### Categorías

- **Obtener todas las categorías**: `GET /api/categories`
    
- **Obtener una categoría por ID**: `GET /api/categories/{id}`
    
- **Crear una categoría**: `POST /api/categories`
    
- **Actualizar una categoría**: `PUT /api/categories/{id}`
    
- **Eliminar una categoría**: `DELETE /api/categories/{id}`
    

### Pedidos

- **Obtener todos los pedidos**: `GET /api/orders`
    
- **Obtener un pedido por ID**: `GET /api/orders/{id}`
    
- **Crear un pedido**: `POST /api/orders`
    
- **Actualizar un pedido**: `PUT /api/orders/{id}`
    
- **Eliminar un pedido**: `DELETE /api/orders/{id}`
    

### Ítems de Pedidos

- **Obtener todos los ítems de un pedido**: `GET /api/order-items`
    
- **Agregar un ítem a un pedido**: `POST /api/order-items`
    
- **Actualizar un ítem de un pedido**: `PUT /api/order-items/{id}`
    
- **Eliminar un ítem de un pedido**: `DELETE /api/order-items/{id}`
    

## Ejemplos de Uso

### Crear un producto

**Request**:

```json
    POST /api/products
    Headers:
        Authorization: Bearer {token}
        Content-Type: application/json
    Body:
    {
        "name": "Producto 1",
        "price": 100.00,
        "category_id": 1
    }
```

**Response**:

```json

{
    "success": true,
    "message": "Producto creado correctamente",
    "data": {
        "id": 1,
        "name": "Producto 1",
        "price": 100.00,
        "category_id": 1,
        "created_at": "2023-10-01T12:00:00.000000Z",
        "updated_at": "2023-10-01T12:00:00.000000Z"
    }
}
```

## Contribución

Si deseas contribuir a este proyecto, sigue estos pasos:

1. Haz un fork del repositorio.
    
2. Crea una nueva rama (`git checkout -b feature/nueva-funcionalidad`).
    
3. Realiza tus cambios y haz commit (`git commit -am 'Añade nueva funcionalidad'`).
    
4. Haz push a la rama (`git push origin feature/nueva-funcionalidad`).
    
5. Abre un Pull Request.
    

## Licencia

Este proyecto está bajo la licencia MIT. Consulta el archivo `LICENSE` para más detalles.