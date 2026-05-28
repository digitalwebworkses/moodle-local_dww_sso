<?php

ob_start();

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/moodlelib.php');
require_once(__DIR__ . '/classes/logger.php');

function local_dww_sso_render_error($title, $message, $returnurl = '')
{
    global $OUTPUT, $PAGE, $SITE;

    if (ob_get_length()) {
        ob_end_clean();
    }

    $PAGE->set_context(context_system::instance());
    $PAGE->set_url(new moodle_url('/local/dww_sso/login.php'));
    $PAGE->set_pagelayout('standard');
    $PAGE->set_title($title);
    $PAGE->set_heading($SITE->fullname);

    echo $OUTPUT->header();

    echo html_writer::start_div(
        'local-dww-sso-error',
        array(
            'style' => 'max-width:700px;margin:40px auto;padding:30px;background:#fff;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,.08);text-align:center;'
        )
    );

    echo html_writer::tag('h2', s($title));
    echo html_writer::tag('p', s($message), array('style' => 'margin-top:20px;font-size:16px;'));

    if (!empty($returnurl)) {
        echo html_writer::start_div('', array('style' => 'margin-top:30px;'));
        echo html_writer::link($returnurl, 'Volver al sitio', array('class' => 'btn btn-primary'));
        echo html_writer::end_div();
    }

    echo html_writer::end_div();
    echo $OUTPUT->footer();

    exit;
}

function local_dww_sso_get_safe_return_url($returnurl)
{
    global $CFG;

    if (empty($returnurl)) {
        return '/';
    }

    $returnurl = clean_param($returnurl, PARAM_URL);

    if (empty($returnurl)) {
        return '/';
    }

    if (strpos($returnurl, '/') === 0 && strpos($returnurl, '//') !== 0) {
        return $returnurl;
    }

    $wwwroot = rtrim($CFG->wwwroot, '/');

    if (strpos($returnurl, $wwwroot) === 0) {
        return $returnurl;
    }

    return '/';
}

function local_dww_sso_nonce_was_used($nonce)
{
    global $CFG;

    $dir = $CFG->dataroot . '/dww_sso/nonces';

    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    $file = $dir . '/' . sha1($nonce) . '.used';

    if (file_exists($file)) {
        return true;
    }

    file_put_contents($file, (string) time(), LOCK_EX);

    return false;
}

global $DB, $CFG;

$token = required_param('token', PARAM_RAW_TRIMMED);

if (empty($token)) {
    local_dww_sso_logger::warning('Token SSO vacío.');

    local_dww_sso_render_error(
        'Enlace inválido',
        'El enlace de acceso no tiene un formato válido.',
        '/'
    );
}

if (strlen($token) > 4096) {
    local_dww_sso_logger::warning(
        'Token SSO demasiado grande.',
        array(
            'length' => strlen($token),
        )
    );

    local_dww_sso_render_error(
        'Solicitud inválida',
        'El enlace de acceso no es válido.',
        '/'
    );
}

local_dww_sso_logger::info(
    'Inicio de petición SSO.',
    array(
        'has_token' => true,
        'ip'        => $_SERVER['REMOTE_ADDR'] ?? '',
        'useragent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
    )
);

$parts = explode('.', $token);

if (count($parts) !== 2) {
    local_dww_sso_logger::warning('Formato de token inválido.');

    local_dww_sso_render_error(
        'Enlace inválido',
        'El enlace de acceso no tiene un formato válido.',
        '/'
    );
}

$payload_encoded = $parts[0];
$signature       = $parts[1];

if (
    empty($payload_encoded) ||
    empty($signature) ||
    !preg_match('/^[A-Za-z0-9\-_]+$/', $payload_encoded) ||
    !preg_match('/^[a-f0-9]{64}$/i', $signature)
) {
    local_dww_sso_logger::warning('Token SSO con caracteres inválidos.');

    local_dww_sso_render_error(
        'Enlace inválido',
        'El enlace de acceso no tiene un formato válido.',
        '/'
    );
}

$sharedsecret = get_config('local_dww_sso', 'sharedsecret');

if (empty($sharedsecret) && !empty($CFG->dww_sso_secret)) {
    $sharedsecret = $CFG->dww_sso_secret;
}

if (empty($sharedsecret) || strlen($sharedsecret) < 32) {
    local_dww_sso_logger::error('Secreto SSO no configurado o demasiado débil.');

    local_dww_sso_render_error(
        'SSO no disponible',
        'El acceso automático no está configurado correctamente.',
        '/'
    );
}

$expected_signature = hash_hmac(
    'sha256',
    $payload_encoded,
    $sharedsecret
);

if (!hash_equals($expected_signature, $signature)) {
    local_dww_sso_logger::warning('Firma SSO inválida.');

    local_dww_sso_render_error(
        'Acceso no válido',
        'La validación de seguridad del acceso ha fallado.',
        '/'
    );
}

$payload_json = base64_decode(
    strtr($payload_encoded, '-_', '+/'),
    true
);

if ($payload_json === false) {
    local_dww_sso_logger::warning('Payload SSO no decodificable.');

    local_dww_sso_render_error(
        'Datos inválidos',
        'No se pudo validar la información del acceso.',
        '/'
    );
}

