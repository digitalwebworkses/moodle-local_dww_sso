<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License...
//
// @package    local_dww_sso
// @copyright  2026 Carlos M. Márquez
// @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
//
// DWW Moodle SSO is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// DWW Moodle SSO is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.


$string['pluginname'] = 'DWW SSO';
$string['sharedsecret'] = 'Secreto compartido SSO';
$string['sharedsecret_desc'] = 'Pega aquí el mismo secreto SSO generado en el plugin DWW Moodle Bridge de WordPress.';
$string['generalsettings'] = 'Ajustes generales';
$string['generalsettings_desc'] = 'Configura los ajustes del complemento Moodle necesarios para DWW Moodle Bridge for WordPress.';
$string['ssostatus'] = 'Estado SSO';
$string['systemstatus'] = 'Estado del sistema';
$string['pluginversion'] = 'Versión del plugin';
$string['moodleversion'] = 'Versión de Moodle';
$string['sharedsecretstatus'] = 'Secreto compartido';
$string['configured'] = 'Configurado';
$string['notconfigured'] = 'No configurado';
$string['ssoendpoint'] = 'Endpoint SSO';
$string['diagnostics'] = 'Diagnóstico';
$string['diagnostics_desc'] = 'Comprobaciones operativas básicas del complemento Moodle para DWW Moodle Bridge.';
$string['endpointmissing'] = 'El archivo del endpoint no existe o no es legible';
$string['noncedirectory'] = 'Directorio de nonces';
$string['notwritable'] = 'No escribible';
$string['loggerstatus'] = 'Logger';
$string['available'] = 'Disponible';
$string['notavailable'] = 'No disponible';
$string['phpversion'] = 'Versión PHP';
$string['check'] = 'Comprobación';
$string['status'] = 'Estado';
$string['details'] = 'Detalle';
$string['ok'] = 'OK';
$string['error'] = 'Error';
$string['security'] = 'Seguridad';
$string['security_desc'] = 'Resumen de seguridad del complemento Moodle para SSO.';
$string['security_sharedsecret'] = 'Fortaleza del secreto compartido';
$string['security_hmac'] = 'Validación de firma HMAC SHA-256';
$string['security_expiration'] = 'Tokens SSO con expiración';
$string['security_nonce'] = 'Protección antireutilización con nonce';
$string['security_returnurl'] = 'Validación segura de URL de retorno';
$string['security_enrolment'] = 'Validación de usuario, curso y matrícula';
$string['security_enabled'] = 'Activo';
$string['security_attention'] = 'Requiere atención';
$string['warning'] = 'Aviso';
$string['logs'] = 'Logs';
$string['logs_desc'] = 'Últimos eventos registrados por el complemento Moodle SSO.';
$string['nologsfound'] = 'No se han encontrado logs todavía.';
$string['time'] = 'Fecha';
$string['level'] = 'Nivel';
$string['message'] = 'Mensaje';
$string['setupwizard'] = 'Asistente de configuración';
$string['setupwizard_desc'] = 'Configuración guiada inicial para conectar Moodle con DWW Moodle Bridge para WordPress/WooCommerce.';

$string['setup_step1'] = 'Paso 1 — Configuración Moodle';
$string['setup_step1_item1'] = 'Instala este complemento en /local/dww_sso.';
$string['setup_step1_item2'] = 'Configura un secreto compartido seguro.';
$string['setup_step1_item3'] = 'Verifica que el endpoint SSO esté disponible.';

$string['setup_validation'] = 'Validaciones actuales';

$string['setup_sharedsecret'] = 'Secreto compartido configurado';
$string['setup_login_endpoint'] = 'Endpoint login.php disponible';
$string['setup_logs'] = 'Directorio de logs escribible';

$string['setup_nextsteps'] = 'Siguientes pasos';
$string['setup_nextsteps_item1'] = 'Instala DWW Moodle Bridge en WordPress.';
$string['setup_nextsteps_item2'] = 'Configura la URL de Moodle y el token API.';
$string['setup_nextsteps_item3'] = 'Configura el mismo secreto compartido en WordPress.';

$string['setup_wordpress'] = 'Información para WordPress';
$string['setup_moodle_url'] = 'URL pública Moodle';
$string['setup_sso_endpoint'] = 'Endpoint SSO';
$string['setup_sharedsecret_status'] = 'Estado del secreto compartido';
$string['setup_moodle_version'] = 'Versión Moodle';
$string['setup_php_version'] = 'Versión PHP';
$string['setup_wordpress_note'] = 'Utiliza estos datos para completar el asistente de configuración en WordPress.';
$string['setup_readiness'] = 'Preparación del sistema';

