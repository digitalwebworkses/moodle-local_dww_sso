# DWW Moodle SSO

![Versión](https://img.shields.io/badge/version-1.1.1--alpha-green)
![Moodle](https://img.shields.io/badge/Moodle-4.x-orange)
![PHP](https://img.shields.io/badge/PHP-8.x-blue)

Plugin complementario de integración y Single Sign-On seguro para DWW Moodle Bridge.

DWW Moodle SSO trabaja junto al plugin DWW Moodle Bridge para WordPress para proporcionar autenticación segura, aprovisionamiento automático de usuarios y gestión de accesos WooCommerce ↔ Moodle.

---

# Documentación

## Español

- [Guía de instalación](INSTALL.es.md)

## English

- [Installation Guide](INSTALL.md)

---

# Características

- Single Sign-On (SSO) seguro
- Autenticación mediante secreto compartido
- Validación HMAC SHA-256
- Login automático en Moodle
- Acceso directo a cursos
- Sistema de logs en Moodle
- Setup Wizard
- Validación de conectividad WordPress
- Registro automático del servicio web de Moodle
- Provisionado automático del servicio REST
- Integración API segura mediante token
- Compatibilidad con WooCommerce

---

# Requisitos

- Moodle 4.x
- PHP 8.x
- HTTPS habilitado
- Cadena SSL válida

---

# Instalación rápida

## 1. Instalar el plugin

Sube el plugin a:

```text
/local/dww_sso
```

o instálalo desde:

```text
Administración del sitio
→ Plugins
→ Instalar plugins
```

---

## 2. Configurar el plugin

Ir a:

```text
Administración del sitio
→ Plugins
→ Plugins locales
→ DWW SSO
```

Configurar:

- Secreto compartido SSO
- URL de WordPress

---

## 3. Ejecutar Setup Wizard

Abrir:

```text
Administración del sitio
→ Plugins
→ Plugins locales
→ DWW SSO
→ Setup Wizard
```

El asistente valida:

- Secreto compartido
- Disponibilidad del endpoint
- Conectividad WordPress
- Disponibilidad de WooCommerce
- Configuración Moodle API
- Configuración SSO

---

# Servicio Web Moodle

DWW Moodle SSO crea automáticamente:

```text
DWW Moodle Bridge Service
```

durante la instalación o actualización del plugin.

Este servicio incluye todas las funciones necesarias de la API de Moodle.

---

# IMPORTANTE — Usuarios autorizados

El servicio se crea intencionadamente como:

```text
Solo usuarios autorizados
```

por motivos de seguridad.

Antes de generar tokens:

```text
Administración del sitio
→ Servidor
→ Servicios web
→ Servicios externos
→ DWW Moodle Bridge Service
→ Usuarios autorizados
```

Añadir el usuario que será utilizado por WordPress.

---

# Generar token Moodle

Ir a:

```text
Administración del sitio
→ Servidor
→ Servicios web
→ Gestionar tokens
```

Generar un token utilizando:

```text
Servicio:
DWW Moodle Bridge Service
```

Copiar el token generado en la configuración del plugin WordPress.

---

# Plugin complementario WordPress

Este plugin está diseñado para funcionar junto a:

```text
DWW Moodle Bridge para WordPress/WooCommerce
```

---

# Características de seguridad

- Firmas HMAC SHA-256
- Validación de secreto compartido
- Tokens SSO con expiración
- Protección antireutilización mediante nonce
- Validación segura de URL de retorno
- Usuarios restringidos en servicios web
- Validación de matrículas Moodle

---

# Resolución de problemas

## webservice_access_exception

Normalmente provocado por:

- token generado desde otro servicio Moodle
- usuario no autorizado
- usuario no añadido al servicio

Solución:

- usar SOLO:

```text
DWW Moodle Bridge Service
```

- verificar usuarios autorizados
- generar un nuevo token

---

## cURL error 60

Normalmente provocado por:

- cadena SSL inválida
- certificados intermedios ausentes

Verificar:

```bash
openssl s_client -connect yourdomain.com:443 -servername yourdomain.com
```

La validación debería devolver:

```text
Verify return code: 0 (ok)
```

---

# Estado de desarrollo

Estado actual:

```text
Alpha
```

El plugin se encuentra en desarrollo activo y validación en entornos reales de producción.

---

# Changelog

Consultar:

- [CHANGELOG.md](CHANGELOG.md)

---

# Licencia

GPL v2 o posterior