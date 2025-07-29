# Microservicio D2A

Microservicio PHP para integración con la plataforma de pagos D2A.

## Estructura del Proyecto

```
Nube_d2a_microservicio/
│── public/
│    └── index.php          # Punto de entrada, router
│── src/
│    ├── Controllers/       # Controladores para cada endpoint
│    │   ├── CheckoutController.php
│    │   └── WebhookController.php
│    ├── Services/          # Lógica de negocio (D2A, Webhooks)
│    │   ├── D2AService.php
│    │   └── WebhookService.php
│    ├── Models/            # Modelos simples (Checkout, Orden)
│    │   ├── Checkout.php
│    │   └── Orden.php
│    ├── Helpers/           # Funciones auxiliares
│    │   └── Logger.php
│    └── Config/            # Configuración
│        └── config.php
│── storage/
│    ├── logs/              # Logs
│    └── tmp/               # Datos temporales🚀 1. Requisitos
PHP 8+ (ya lo tenés en XAMPP).

Extensión cURL habilitada (viene en XAMPP por defecto).

Carpeta htdocs para colocar el proyecto.

📂 2. Estructura del proyecto
pgsql

d2a-hub/
│── public/
│    └── index.php
│── src/
│    ├── Controllers/
│    ├── Services/
│    ├── Repositories/
│    └── Config/
│── storage/
│    ├── logs/
│    └── tmp/
│── composer.json
🔌 3. Instalar en XAMPP
1️⃣ Copiá la carpeta d2a-hub dentro de C:/xampp/htdocs/.
2️⃣ La URL de tu microservicio local va a ser:

bash

http://localhost/d2a-hub/public/
▶️ 4. Endpoints
A. /checkout-temp
📌 Recibe datos del Checkout SDK y crea un evento inicial en D2A.
Método: POST
URL: http://localhost/d2a-hub/public/checkout-temp
Body (JSON ejemplo):

json

{
  "checkout_id": "abc123",
  "store_id": 456,
  "payment": { "gateway": "mercadopago", "installments": 6 },
  "cart": [
    { "sku": "PROD1", "qty": 2, "price": 1000 }
  ]
}
✅ Qué hace:

Guarda checkout_abc123.json en /storage/tmp/.

Envía a D2A un evento checkout_iniciado.

B. /webhook
📌 Recibe webhooks de Tiendanube (order/created, order/paid).
Método: POST
URL: http://localhost/d2a-hub/public/webhook
Body (JSON ejemplo order/created):

json

{
  "event": "order/created",
  "id": 999,
  "store_id": 456,
  "checkout": { "id": "abc123" },
  "payment_details": { "gateway": "mercadopago", "installments": 6 },
  "customer": { "email": "cliente@test.com" }
}
✅ Qué hace:

Busca checkout_abc123.json.

Une datos de carrito y payment.

Envía a D2A un evento checkout_confirmado.

Body (JSON ejemplo order/paid):

json

{
  "event": "order/paid",
  "id": 999,
  "store_id": 456
}
✅ Qué hace:

Envía a D2A un evento pago_aprobado.

🛠️ 5. Probar con Postman o cURL
A. Test /checkout-temp:
bash

curl -X POST http://localhost/d2a-hub/public/checkout-temp \
-H "Content-Type: application/json" \
-d '{"checkout_id":"abc123","store_id":456,"payment":{"gateway":"mp","installments":3},"cart":[{"sku":"P1","qty":1}]}'
B. Test /webhook:
bash

curl -X POST http://localhost/d2a-hub/public/webhook \
-H "Content-Type: application/json" \
-d '{"event":"order/created","id":999,"store_id":456,"checkout":{"id":"abc123"},"payment_details":{"gateway":"mp"}}'
✅ Después de correr estos tests, mirá:

/storage/tmp/checkout_abc123.json → Datos guardados.

/storage/logs/d2a.log → Eventos enviados a D2A.

/storage/logs/webhooks.log → Logs de webhooks.

📌 6. Configuración de D2A
En src/Services/D2AService.php podés cambiar la URL de la API de D2A:

php

$this->apiUrl = "https://api.d2a.com/event";
│── composer.json
└── README.md
```

## Requisitos

