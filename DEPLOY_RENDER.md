# 🚀 Despliegue en Render

## 📋 Pasos para desplegar:

### 1. **Crear cuenta en Render**
- Ir a [render.com](https://render.com)
- Crear cuenta con GitHub
- Verificar email

### 2. **Conectar repositorio**
- Hacer clic en "New +"
- Seleccionar "Web Service"
- Conectar con GitHub
- Elegir repositorio `Nube_d2a_microservicio`

### 3. **Configurar servicio**
- **Name:** `d2a-microservicio`
- **Environment:** `PHP`
- **Build Command:** `composer install --no-dev --optimize-autoloader`
- **Start Command:** `php -S 0.0.0.0:$PORT -t public`
- **Plan:** `Free`

### 4. **Configurar variables de entorno**
En Render Dashboard → Environment:
```
D2A_API_URL=https://api.d2a.com
D2A_API_KEY=tu_api_key_aqui
D2A_SECRET_KEY=tu_secret_key_aqui
ENVIRONMENT=production
LOG_LEVEL=INFO
```

### 5. **Desplegar**
- Hacer clic en "Create Web Service"
- Render detectará PHP automáticamente
- URL: `https://tu-app.onrender.com`

## 🔗 **URLs de tu microservicio:**

- **Documentación:** `https://tu-app.onrender.com/docs`
- **Especificación:** `https://tu-app.onrender.com/swagger`
- **Checkout:** `https://tu-app.onrender.com/checkout-temp`
- **Webhook:** `https://tu-app.onrender.com/webhook`

## ⚙️ **Configuración automática:**

Render detectará automáticamente:
- ✅ **PHP 8+** instalado
- ✅ **Composer** para dependencias
- ✅ **Servidor PHP** iniciado
- ✅ **Puerto** configurado automáticamente
- ✅ **SSL** automático

## 📊 **Monitoreo:**

- **Logs:** Disponibles en Render Dashboard
- **Métricas:** Uso de CPU, memoria, red
- **Despliegues:** Historial automático
- **Health Checks:** Automáticos en `/swagger`

## 🔄 **Despliegues automáticos:**

Cada vez que hagas `git push` a tu repositorio:
- ✅ Render detectará cambios
- ✅ Reconstruirá automáticamente
- ✅ Desplegará nueva versión
- ✅ URL se mantiene igual

## 💰 **Precios:**

- **🆓 Gratis:** Para siempre
- **💳 Pago:** Solo si necesitas más recursos
- **🚀 Escalable:** Según necesidades

## 🛡️ **Características incluidas:**

- **SSL automático** (HTTPS)
- **DDoS Protection** incluido
- **Zero Downtime Deploys**
- **Automatic Deploys** desde GitHub
- **Private Networking** (en planes pagos)
- **Load-Based Autoscaling** (en planes pagos)

## 📈 **Ventajas de Render:**

- **⚡ Muy rápido** para desplegar
- **🔧 Fácil configuración**
- **📊 Monitoreo completo**
- **🛡️ Seguridad empresarial**
- **🌍 Global CDN**
- **🔗 Integración con GitHub** 