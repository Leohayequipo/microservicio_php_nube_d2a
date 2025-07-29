# 🔧 Solución para Render.com - Microservicio D2A

## ❌ Problema Identificado

El deployment en Render está fallando con "Exited with status 1". Esto puede deberse a varios factores.

## ✅ Soluciones Implementadas

### 1. **Configuración Simplificada (Recomendada)**

He creado `render.yaml` optimizado para PHP nativo:

```yaml
services:
  - type: web
    name: d2a-microservicio
    env: php                    # ✅ Usar PHP nativo, NO Docker
    plan: free
    buildCommand: composer install --no-dev --optimize-autoloader
    startCommand: php -S 0.0.0.0:$PORT -t public
    healthCheckPath: /health
```

### 2. **Configuración Alternativa**

Si la primera no funciona, usa `render-php.yaml`:

```bash
# Renombrar el archivo
mv render-php.yaml render.yaml
```

### 3. **Configuración Manual en Render**

Si los archivos no funcionan, configura manualmente:

1. **Ir a Render Dashboard**
2. **"New +" → "Web Service"**
3. **Conectar tu repositorio Git**
4. **Configuración manual:**
   - **Environment:** `PHP`
   - **Build Command:** `composer install --no-dev --optimize-autoloader`
   - **Start Command:** `php -S 0.0.0.0:$PORT -t public`
   - **Health Check Path:** `/health`

## 🚀 Pasos para Deploy Exitoso

### Paso 1: Verificar Archivos
```bash
# Asegúrate de que estos archivos existen
ls composer.json
ls composer.lock
ls public/index.php
ls src/Config/bootstrap.php
```

### Paso 2: Commit y Push
```bash
git add .
git commit -m "fix: Configuración optimizada para Render"
git push origin main
```

### Paso 3: Configurar en Render
1. **Dashboard Render** → **"New +"** → **"Web Service"**
2. **Conectar repositorio** (GitHub/GitLab)
3. **Seleccionar rama** (main/master)
4. **Configuración automática** (debe detectar PHP)

### Paso 4: Variables de Entorno
En Render Dashboard, agregar:
```
ENVIRONMENT=production
D2A_API_URL=https://api.d2a.com
LOG_LEVEL=INFO
```

## 🔍 Troubleshooting Específico

### Error: "Build failed"
**Solución:**
- Verificar que `composer.json` es válido
- Comprobar que `composer.lock` existe
- Asegurar que PHP 8.0+ está disponible

### Error: "Start command failed"
**Solución:**
- Verificar que `public/index.php` existe
- Comprobar que `vendor/autoload.php` se generó
- Asegurar que `$PORT` está definido

### Error: "Health check failed"
**Solución:**
- Verificar que `/health` endpoint funciona
- Comprobar logs de la aplicación
- Asegurar que el servidor PHP inicia correctamente

## 📊 Verificación de Deployment

### 1. Health Check
```bash
curl https://tu-app.onrender.com/health
```

Respuesta esperada:
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

## 🎯 Configuración Final Recomendada

### Archivo: `render.yaml`
```yaml
services:
  - type: web
    name: d2a-microservicio
    env: php
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

## 🚨 Si Nada Funciona

### Opción 1: Railway.app (Alternativa)
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

## 📞 Soporte Adicional

Si sigues teniendo problemas:

1. **Verificar logs** en Render Dashboard
2. **Comprobar** que el repositorio está sincronizado
3. **Revisar** que todos los archivos están en el repositorio
4. **Contactar** soporte de Render con los logs de error

## 🎉 ¡Deployment Exitoso!

Una vez que funcione, tu microservicio estará en:
- **URL:** `https://tu-app.onrender.com`
- **Health:** `https://tu-app.onrender.com/health`
- **Docs:** `https://tu-app.onrender.com/docs` 