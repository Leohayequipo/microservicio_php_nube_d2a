# 🔧 Configuración de D2A API

## 📋 **Credenciales Requeridas**

Para que el microservicio funcione correctamente con D2A, necesitas configurar las siguientes credenciales:

### **1. Archivo de Configuración**
Edita el archivo: `config/d2a.php`

```php
return [
    // REEMPLAZAR CON TUS VALORES REALES
    'api_key' => 'TU_API_KEY_REAL',
    'api_secret' => 'TU_API_SECRET_REAL', 
    'environment' => 'datst.simbel.com.ar',
    'customer_id' => 'TU_CUSTOMER_ID_REAL',
    // ...
];
```

### **2. Variables de Entorno (Opcional)**
También puedes usar variables de entorno:

```bash
D2A_API_KEY=tu_api_key_real
D2A_API_SECRET=tu_api_secret_real
D2A_ENVIRONMENT=datst.simbel.com.ar
D2A_CUSTOMER_ID=tu_customer_id_real
```

## 🔍 **¿Dónde Obtener las Credenciales?**

### **Basándome en tu implementación real:**

En tu archivo `D2a_library.php` veo que usas:
```php
$conexion = new d2a(D2A_APIKEY, D2A_SECRET, D2A_ENVIRONMENT, D2A_CUSTOMER, ...);
```

**Necesitas obtener estos valores:**
- `D2A_APIKEY` - Tu API Key de D2A
- `D2A_SECRET` - Tu API Secret de D2A  
- `D2A_ENVIRONMENT` - Environment (probablemente "datst.simbel.com.ar")
- `D2A_CUSTOMER` - Tu Customer ID

## 🚀 **Implementación Correcta de D2A**

### **URL de la API:**
```
https://datst.simbel.com.ar/Dashboard/Loader/api
```

### **Formato del Payload:**
```php
$fields = [
    'data' => json_encode([
        'track' => [
            'cs' => $customer,
            'abuVer' => 'APIV1.1',
            'ts' => date('c'),
            'tz' => date('P'),
            'sessionName' => $sessionName,
            'visitorName' => $visitorName,
            'registrant' => $registrant,
            'operation' => $operation,
            'ApiKey' => $apiKey,
            'hs' => md5($apiKey . $apiSecret . $customer . $operation),
            'ip' => $_SERVER['REMOTE_ADDR']
        ],
        'ms' => $messageData
    ])
];
```

### **Autenticación:**
```php
$hash = md5($apiKey . $apiSecret . $customer . $operation);
```

## 🧪 **Probar la Configuración**

### **1. Endpoint de Test:**
```bash
curl https://microservicio-php-nube-d2a.onrender.com/d2a/test
```

### **2. Verificar Logs:**
```bash
# Revisar el archivo de logs
tail -f storage/logs/d2a.log
```

### **3. Probar Registro:**
```bash
curl -X POST https://microservicio-php-nube-d2a.onrender.com/d2a/register \
  -H "Content-Type: application/json" \
  -d '{
    "registrant": "test@example.com",
    "typeOfId": "DNI",
    "nationalId": "12345678",
    "name": "Juan",
    "lastName": "Pérez",
    "gender": "M",
    "age": 30,
    "email": "test@example.com",
    "cellphone": "+5491112345678",
    "facebookId": "",
    "instagramId": "",
    "twitterId": "",
    "linkedinId": "",
    "city": "Buenos Aires",
    "state": "CABA",
    "country": "Argentina",
    "address1": "Av. Corrientes 123",
    "address2": "",
    "totalInCart": 1500.00,
    "totalBought": 1500.00
  }'
```

## 🚨 **Errores Comunes**

### **1. "Credenciales no configuradas"**
- Verificar que `config/d2a.php` tenga los valores correctos
- No usar los valores por defecto "TU_API_KEY", etc.

### **2. "Error de autenticación"**
- Verificar que `api_key`, `api_secret` y `customer_id` sean correctos
- Verificar que el hash se genere correctamente

### **3. "Error de conexión"**
- Verificar que la URL `https://datst.simbel.com.ar/Dashboard/Loader/api` sea accesible
- Verificar configuración de red/firewall

## 📞 **Soporte**

### **Para obtener credenciales de D2A:**
- Contactar al equipo de D2A/Simbel
- Revisar documentación de tu cuenta D2A
- Verificar en tu implementación actual qué valores usas

### **Logs de Debug:**
- `storage/logs/d2a.log` - Logs detallados de todas las llamadas
- Consola del navegador - Para errores del frontend

## ✅ **Verificación Final**

Una vez configurado, deberías ver en los logs:
```json
{
  "timestamp": "2024-01-15T10:30:00Z",
  "url": "https://datst.simbel.com.ar/Dashboard/Loader/api",
  "payload": { ... },
  "response": {
    "track": {
      "rc": "OK",
      "ec": "",
      "mi": "message_id"
    }
  },
  "status": 200,
  "error": ""
}
```

**¡Con esto el microservicio estará correctamente configurado para D2A!** 🚀 