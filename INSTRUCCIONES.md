# 🚀 Instrucciones de Uso - Microservicio D2A

## ✅ Instalación Completada

Tu microservicio D2A está completamente configurado y listo para usar.

## 📁 Estructura Final

```
Nube_d2a_microservicio/
│── public/
│    ├── index.php          # Punto de entrada
│    ├── swagger.php        # Especificación OpenAPI
│    └── docs.php           # Interfaz Swagger UI
│── src/
│    ├── Controllers/
│    │   ├── CheckoutController.php
│    │   └── WebhookController.php
│    ├── Services/
│    │   ├── D2AService.php
│    │   ├── CheckoutService.php
│    │   └── WebhookService.php
│    └── Config/
│        └── bootstrap.php
│── storage/
│    ├── logs/              # Logs del sistema
│    │   └── .gitkeep
│    └── tmp/               # Datos temporales
│    │   └── .gitkeep
│── vendor/                 # Dependencias de Composer
│── composer.json
│── composer.lock
│── .gitignore              # Archivos ignorados por Git
└── README.md
```

## 🎯 Endpoints Disponibles

### 1. Checkout Temporal
```
POST /checkout-temp
Content-Type: application/json

{
    "checkout_id": "abc123",
    "store_id": 456,
    "payment": {
        "gateway": "mercadopago",
        "installments": 6
    },
    "cart": [
        {
            "sku": "PROD1",
            "qty": 2,
            "price": 1000
        }
    ]
}
```

### 2. Webhook
```
POST /webhook
Content-Type: application/json

{
    "event": "order/created",
    "id": 999,
    "store_id": 456,
    "checkout": {
        "id": "abc123"
    },
    "payment_details": {
        "gateway": "mercadopago",
        "installments": 6
    },
    "customer": {
        "email": "cliente@test.com"
    }
}
```

### 3. Documentación API (Swagger)
```
GET /docs          # Interfaz Swagger UI interactiva
GET /swagger       # Especificación OpenAPI 3.0 JSON
```

**Características de la documentación:**
- ✅ **Interfaz interactiva** para probar endpoints
- ✅ **Documentación automática** de parámetros
- ✅ **Ejemplos de uso** incluidos
- ✅ **Validación de esquemas** en tiempo real
- ✅ **Especificación OpenAPI 3.0** estándar

## 🚀 Cómo Ejecutar

### Opción 1: Servidor de Desarrollo PHP
```bash
# Primero agregar PHP al PATH (si no está)
$env:PATH += ";C:\xampp\php"

# Luego ejecutar el servidor
php -S localhost:8000 -t public
```

### Opción 2: XAMPP (Recomendado)
1. Copia la carpeta `Nube_d2a_microservicio` a `C:\xampp\htdocs\`
2. Accede a: `http://localhost/Nube_d2a_microservicio/public/`

## 🧪 Probar el Microservicio

### Opción 1: Interfaz Swagger (Recomendado)
1. **Abrir navegador:** `http://localhost:8000/docs`
2. **Expandir endpoint** que quieras probar
3. **Hacer clic en "Try it out"**
4. **Completar datos** de ejemplo
5. **Ejecutar** y ver respuesta

### Opción 2: Con cURL:
```bash
# Test checkout
curl -X POST http://localhost:8000/checkout-temp \
  -H "Content-Type: application/json" \
  -d '{"checkout_id":"test123","store_id":456,"payment":{"gateway":"mp"},"cart":[{"sku":"P1","qty":1}]}'

# Test webhook
curl -X POST http://localhost:8000/webhook \
  -H "Content-Type: application/json" \
  -d '{"event":"order/created","id":999,"store_id":456,"checkout":{"id":"test123"}}'
```

### Con Postman:
1. Crear nueva petición POST
2. URL: `http://localhost:8000/checkout-temp`
3. Headers: `Content-Type: application/json`
4. Body: JSON con los datos de ejemplo

## 📊 Monitoreo

### Logs Disponibles:
- `storage/logs/d2a.log` - Eventos enviados a D2A
- `storage/logs/webhooks.log` - Logs de webhooks
- `storage/tmp/checkout_*.json` - Datos temporales de checkout

### Verificar Funcionamiento:
1. Enviar petición POST a `/checkout-temp`
2. Verificar que se crea archivo en `storage/tmp/`
3. Verificar que se registra en `storage/logs/d2a.log`
4. Enviar webhook a `/webhook`
5. Verificar que se procesa correctamente

## ⚙️ Configuración

### Variables de Entorno (Opcional):
```bash
D2A_API_URL=https://api.d2a.com
D2A_API_KEY=tu_api_key
D2A_SECRET_KEY=tu_secret_key
ENVIRONMENT=development
```

### Modificar URL de D2A:
Editar `src/Services/D2AService.php` línea 8:
```php
$this->apiUrl = "https://tu-api-d2a.com/event";
```

## 🔧 Comandos Útiles

```bash
# Instalar dependencias
php composer.phar install

# Actualizar autoloader
php composer.phar dump-autoload

# Agregar nueva dependencia
php composer.phar require nombre/paquete

# Verificar estado
php composer.phar diagnose

# Generar documentación Swagger (si usas anotaciones)
php vendor/bin/openapi src/ -o public/swagger.json
```

## 🛠️ Desarrollo

### Agregar Nuevo Endpoint:
1. Crear controlador en `src/Controllers/`
2. Agregar lógica en `src/Services/`
3. Actualizar routing en `public/index.php`

### Estructura de Clases:
- **Controllers**: Manejan peticiones HTTP
- **Services**: Contienen lógica de negocio
- **Config**: Configuración y bootstrap

## 📁 Control de Versiones (Git)

### Archivos Ignorados (.gitignore):
- `/vendor/` - Dependencias de Composer
- `/storage/logs/*.log` - Archivos de log
- `/storage/tmp/*` - Datos temporales
- `.env` - Variables de entorno locales
- Archivos de IDE y sistema

### Archivos Incluidos:
- `storage/logs/.gitkeep` - Mantiene carpeta logs
- `storage/tmp/.gitkeep` - Mantiene carpeta tmp
- `composer.lock` - Versiones exactas de dependencias

### Configurar Git:
```bash
# Inicializar repositorio
git init

# Agregar archivos
git add .

# Primer commit
git commit -m "Initial commit: Microservicio D2A"

# Agregar repositorio remoto
git remote add origin <url-del-repositorio>

# Subir cambios
git push -u origin main
```

## 📞 Soporte

Si encuentras algún problema:
1. Verificar logs en `storage/logs/`
2. Comprobar que PHP 8+ esté instalado
3. Verificar que Composer esté funcionando
4. Revisar permisos de escritura en `storage/`
5. Verificar que PHP esté en el PATH de Windows

## 🎉 ¡Listo!

Tu microservicio D2A está completamente funcional y listo para integrar con Tiendanube y D2A.

### 🏆 **Características Implementadas:**

- ✅ **Microservicio funcional** con checkout y webhooks
- ✅ **Documentación interactiva** con Swagger UI
- ✅ **Especificación OpenAPI 3.0** estándar
- ✅ **Logs y monitoreo** automático
- ✅ **Control de versiones** con Git
- ✅ **Estructura profesional** MVC
- ✅ **Pruebas interactivas** desde navegador
- ✅ **Configuración flexible** para desarrollo/producción

### 🚀 **Próximos pasos sugeridos:**

1. **Probar endpoints** desde `http://localhost:8000/docs`
2. **Configurar variables de entorno** para producción
3. **Implementar autenticación** si es necesario
4. **Agregar más endpoints** según necesidades
5. **Configurar CI/CD** para despliegue automático