$payload = json_decode($payload_json, true);

if (empty($payload) || json_last_error() !== JSON_ERROR_NONE) {
    local_dww_sso_logger::warning('Payload SSO inválido.');

    local_dww_sso_render_error(
        'Datos inválidos',
        'No se pudo validar la información del acceso.',
        '/'
    );
}

$moodle_user_id = !empty($payload['moodle_user_id']) ? (int) $payload['moodle_user_id'] : 0;
$courseid       = !empty($payload['course_id']) ? (int) $payload['course_id'] : 0;
$expires        = !empty($payload['expires']) ? (int) $payload['expires'] : 0;
$nonce          = !empty($payload['nonce']) ? clean_param($payload['nonce'], PARAM_ALPHANUMEXT) : '';

$returnurl = !empty($payload['return_url'])
    ? local_dww_sso_get_safe_return_url($payload['return_url'])
    : '/';

local_dww_sso_logger::info(
    'Payload SSO recibido.',
    array(
        'moodle_user_id' => $moodle_user_id,
        'course_id'      => $courseid,
        'expires'        => $expires,
    )
);

if (empty($expires) || time() > $expires) {
    local_dww_sso_logger::warning(
        'Token SSO expirado.',
        array(
            'moodle_user_id' => $moodle_user_id,
            'course_id'      => $courseid,
            'expires'        => $expires,
            'now'            => time(),
        )
    );

    local_dww_sso_render_error(
        'Acceso caducado',
        'El enlace de acceso ha expirado. Vuelve a acceder desde tu área de cursos.',
        $returnurl
    );
}

if (empty($moodle_user_id) || empty($courseid)) {
    local_dww_sso_logger::warning(
        'Payload SSO incompleto.',
        array(
            'moodle_user_id' => $moodle_user_id,
            'course_id'      => $courseid,
        )
    );

    local_dww_sso_render_error(
        'Datos incompletos',
        'No se pudo completar el acceso automático.',
        $returnurl
    );
}

if (empty($nonce) || !preg_match('/^[a-f0-9\-]{36}$/i', $nonce)) {
    local_dww_sso_logger::warning(
        'Payload SSO sin nonce válido.',
        array(
            'moodle_user_id' => $moodle_user_id,
            'course_id'      => $courseid,
        )
    );

    local_dww_sso_render_error(
        'Acceso no válido',
        'El enlace de acceso no es válido o ya no puede utilizarse.',
        $returnurl
    );
}

if (local_dww_sso_nonce_was_used($nonce)) {
    local_dww_sso_logger::warning(
        'Intento de reutilización de token SSO bloqueado.',
        array(
            'moodle_user_id' => $moodle_user_id,
            'course_id'      => $courseid,
            'nonce'          => substr($nonce, 0, 8) . '...',
        )
    );

    local_dww_sso_render_error(
        'Acceso ya utilizado',
        'Este enlace de acceso ya ha sido utilizado. Vuelve a acceder desde tu área de cursos.',
        $returnurl
    );
}

$user = $DB->get_record(
    'user',
    array(
        'id'        => $moodle_user_id,
        'deleted'   => 0,
        'suspended' => 0,
    )
);

if (!$user) {
    local_dww_sso_logger::error(
        'Usuario Moodle no encontrado o suspendido.',
        array(
            'moodle_user_id' => $moodle_user_id,
        )
    );

    local_dww_sso_render_error(
        'Usuario no disponible',
        'Tu cuenta Moodle no está disponible actualmente.',
        $returnurl
    );
}

$course = $DB->get_record(
    'course',
    array(
        'id' => $courseid,
    )
);

if (!$course) {
    local_dww_sso_logger::error(
        'Curso Moodle no encontrado.',
        array(
            'course_id' => $courseid,
        )
    );

    local_dww_sso_render_error(
        'Curso no disponible',
        'El curso solicitado ya no está disponible.',
        $returnurl
    );
}

$context = context_course::instance($courseid, IGNORE_MISSING);

if (!$context || !is_enrolled($context, $user, '', true)) {
    local_dww_sso_logger::warning(
        'Usuario sin matrícula activa en el curso solicitado.',
        array(
            'moodle_user_id' => $moodle_user_id,
            'course_id'      => $courseid,
        )
    );

    local_dww_sso_render_error(
        'Acceso no disponible',
        'No tienes una matrícula activa para este curso.',
        $returnurl
    );
}

local_dww_sso_logger::info(
    'Login SSO validado. Iniciando sesión Moodle.',
    array(
        'moodle_user_id' => $moodle_user_id,
        'course_id'      => $courseid,
    )
);

if (ob_get_length()) {
    ob_end_clean();
}

complete_user_login($user);

local_dww_sso_logger::info(
    'Login SSO completado. Redirigiendo al curso.',
    array(
        'moodle_user_id' => $moodle_user_id,
        'course_id'      => $courseid,
    )
);

redirect(
    new moodle_url(
        '/course/view.php',
        array(
            'id' => $courseid,
        )
    )
);