- PHP 7.4 o superior
- Composer
- Servidor web (Apache/Nginx) o servidor de desarrollo PHP

## Instalación

1. Clonar el repositorio:
```bash
git clone <url-del-repositorio>
cd Nube_d2a_microservicio
```

2. Instalar dependencias:
```bash
composer install
```

3. Configurar variables de entorno:
```bash
# Crear archivo .env o configurar variables de entorno del servidor
D2A_API_URL=https://api.d2a.com
D2A_API_KEY=tu_api_key
D2A_SECRET_KEY=tu_secret_key
WEBHOOK_SECRET=tu_webhook_secret
ENVIRONMENT=development
```

## Configuración

### Variables de Entorno

- `D2A_API_URL`: URL de la API de D2A
- `D2A_API_KEY`: Clave API de D2A
- `D2A_SECRET_KEY`: Clave secreta de D2A
- `WEBHOOK_SECRET`: Secreto para verificar webhooks
- `ENVIRONMENT`: Entorno (development/production)
- `DB_HOST`: Host de la base de datos (opcional)
- `DB_NAME`: Nombre de la base de datos (opcional)
- `DB_USER`: Usuario de la base de datos (opcional)
- `DB_PASS`: Contraseña de la base de datos (opcional)

## Uso

### Endpoints Disponibles

#### 1. Health Check
```
GET /health
```
Verifica el estado del microservicio.

#### 2. Crear Checkout
```
POST /api/checkout
Content-Type: application/json

{
    "amount": 100.00,
    "currency": "USD",
    "description": "Compra de productos",
    "customer_email": "cliente@ejemplo.com",
    "customer_name": "Juan Pérez",
    "reference": "ORD-12345"
}
```

#### 3. Webhook
```
POST /api/webhook
Content-Type: application/json
X-D2A-Signature: <firma>

{
    "event_type": "payment.completed",
    "order_id": "ord_123",
    "checkout_id": "chk_456",
    "amount": 100.00,
    "currency": "USD"
}
```

### Ejecutar en Desarrollo

```bash
# Usando el servidor de desarrollo de PHP
composer start

# O directamente
php -S localhost:8000 -t public
```

### Configuración de Apache

```apache
<VirtualHost *:80>
    ServerName tu-dominio.com
    DocumentRoot /ruta/a/Nube_d2a_microservicio/public
    
    <Directory /ruta/a/Nube_d2a_microservicio/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/d2a_error.log
    CustomLog ${APACHE_LOG_DIR}/d2a_access.log combined
</VirtualHost>
```

### Configuración de Nginx

```nginx
server {
    listen 80;
    server_name tu-dominio.com;
    root /ruta/a/Nube_d2a_microservicio/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## Logs

Los logs se almacenan en `storage/logs/`:

- `app.log`: Logs generales de la aplicación
- `error.log`: Solo errores
- `webhook.log`: Logs específicos de webhooks

## Desarrollo

### Agregar Nuevos Endpoints

1. Crear el controlador en `src/Controllers/`
2. Agregar la ruta en `public/index.php`
3. Implementar la lógica de negocio en `src/Services/`

### Ejemplo de Nuevo Controlador

```php
<?php

namespace App\Controllers;

class MiController
{
    public function miMetodo()
    {
        // Lógica del endpoint
        http_response_code(200);
        echo json_encode(['success' => true]);
    }
}
```

### Agregar Nueva Ruta

En `public/index.php`:

```php
case 'api/mi-endpoint':
    if ($requestMethod === 'GET') {
        $controller = new \App\Controllers\MiController();
        $controller->miMetodo();
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
    }
    break;
```

## Seguridad

- Todos los webhooks son verificados mediante firma HMAC
- Los errores no exponen información sensible en producción
- CORS configurado para permitir peticiones desde dominios autorizados
- Logs estructurados para auditoría

## Testing

```bash
# Ejecutar tests
composer test
```

## Despliegue

1. Configurar variables de entorno en producción
2. Configurar servidor web (Apache/Nginx)
3. Configurar SSL/TLS
4. Configurar logs y monitoreo
5. Configurar backup de logs

## Soporte

Para soporte técnico, contactar al equipo de desarrollo.

## Licencia

[Especificar licencia del proyecto]# microservicio_php_nube_d2a
