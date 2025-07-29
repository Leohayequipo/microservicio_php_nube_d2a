# 🌐 Despliegue en Hostinger

## 📋 Pasos para desplegar:

### 1. **Preparar archivos**
- Crear ZIP del proyecto (sin vendor/)
- Subir via cPanel File Manager o FTP

### 2. **Acceder a cPanel**
- Login en Hostinger
- Ir a "cPanel"
- Abrir "File Manager"

### 3. **Subir archivos**
- Navegar a `public_html/`
- Subir archivos del proyecto
- Extraer ZIP en la raíz

### 4. **Instalar dependencias**
- Abrir Terminal en cPanel
- Ejecutar: `composer install --no-dev`

### 5. **Configurar variables**
Crear archivo `.env` en la raíz:
```
D2A_API_URL=https://api.d2a.com
D2A_API_KEY=tu_api_key
D2A_SECRET_KEY=tu_secret_key
ENVIRONMENT=production
```

## 🔗 **URLs de tu microservicio:**

- **Documentación:** `https://tudominio.com/docs`
- **Especificación:** `https://tudominio.com/swagger`
- **Checkout:** `https://tudominio.com/checkout-temp`
- **Webhook:** `https://tudominio.com/webhook`

## ⚙️ **Configuración de PHP:**

En cPanel → "PHP Configuration":
- **PHP Version:** 8.0 o superior
- **Memory Limit:** 256M
- **Max Execution Time:** 300s
- **Upload Max Filesize:** 64M

## 📁 **Estructura en Hostinger:**

```
public_html/
├── public/
│   ├── index.php
│   ├── swagger.php
│   └── docs.php
├── src/
│   ├── Controllers/
│   ├── Services/
│   └── Config/
├── storage/
│   ├── logs/
│   └── tmp/
├── vendor/
├── composer.json
└── .env
```

## 🔧 **Configuración de .htaccess:**

Crear archivo `.htaccess` en `public_html/`:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ public/index.php [QSA,L]
```

## 📊 **Monitoreo:**

- **Logs:** En cPanel → "Error Logs"
- **Estadísticas:** cPanel → "Web Statistics"
- **Backup:** Automático en Hostinger

## 💰 **Ventajas de Hostinger:**

- **🆓 Dominio gratuito** por 1 año
- **🛡️ SSL gratuito** automático
- **📧 Email profesional** incluido
- **🔧 cPanel** completo
- **📊 Estadísticas** detalladas
- **🔄 Backup** automático 