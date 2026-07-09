<?php
// This file is part of Moodle - https://moodle.org/
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

/**
 * Single Sign-On entry point for DWW Moodle SSO.
 *
 * @package    local_dww_sso
 * @copyright  2026 Digital Web Works
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

ob_start();

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/moodlelib.php');
require_once(__DIR__ . '/classes/logger.php');

/**
 * Renders a controlled SSO error page.
 *
 * @param string $title Error title.
 * @param string $message Error message.
 * @param string $returnurl Optional safe return URL.
 * @return void
 */
function local_dww_sso_render_error($title, $message, $returnurl = '') {
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
    echo html_writer::tag(
        'p',
        s($message),
        array(
            'style' => 'margin-top:20px;font-size:16px;',
        )
    );

    if (!empty($returnurl)) {
        echo html_writer::start_div('', array('style' => 'margin-top:30px;'));
        echo html_writer::link(
            $returnurl,
            get_string('returntosite', 'local_dww_sso'),
            array('class' => 'btn btn-primary')
        );
        echo html_writer::end_div();
    }

    echo html_writer::end_div();
    echo $OUTPUT->footer();

    exit;
}

/**
 * Returns a safe internal or Moodle-owned return URL.
 *
 * @param string $returnurl Requested return URL.
 * @return string
 */
