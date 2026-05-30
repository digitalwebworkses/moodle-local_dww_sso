# DWW Moodle Bridge — Guía de instalación

Versión: 1.1.1-alpha

---

# IMPORTANTE

Esta guía está redactada intencionadamente como un documento de instalación estricto paso a paso.

NO omitas pasos.  
NO improvises.  
NO sustituyas valores por otros “parecidos”.

La mayoría de problemas de instalación ocurren por:
- servicios Moodle incorrectos,
- certificados SSL inválidos,
- URLs incorrectas,
- tokens erróneos,
- o configuraciones Moodle defectuosas.

Sigue esta guía exactamente.

---

# REQUISITOS DEL SISTEMA

## WordPress

Requerido:

- WordPress 6.x
- WooCommerce
- PHP 8.x
- HTTPS habilitado

---

## Moodle

Requerido:

- Moodle 4.x
- PHP 8.x
- HTTPS habilitado
- Cadena SSL válida

---

# ANTES DE EMPEZAR

Necesitas:

## Parte WordPress

- Acceso de administrador
- WooCommerce instalado
- ZIP del plugin DWW Moodle Bridge

---

## Parte Moodle

- Acceso como administrador del sitio
- ZIP del plugin DWW Moodle SSO

---

# PASO 1 — INSTALAR EL PLUGIN MOODLE

En Moodle:

```text
Administración del sitio
→ Plugins
→ Instalar plugins
```

Subir:

```text
dww_sso-x.x.x.zip
```

Completar instalación.

---

# PASO 2 — CONFIGURAR EL PLUGIN MOODLE

Ir a:

```text
Administración del sitio
→ Plugins
→ Plugins locales
→ DWW SSO
```

Configurar:

## Secreto compartido

Generar un valor ALEATORIO largo.

Ejemplo:

```text
8f2d7f9e7d3e4c6a9f7e2b1c4d5a6f7e
```

Guardar.

IMPORTANTE:  
El mismo valor DEBE utilizarse posteriormente en WordPress.

---

## URL de WordPress

Ejemplo:

```text
https://tudominio.com
```

Guardar cambios.

---

# PASO 3 — VERIFICAR CONFIGURACIÓN MOODLE

Abrir:

```text
Administración del sitio
→ Plugins
→ Plugins locales
→ DWW SSO
→ Setup Wizard
```

Verificar:

- porcentaje de preparación
- disponibilidad del endpoint
- validación WordPress
- información Moodle

El Setup Wizard NO debe mostrar errores críticos.

---

# PASO 4 — VERIFICAR SERVICIO WEB MOODLE

El plugin crea automáticamente:

```text
DWW Moodle Bridge Service
```

Ir a:

```text
Administración del sitio
→ Servidor
→ Servicios web
→ Servicios externos
```

Verificar que el servicio existe.

---

# PASO 5 — AUTORIZAR USUARIO

IMPORTANTE:  
El servicio está restringido intencionadamente por motivos de seguridad.

Ir a:

```text
Administración del sitio
→ Servidor
→ Servicios web
→ Servicios externos
→ DWW Moodle Bridge Service
→ Usuarios autorizados
```

Añadir el administrador Moodle o usuario técnico de integración.

Sin este paso:
los tokens FALLARÁN.

---

# PASO 6 — GENERAR TOKEN

Ir a:

```text
Administración del sitio
→ Servidor
→ Servicios web
→ Gestionar tokens
```

Crear token utilizando:

## Usuario

El usuario autorizado añadido anteriormente.

---

## Servicio

IMPORTANTE:

Debes seleccionar:

```text
DWW Moodle Bridge Service
```

NO utilizar:
- servicios personalizados
- servicios antiguos
- servicios creados manualmente

Copiar el token generado.

---

# PASO 7 — VERIFICAR MATRÍCULA MANUAL

Ir a:

