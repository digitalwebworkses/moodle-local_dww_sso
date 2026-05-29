<?php

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/classes/logger.php');

require_login();
require_capability('moodle/site:config', context_system::instance());

function local_dww_sso_status_badge($status = 'ok')
{
    $status = (string) $status;

    if ($status === 'ok') {
        $label = get_string('ok', 'local_dww_sso');
        $background = '#e8f5e9';
        $color = '#2e7d32';
    } else if ($status === 'warning') {
        $label = get_string('warning', 'local_dww_sso');
        $background = '#fff3e0';
        $color = '#ef6c00';
    } else {
        $label = get_string('error', 'local_dww_sso');
        $background = '#ffebee';
        $color = '#b00020';
    }

    return html_writer::tag(
        'span',
        $label,
        array(
            'style' => '
                display:inline-block;
                padding:6px 12px;
                border-radius:999px;
                font-weight:bold;
                background:' . $background . ';
                color:' . $color . ';
                font-size:13px;
            '
        )
    );
}

$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/local/dww_sso/diagnostics.php'));
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('diagnostics', 'local_dww_sso'));
$PAGE->set_heading(get_string('pluginname', 'local_dww_sso'));

$sharedsecret = get_config('local_dww_sso', 'sharedsecret');
$secretok = !empty($sharedsecret) && strlen($sharedsecret) >= 32;

$endpointfile = __DIR__ . '/login.php';
$endpointok = file_exists($endpointfile) && is_readable($endpointfile);

$noncedir = $CFG->dataroot . '/dww_sso/nonces';

if (!is_dir($noncedir)) {
    @mkdir($noncedir, 0775, true);
}

$noncewritable = is_dir($noncedir) && is_writable($noncedir);

$loggerok = class_exists('local_dww_sso_logger');

$checks = array(
    array(
        'label' => get_string('sharedsecretstatus', 'local_dww_sso'),
        'status' => $secretok,
        'message' => $secretok
            ? get_string('configured', 'local_dww_sso')
            : get_string('notconfigured', 'local_dww_sso'),
    ),
    array(
        'label' => get_string('ssoendpoint', 'local_dww_sso'),
        'status' => $endpointok,
        'message' => $endpointok
            ? (new moodle_url('/local/dww_sso/login.php'))->out(false)
            : get_string('endpointmissing', 'local_dww_sso'),
    ),
    array(
        'label' => get_string('noncedirectory', 'local_dww_sso'),
        'status' => $noncewritable,
        'message' => $noncewritable
            ? $noncedir
            : get_string('notwritable', 'local_dww_sso'),
    ),
    array(
        'label' => get_string('loggerstatus', 'local_dww_sso'),
        'status' => $loggerok,
        'message' => $loggerok
            ? get_string('available', 'local_dww_sso')
            : get_string('notavailable', 'local_dww_sso'),
    ),
    array(
        'label' => get_string('moodleversion', 'local_dww_sso'),
        'status' => true,
        'message' => $CFG->release,
    ),
    array(
        'label' => get_string('phpversion', 'local_dww_sso'),
        'status' => version_compare(PHP_VERSION, '8.0.0', '>='),
        'message' => PHP_VERSION,
    ),
);

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('diagnostics', 'local_dww_sso'));

echo html_writer::start_div('box generalbox', array('style' => 'max-width:1000px;'));

echo html_writer::tag(
    'p',
    get_string('diagnostics_desc', 'local_dww_sso')
);

echo html_writer::start_tag('table', array('class' => 'generaltable'));

echo html_writer::start_tag('thead');
echo html_writer::start_tag('tr');
echo html_writer::tag('th', get_string('check', 'local_dww_sso'));
echo html_writer::tag('th', get_string('status', 'local_dww_sso'));
echo html_writer::tag('th', get_string('details', 'local_dww_sso'));
echo html_writer::end_tag('tr');
echo html_writer::end_tag('thead');

echo html_writer::start_tag('tbody');

foreach ($checks as $check) {
    $ok = !empty($check['status']);

    echo html_writer::start_tag('tr');
    echo html_writer::tag('td', s($check['label']));
    echo html_writer::tag(
    'td',
    local_dww_sso_status_badge($ok ? 'ok' : 'error')
);

    echo html_writer::tag('td', s($check['message']));
    echo html_writer::end_tag('tr');
}

echo html_writer::end_tag('tbody');
echo html_writer::end_tag('table');

echo html_writer::end_div();

echo $OUTPUT->footer();