function local_dww_sso_get_safe_return_url($returnurl) {
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

/**
 * Checks and stores whether a nonce was already used.
 *
 * Nonces are stored using Moodle configuration APIs instead of writing
 * files manually to dataroot. This keeps the plugin compliant with Moodle
 * filesystem expectations and avoids custom plugin-managed files.
 *
 * @param string $nonce Nonce value.
 * @return bool True if the nonce was already used.
 */
function local_dww_sso_nonce_was_used($nonce) {
    $hash = sha1($nonce);
    $configname = 'usednonce_' . $hash;

    $used = get_config('local_dww_sso', $configname);

    if (!empty($used)) {
        return true;
    }

    set_config($configname, time(), 'local_dww_sso');

    return false;
}

global $DB;

$token = required_param('token', PARAM_RAW_TRIMMED);

if (empty($token)) {
    local_dww_sso_logger::warning('Empty SSO token.');

    local_dww_sso_render_error(
        get_string('errorinvalidlink', 'local_dww_sso'),
        get_string('errorinvalidlink_desc', 'local_dww_sso'),
        '/'
    );
}

if (strlen($token) > 4096) {
    local_dww_sso_logger::warning(
        'SSO token too large.',
        array(
            'length' => strlen($token),
        )
    );

    local_dww_sso_render_error(
        get_string('errorinvalidrequest', 'local_dww_sso'),
        get_string('errorinvalidaccesslink', 'local_dww_sso'),
        '/'
    );
}

local_dww_sso_logger::info(
    'SSO request started.',
    array(
        'has_token' => true,
        'ip'        => $_SERVER['REMOTE_ADDR'] ?? '',
        'useragent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
    )
);

$parts = explode('.', $token);

if (count($parts) !== 2) {
    local_dww_sso_logger::warning('Invalid SSO token format.');

    local_dww_sso_render_error(
        get_string('errorinvalidlink', 'local_dww_sso'),
        get_string('errorinvalidlink_desc', 'local_dww_sso'),
        '/'
    );
}

$payloadencoded = $parts[0];
$signature = $parts[1];

if (
    empty($payloadencoded) ||
    empty($signature) ||
    !preg_match('/^[A-Za-z0-9\-_]+$/', $payloadencoded) ||
    !preg_match('/^[a-f0-9]{64}$/i', $signature)
) {
    local_dww_sso_logger::warning('SSO token contains invalid characters.');

    local_dww_sso_render_error(
        get_string('errorinvalidlink', 'local_dww_sso'),
        get_string('errorinvalidlink_desc', 'local_dww_sso'),
        '/'
    );
}

$sharedsecret = get_config('local_dww_sso', 'sharedsecret');

if (empty($sharedsecret) && !empty($CFG->dww_sso_secret)) {
    $sharedsecret = $CFG->dww_sso_secret;
}

if (empty($sharedsecret) || strlen($sharedsecret) < 32) {
    local_dww_sso_logger::error('SSO shared secret is missing or too weak.');

    local_dww_sso_render_error(
        get_string('errorssonotavailable', 'local_dww_sso'),
        get_string('errorssonotavailable_desc', 'local_dww_sso'),
        '/'
    );
}

$expectedsignature = hash_hmac(
    'sha256',
    $payloadencoded,
    $sharedsecret
);

if (!hash_equals($expectedsignature, $signature)) {
    local_dww_sso_logger::warning('Invalid SSO signature.');

    local_dww_sso_render_error(
        get_string('erroraccessinvalid', 'local_dww_sso'),
        get_string('errorsecurityvalidationfailed', 'local_dww_sso'),
        '/'
    );
}

$payloadjson = base64_decode(
    strtr($payloadencoded, '-_', '+/'),
    true
);

if ($payloadjson === false) {
    local_dww_sso_logger::warning('SSO payload could not be decoded.');

    local_dww_sso_render_error(
        get_string('errordatainvalid', 'local_dww_sso'),
        get_string('erroraccessdatainvalid', 'local_dww_sso'),
        '/'
    );
}

$payload = json_decode($payloadjson, true);

if (empty($payload) || json_last_error() !== JSON_ERROR_NONE) {
    local_dww_sso_logger::warning('Invalid SSO payload JSON.');

    local_dww_sso_render_error(
        get_string('errordatainvalid', 'local_dww_sso'),
        get_string('erroraccessdatainvalid', 'local_dww_sso'),
        '/'
    );
}

$moodleuserid = !empty($payload['moodle_user_id']) ? (int) $payload['moodle_user_id'] : 0;
$courseid = !empty($payload['course_id']) ? (int) $payload['course_id'] : 0;
$expires = !empty($payload['expires']) ? (int) $payload['expires'] : 0;
$nonce = !empty($payload['nonce']) ? clean_param($payload['nonce'], PARAM_ALPHANUMEXT) : '';

$returnurl = !empty($payload['return_url'])
    ? local_dww_sso_get_safe_return_url($payload['return_url'])
    : '/';

local_dww_sso_logger::info(
    'SSO payload received.',
    array(
        'moodle_user_id' => $moodleuserid,
        'course_id'      => $courseid,
        'expires'        => $expires,
    )
);

if (empty($expires) || time() > $expires) {
    local_dww_sso_logger::warning(
        'Expired SSO token.',
        array(
            'moodle_user_id' => $moodleuserid,
            'course_id'      => $courseid,
            'expires'        => $expires,
            'now'            => time(),
        )
    );

    local_dww_sso_render_error(
        get_string('erroraccessexpired', 'local_dww_sso'),
        get_string('erroraccessexpired_desc', 'local_dww_sso'),
        $returnurl
    );
}

if (empty($moodleuserid) || empty($courseid)) {
    local_dww_sso_logger::warning(
        'Incomplete SSO payload.',
        array(
            'moodle_user_id' => $moodleuserid,
            'course_id'      => $courseid,
        )
    );

    local_dww_sso_render_error(
        get_string('errordataincomplete', 'local_dww_sso'),
        get_string('errordataincomplete_desc', 'local_dww_sso'),
        $returnurl
    );
}

if (empty($nonce) || !preg_match('/^[a-f0-9\-]{36}$/i', $nonce)) {
    local_dww_sso_logger::warning(
        'Missing or invalid SSO nonce.',
        array(
            'moodle_user_id' => $moodleuserid,
            'course_id'      => $courseid,
        )
    );

    local_dww_sso_render_error(
        get_string('erroraccessinvalid', 'local_dww_sso'),
        get_string('erroraccessusedorinvalid', 'local_dww_sso'),
        $returnurl
    );
}

if (local_dww_sso_nonce_was_used($nonce)) {
    local_dww_sso_logger::warning(
        'Blocked SSO token reuse attempt.',
        array(
            'moodle_user_id' => $moodleuserid,
            'course_id'      => $courseid,
            'nonce'          => substr($nonce, 0, 8) . '...',
        )
    );

    local_dww_sso_render_error(
        get_string('erroraccessused', 'local_dww_sso'),
        get_string('erroraccessused_desc', 'local_dww_sso'),
        $returnurl
    );
}

$user = $DB->get_record(
    'user',
    array(
        'id'        => $moodleuserid,
        'deleted'   => 0,
        'suspended' => 0,
    )
);

if (!$user) {
    local_dww_sso_logger::error(
        'Moodle user not found or suspended.',
        array(
            'moodle_user_id' => $moodleuserid,
        )
    );

    local_dww_sso_render_error(
        get_string('erroruserunavailable', 'local_dww_sso'),
        get_string('erroruserunavailable_desc', 'local_dww_sso'),
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
        'Moodle course not found.',
        array(
            'course_id' => $courseid,
        )
    );

    local_dww_sso_render_error(
        get_string('errorcourseunavailable', 'local_dww_sso'),
        get_string('errorcourseunavailable_desc', 'local_dww_sso'),
        $returnurl
    );
}

$context = context_course::instance($courseid, IGNORE_MISSING);

if (!$context || !is_enrolled($context, $user, '', true)) {
    local_dww_sso_logger::warning(
        'User is not actively enrolled in requested course.',
        array(
            'moodle_user_id' => $moodleuserid,
            'course_id'      => $courseid,
        )
    );

    local_dww_sso_render_error(
        get_string('erroraccessunavailable', 'local_dww_sso'),
        get_string('erroraccessunavailable_desc', 'local_dww_sso'),
        $returnurl
    );
}

local_dww_sso_logger::info(
    'SSO login validated. Starting Moodle session.',
    array(
        'moodle_user_id' => $moodleuserid,
        'course_id'      => $courseid,
    )
);

if (ob_get_length()) {
    ob_end_clean();
}

complete_user_login($user);

local_dww_sso_logger::info(
    'SSO login completed. Redirecting to course.',
    array(
        'moodle_user_id' => $moodleuserid,
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