$string['copy'] = 'Copiar';
$string['copied'] = 'Copiado';

$string['wordpressurl'] = 'URL de WordPress';
$string['wordpressurl_desc'] = 'URL pública del sitio WordPress donde está instalado DWW Moodle Bridge.';

$string['setup_wordpress_validation'] = 'Validación WordPress';
$string['setup_wp_reachable'] = 'WordPress accesible';
$string['setup_wp_plugin'] = 'Plugin DWW Moodle Bridge detectado';
$string['setup_wp_woocommerce'] = 'WooCommerce activo';
$string['setup_wp_moodleapi'] = 'Configuración Moodle API';
$string['setup_wp_sso'] = 'Secreto SSO configurado';

$string['setup_webservice'] = 'Servicio web Moodle';
$string['setup_token_warning'] = 'Los tokens creados desde otros servicios Moodle pueden provocar errores de autenticación o control de acceso.';
$string['setup_webservice_item1'] = 'El servicio "DWW Moodle Bridge Service" se crea automáticamente al instalar o actualizar el plugin.';
$string['setup_webservice_item2'] = 'Antes de generar el token, añade un usuario autorizado al servicio.';
$string['setup_webservice_item3'] = 'Genera el token usando únicamente el servicio "DWW Moodle Bridge Service".';
$string['setup_webservice_item4'] = 'Copia el token generado en la configuración del plugin WordPress.';

$string['returntosite'] = 'Volver al sitio';
$string['errorinvalidlink'] = 'Enlace inválido';
$string['errorinvalidlink_desc'] = 'El enlace de acceso no tiene un formato válido.';
$string['errorinvalidrequest'] = 'Solicitud inválida';
$string['errorinvalidaccesslink'] = 'El enlace de acceso no es válido.';
$string['errorssonotavailable'] = 'SSO no disponible';
$string['errorssonotavailable_desc'] = 'El acceso automático no está configurado correctamente.';
$string['erroraccessinvalid'] = 'Acceso no válido';
$string['errorsecurityvalidationfailed'] = 'La validación de seguridad del acceso ha fallado.';
$string['errordatainvalid'] = 'Datos inválidos';
$string['erroraccessdatainvalid'] = 'No se pudo validar la información del acceso.';
$string['erroraccessexpired'] = 'Acceso caducado';
$string['erroraccessexpired_desc'] = 'El enlace de acceso ha expirado. Vuelve a acceder desde tu área de cursos.';
$string['errordataincomplete'] = 'Datos incompletos';
$string['errordataincomplete_desc'] = 'No se pudo completar el acceso automático.';
$string['erroraccessusedorinvalid'] = 'El enlace de acceso no es válido o ya no puede utilizarse.';
$string['erroraccessused'] = 'Acceso ya utilizado';
$string['erroraccessused_desc'] = 'Este enlace de acceso ya ha sido utilizado. Vuelve a acceder desde tu área de cursos.';
$string['erroruserunavailable'] = 'Usuario no disponible';
$string['erroruserunavailable_desc'] = 'Tu cuenta Moodle no está disponible actualmente.';
$string['errorcourseunavailable'] = 'Curso no disponible';
$string['errorcourseunavailable_desc'] = 'El curso solicitado ya no está disponible.';
$string['erroraccessunavailable'] = 'Acceso no disponible';
$string['erroraccessunavailable_desc'] = 'No tienes una matrícula activa para este curso.';

$string['noncestorage'] = 'Almacenamiento de nonces';
$string['noncestorage_config'] = 'Los nonces se almacenan usando las APIs de configuración de Moodle.';

$string['privacy:metadata'] = 'El plugin DWW Moodle SSO no almacena datos personales en tablas propias. Solo procesa tokens SSO temporales para autenticar usuarios Moodle existentes.';

$string['logs_moodle_debugging_notice'] = 'DWW Moodle SSO usa las herramientas de depuración de Moodle y no escribe ficheros de log propios.';

$string['logs_no_custom_files'] = 'Los registros operativos no se almacenan en ficheros gestionados por el plugin. Para diagnosticar incidencias, activa la depuración de Moodle o revisa la información de diagnóstico de Moodle y del servidor web.';

$string['local_dww_sso_service'] = 'Servicio DWW Moodle Bridge';