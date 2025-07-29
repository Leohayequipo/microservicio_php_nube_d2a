# 🚂 Despliegue en Railway

## 📋 Pasos para desplegar:

### 1. **Crear cuenta en Railway**
- Ir a [railway.app](https://railway.app)
- Crear cuenta con GitHub

### 2. **Conectar repositorio**
- Hacer clic en "New Project"
- Seleccionar "Deploy from GitHub repo"
- Elegir tu repositorio `Nube_d2a_microservicio`

### 3. **Configurar variables de entorno (opcional)**
En Railway Dashboard → Variables:
```
D2A_API_URL=https://api.d2a.com
D2A_API_KEY=tu_api_key
D2A_SECRET_KEY=tu_secret_key
ENVIRONMENT=production
```

### 4. **Desplegar**
- Railway detectará automáticamente que es PHP
- El despliegue comenzará automáticamente
- URL: `https://tu-app.railway.app`

## 🔗 **URLs de tu microservicio:**

- **Documentación:** `https://tu-app.railway.app/docs`
- **Especificación:** `https://tu-app.railway.app/swagger`
- **Checkout:** `https://tu-app.railway.app/checkout-temp`
- **Webhook:** `https://tu-app.railway.app/webhook`

## ⚙️ **Configuración automática:**

Railway detectará automáticamente:
- ✅ **PHP 8+** instalado
- ✅ **Composer** para dependencias
- ✅ **Servidor PHP** iniciado
- ✅ **Puerto** configurado automáticamente

## 📊 **Monitoreo:**

- **Logs:** Disponibles en Railway Dashboard
- **Métricas:** Uso de CPU, memoria, red
- **Despliegues:** Historial automático
- **Rollback:** Revertir a versiones anteriores

## 🔄 **Despliegues automáticos:**

Cada vez que hagas `git push` a tu repositorio:
- ✅ Railway detectará cambios
- ✅ Reconstruirá automáticamente
- ✅ Desplegará nueva versión
- ✅ URL se mantiene igual

## 💰 **Precios:**

- **🆓 Gratis:** 500 horas/mes
- **💳 Pago:** $5/mes para uso ilimitado
- **🚀 Escalable:** Según necesidades 