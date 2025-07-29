# 🚀 Deployment Guide - Microservicio D2A

## ✅ Configuración Optimizada

El microservicio ha sido optimizado para deployment con las siguientes mejoras:

### 🔧 Cambios Realizados:

1. **Composer.json simplificado** con dependencias esenciales
2. **Dockerfile minimalista** usando Alpine Linux
3. **Configuración robusta** para múltiples plataformas
4. **Health check endpoint** para verificación de deployment
5. **Optimización de autoloader** para mejor rendimiento

## 🎯 Plataformas Soportadas

### 1. Render.com
```yaml
# render.yaml configurado para Docker
services:
  - type: web
    name: d2a-microservicio
    env: docker
    plan: free
    dockerfilePath: ./Dockerfile
    healthCheckPath: /health
```

### 2. Railway.app
```json
// railway.json optimizado
{
  "build": {
    "builder": "NIXPACKS"
  },
  "deploy": {
    "startCommand": "php -S 0.0.0.0:$PORT -t public",
    "healthcheckPath": "/health"
  }
}
```

### 3. Heroku
```bash
# Crear Procfile
echo "web: php -S 0.0.0.0:\$PORT -t public" > Procfile
```

## 🚀 Pasos para Deploy

### Opción 1: Render.com (Recomendado)
1. Conectar repositorio Git
2. Render detectará automáticamente `render.yaml`
3. Deploy automático en cada push

### Opción 2: Railway.app
1. Conectar repositorio Git
2. Railway usará `nixpacks.toml`
3. Deploy automático

### Opción 3: Docker Manual
```bash
# Construir imagen
docker build -t d2a-microservicio .

# Ejecutar contenedor
docker run -p 8080:8080 -e PORT=8080 d2a-microservicio
```

## 🧪 Verificación de Deployment

### Health Check
```bash
curl https://tu-app.ondigitalocean.app/health
```

Respuesta esperada:
```json
{
  "status": "ok",
  "timestamp": "2025-01-29T16:43:00+00:00",
  "environment": "production",
  "version": "1.0.0"
}
```

### Endpoints de Prueba
```bash
# Swagger UI
curl https://tu-app.ondigitalocean.app/docs

# API Spec
curl https://tu-app.ondigitalocean.app/swagger
```

## 🔍 Troubleshooting

### Error: "Exited with status 1"
**Causas comunes:**
1. Dependencias faltantes
2. Permisos de directorio
3. Variables de entorno

**Solución:**
- Verificar logs de build
- Comprobar que `storage/logs` y `storage/tmp` existen
- Verificar variables de entorno

### Error: "Port not found"
**Solución:**
- Asegurar que `$PORT` esté definido
- Usar puerto por defecto 8080

### Error: "Composer install failed"
**Solución:**
- Verificar que `composer.json` es válido
- Comprobar conexión a internet en build
- Usar `--no-interaction` flag

## 📊 Monitoreo

### Logs de Aplicación
- `storage/logs/d2a.log` - Eventos D2A
- `storage/logs/webhooks.log` - Webhooks
- Logs de plataforma (Render/Railway)

### Métricas de Salud
- Health check endpoint: `/health`
- Swagger UI: `/docs`
- API Spec: `/swagger`

## 🔧 Variables de Entorno

### Requeridas
```bash
PORT=8080
ENVIRONMENT=production
```

### Opcionales
```bash
D2A_API_URL=https://api.d2a.com
D2A_API_KEY=tu_api_key
D2A_SECRET_KEY=tu_secret_key
LOG_LEVEL=INFO
```

## 🎉 ¡Deployment Exitoso!

Una vez desplegado, tu microservicio estará disponible en:
- **Health Check:** `https://tu-app.com/health`
- **Documentación:** `https://tu-app.com/docs`
- **API Spec:** `https://tu-app.com/swagger`
- **Checkout:** `https://tu-app.com/checkout-temp`
- **Webhook:** `https://tu-app.com/webhook`

### 🏆 Características del Deployment:
- ✅ **Docker optimizado** con Alpine Linux
- ✅ **Health checks** automáticos
- ✅ **Logs estructurados** para monitoreo
- ✅ **Configuración flexible** para múltiples entornos
- ✅ **Autoloader optimizado** para mejor rendimiento
- ✅ **CORS configurado** para integración web 