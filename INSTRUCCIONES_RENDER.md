# 🚀 Instrucciones Específicas para Render.com

## ✅ Estado Actual

Tu microservicio está **completamente listo** para deployment en Render. He optimizado toda la configuración.

## 🎯 Configuración Actual

### Archivo: `render.yaml` ✅
```yaml
services:
  - type: web
    name: d2a-microservicio
    env: php                    # ✅ PHP nativo (NO Docker)
    plan: free
    buildCommand: composer install --no-dev --optimize-autoloader
    startCommand: php -S 0.0.0.0:$PORT -t public
    healthCheckPath: /health
    envVars:
      - key: ENVIRONMENT
        value: production
      - key: D2A_API_URL
        value: https://api.d2a.com
      - key: LOG_LEVEL
        value: INFO
```

## 🚀 Pasos para Deploy en Render

### Paso 1: Verificar Repositorio
```bash
# Asegúrate de que todos los archivos están en Git
git status
git add .
git commit -m "fix: Configuración optimizada para Render"
git push origin main
```

### Paso 2: Ir a Render.com
1. **Abrir:** https://render.com
2. **Iniciar sesión** con tu cuenta
3. **Dashboard** → **"New +"** → **"Web Service"**

### Paso 3: Conectar Repositorio
1. **"Connect a repository"**
2. **Seleccionar** tu repositorio (GitHub/GitLab)
3. **Seleccionar rama:** `main` o `master`
4. **Click "Connect"**

### Paso 4: Configuración Automática
Render debería detectar automáticamente:
- ✅ **Environment:** PHP
- ✅ **Build Command:** `composer install --no-dev --optimize-autoloader`
- ✅ **Start Command:** `php -S 0.0.0.0:$PORT -t public`

**Si NO detecta automáticamente, configura manualmente:**
- **Environment:** `PHP`
- **Build Command:** `composer install --no-dev --optimize-autoloader`
- **Start Command:** `php -S 0.0.0.0:$PORT -t public`

### Paso 5: Variables de Entorno
En la sección "Environment Variables", agregar:
```
ENVIRONMENT=production
D2A_API_URL=https://api.d2a.com
LOG_LEVEL=INFO
```

### Paso 6: Deploy
1. **Click "Create Web Service"**
2. **Esperar** que termine el build (2-3 minutos)
3. **Verificar** que el status sea "Live"

## 🧪 Verificar que Funciona

### 1. Health Check
```bash
curl https://tu-app.onrender.com/health
```

**Respuesta esperada:**
```json
{
  "status": "ok",
  "timestamp": "2025-07-29T21:53:27+00:00",
  "environment": "production",
  "version": "1.0.0"
}
```

### 2. Documentación
```bash
curl https://tu-app.onrender.com/docs
```

### 3. API Spec
```bash
curl https://tu-app.onrender.com/swagger
```

## 🔍 Si Hay Problemas

### Error: "Build failed"
**Solución:**
1. Verificar que `composer.json` está en el repositorio
2. Verificar que `composer.lock` está en el repositorio
3. Revisar logs de build en Render Dashboard

### Error: "Start command failed"
**Solución:**
1. Verificar que `public/index.php` existe
2. Verificar que `vendor/autoload.php` se generó
3. Comprobar que `$PORT` está definido

### Error: "Health check failed"
**Solución:**
1. Verificar que `/health` endpoint funciona
2. Revisar logs de la aplicación
3. Comprobar que el servidor PHP inicia

## 📊 Monitoreo

### Logs en Render
1. **Dashboard** → **Tu servicio** → **"Logs"**
2. **Ver logs en tiempo real**
3. **Identificar errores específicos**

### Métricas
- **Health Check:** `/health`
- **Documentación:** `/docs`
- **API Spec:** `/swagger`

## 🎉 URLs Finales

Una vez desplegado, tu microservicio estará en:
- **URL Principal:** `https://tu-app.onrender.com`
- **Health Check:** `https://tu-app.onrender.com/health`
- **Documentación:** `https://tu-app.onrender.com/docs`
- **API Spec:** `https://tu-app.onrender.com/swagger`
- **Checkout:** `https://tu-app.onrender.com/checkout-temp`
- **Webhook:** `https://tu-app.onrender.com/webhook`

## 🚨 Alternativas si Render No Funciona

### Opción 1: Railway.app
```bash
# Railway es más confiable para PHP
# Usar railway.json existente
```

### Opción 2: Heroku
```bash
# Crear Procfile
echo "web: php -S 0.0.0.0:\$PORT -t public" > Procfile
```

### Opción 3: Vercel
```bash
# Crear vercel.json
echo '{"functions": {"public/index.php": {"runtime": "php@8.1"}}}' > vercel.json
```

## 📞 Soporte

Si sigues teniendo problemas:
1. **Revisar logs** en Render Dashboard
2. **Verificar** que el repositorio está sincronizado
3. **Comprobar** que todos los archivos están en Git
4. **Contactar** soporte de Render con los logs específicos

## 🏆 ¡Éxito!

Tu microservicio D2A estará completamente funcional en Render con:
- ✅ **Deployment automático** en cada push
- ✅ **Health checks** automáticos
- ✅ **Logs estructurados** para monitoreo
- ✅ **Documentación interactiva** disponible
- ✅ **API funcional** para checkout y webhooks 