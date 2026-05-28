<?php

require_once(__DIR__ . '/../../config.php');

require_login();
require_capability('moodle/site:config', context_system::instance());

$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/local/dww_sso/security.php'));
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('security', 'local_dww_sso'));
$PAGE->set_heading(get_string('pluginname', 'local_dww_sso'));

$sharedsecret = get_config('local_dww_sso', 'sharedsecret');
$secretok = !empty($sharedsecret) && strlen($sharedsecret) >= 32;

$checks = array(
    array(
        'label' => get_string('security_sharedsecret', 'local_dww_sso'),
        'status' => $secretok,
        'message' => $secretok ? get_string('security_enabled', 'local_dww_sso') : get_string('security_attention', 'local_dww_sso'),
    ),
    array(
        'label' => get_string('security_hmac', 'local_dww_sso'),
        'status' => true,
        'message' => get_string('security_enabled', 'local_dww_sso'),
    ),
    array(
        'label' => get_string('security_expiration', 'local_dww_sso'),
        'status' => true,
        'message' => get_string('security_enabled', 'local_dww_sso'),
    ),
    array(
        'label' => get_string('security_nonce', 'local_dww_sso'),
        'status' => true,
        'message' => get_string('security_enabled', 'local_dww_sso'),
    ),
    array(
        'label' => get_string('security_returnurl', 'local_dww_sso'),
        'status' => true,
        'message' => get_string('security_enabled', 'local_dww_sso'),
    ),
    array(
        'label' => get_string('security_enrolment', 'local_dww_sso'),
        'status' => true,
        'message' => get_string('security_enabled', 'local_dww_sso'),
    ),
);

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('security', 'local_dww_sso'));

echo html_writer::start_div('box generalbox', array('style' => 'max-width:1000px;'));

echo html_writer::tag('p', get_string('security_desc', 'local_dww_sso'));

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
        $ok ? get_string('ok', 'local_dww_sso') : get_string('warning', 'local_dww_sso'),
        array(
            'style' => $ok
                ? 'font-weight:bold;color:#357a38;'
                : 'font-weight:bold;color:#b26a00;',
        )
    );
    echo html_writer::tag('td', s($check['message']));
    echo html_writer::end_tag('tr');
}

echo html_writer::end_tag('tbody');
echo html_writer::end_tag('table');

echo html_writer::end_div();

echo $OUTPUT->footer();