<?php

require_once(__DIR__ . '/../../config.php');

require_login();
require_capability('moodle/site:config', context_system::instance());

$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/local/dww_sso/status.php'));
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('ssostatus', 'local_dww_sso'));
$PAGE->set_heading(get_string('pluginname', 'local_dww_sso'));

$sharedsecret = get_config('local_dww_sso', 'sharedsecret');
$secretconfigured = !empty($sharedsecret) && strlen($sharedsecret) >= 32;

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('ssostatus', 'local_dww_sso'));

echo html_writer::start_div('box generalbox', array('style' => 'max-width:900px;'));

echo html_writer::tag(
    'h3',
    get_string('systemstatus', 'local_dww_sso')
);

echo html_writer::start_tag('table', array('class' => 'generaltable'));

echo html_writer::start_tag('tbody');

$rows = array(
    get_string('pluginversion', 'local_dww_sso') => '1.0.0-rc1',
    get_string('moodleversion', 'local_dww_sso') => $CFG->release,
    get_string('sharedsecretstatus', 'local_dww_sso') => $secretconfigured
        ? get_string('configured', 'local_dww_sso')
        : get_string('notconfigured', 'local_dww_sso'),
    get_string('ssoendpoint', 'local_dww_sso') => (new moodle_url('/local/dww_sso/login.php'))->out(false),
);

foreach ($rows as $label => $value) {
    echo html_writer::start_tag('tr');
    echo html_writer::tag('th', s($label), array('style' => 'width:260px;'));
    echo html_writer::tag('td', s($value));
    echo html_writer::end_tag('tr');
}

echo html_writer::end_tag('tbody');
echo html_writer::end_tag('table');

echo html_writer::end_div();

echo $OUTPUT->footer();