```text
Administración del sitio
→ Plugins
→ Matriculaciones
→ Gestionar plugins de matriculación
```

Verificar:

```text
Manual enrolments = ENABLED
```

---

# PASO 8 — VERIFICAR MÉTODO DE MATRÍCULA DEL CURSO

Abrir el curso Moodle.

Ir a:

```text
Curso
→ Participantes
→ Métodos de matriculación
```

Verificar que:

```text
Manual enrolments
```

existe y está habilitado.

Sin esto:
la matriculación automática FALLARÁ.

---

# PASO 9 — INSTALAR PLUGIN WORDPRESS

En WordPress:

```text
Plugins
→ Añadir nuevo
→ Subir plugin
```

Subir:

```text
dww-moodle-bridge-x.x.x.zip
```

Activar plugin.

---

# PASO 10 — CONFIGURAR PLUGIN WORDPRESS

Ir a:

```text
DWW Moodle Bridge
→ Ajustes
```

Configurar:

---

## URL Moodle

Ejemplo:

```text
https://tudominio.com/moodle
```

IMPORTANTE:  
Usar la URL HTTPS PÚBLICA.

NO usar:
- localhost
- hostnames Docker
- IPs internas

---

## Token Moodle

Pegar el token generado anteriormente.

---

## Secreto compartido

Pegar EXACTAMENTE el mismo secreto configurado en Moodle.

---

# PASO 11 — VERIFICAR CONEXIÓN

Abrir:

```text
DWW Moodle Bridge
→ Health
```

Verificar:

- Moodle API configurada
- SSO configurado
- REST API accesible

No deben aparecer errores críticos.

---

# PASO 12 — CREAR PRODUCTO DE CURSO

Crear producto WooCommerce.

Asignar:

- curso Moodle
- duración de acceso
- integración habilitada

Guardar producto.

---

# PASO 13 — PROBAR PEDIDO MANUAL

Primera prueba recomendada:

```text
WooCommerce
→ Pedidos
→ Añadir pedido
```

Crear pedido manual usando:
- usuario de pruebas
- producto Moodle

Cambiar estado del pedido a:

```text
Processing
```

o:

```text
Completed
```

---

# RESULTADO ESPERADO

El plugin debería:

- crear usuario Moodle
- matricular usuario
- crear expiración de acceso
- generar logs
- permitir acceso SSO

---

# PROBAR REVOCACIÓN

Cancelar el pedido.

Resultado esperado:

- desmatriculación Moodle
- revocación de acceso
- logs actualizados

---

# RESOLUCIÓN DE PROBLEMAS

---

## ERROR

```text
webservice_access_exception
```

Normalmente provocado por:

- servicio incorrecto
- usuario Moodle no autorizado
- token inválido

Solución:

- regenerar token
- verificar usuarios autorizados
- usar SOLO:

```text
DWW Moodle Bridge Service
```

---

## ERROR

```text
cURL error 60
```

Normalmente provocado por:

- cadena SSL inválida
- certificados intermedios ausentes

Verificar SSL usando:

```bash
openssl s_client -connect tudominio.com:443 -servername tudominio.com
```

La validación debe devolver:

```text
Verify return code: 0 (ok)
```

---

## ERROR

```text
Manual enrolments plugin does not exist or is disabled
```

Solución:

Habilitar:

```text
Manual enrolments
```

globalmente y dentro del curso.

---

# SOPORTE

DWW Moodle Bridge asume:
- configuración SSL válida
- instalación Moodle funcional
- instalación WooCommerce estándar

Infraestructuras defectuosas, instalaciones Moodle muy modificadas o configuraciones SSL inválidas pueden requerir intervención técnica.

---

# ESTADO DE DESARROLLO

Estado actual:

```text
Alpha
```

La funcionalidad principal está operativa y validada en entornos reales.

Las futuras mejoras y correcciones se distribuyen a todos los clientes activos.

---

# LICENCIA

GPL v2 o posterior