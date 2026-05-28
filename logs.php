<?php

require_once(__DIR__ . '/../../config.php');

require_login();
require_capability('moodle/site:config', context_system::instance());

$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/local/dww_sso/logs.php'));
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('logs', 'local_dww_sso'));
$PAGE->set_heading(get_string('pluginname', 'local_dww_sso'));

$logfile = $CFG->dataroot . '/dww_sso/logs/dww_sso.log';
$entries = array();

if (file_exists($logfile) && is_readable($logfile)) {
    $lines = file($logfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if (is_array($lines)) {
        $lines = array_slice($lines, -100);
        $lines = array_reverse($lines);

        foreach ($lines as $line) {
            $decoded = json_decode($line, true);

            if (is_array($decoded)) {
                $entries[] = $decoded;
            }
        }
    }
}

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('logs', 'local_dww_sso'));

echo html_writer::start_div('box generalbox', array('style' => 'max-width:1100px;'));

echo html_writer::tag('p', get_string('logs_desc', 'local_dww_sso'));

if (empty($entries)) {
    echo $OUTPUT->notification(get_string('nologsfound', 'local_dww_sso'), 'notifymessage');
} else {
    echo html_writer::start_tag('table', array('class' => 'generaltable'));

    echo html_writer::start_tag('thead');
    echo html_writer::start_tag('tr');
    echo html_writer::tag('th', get_string('time', 'local_dww_sso'));
    echo html_writer::tag('th', get_string('level', 'local_dww_sso'));
    echo html_writer::tag('th', get_string('message', 'local_dww_sso'));
    echo html_writer::tag('th', get_string('details', 'local_dww_sso'));
    echo html_writer::end_tag('tr');
    echo html_writer::end_tag('thead');

    echo html_writer::start_tag('tbody');

    foreach ($entries as $entry) {
        $level = strtoupper((string)($entry['level'] ?? ''));
        $color = '#50575e';

        if ($level === 'ERROR') {
            $color = '#b00020';
        } else if ($level === 'WARNING') {
            $color = '#b26a00';
        } else if ($level === 'INFO') {
            $color = '#357a38';
        }

        $context = !empty($entry['context'])
            ? json_encode($entry['context'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            : '';

        echo html_writer::start_tag('tr');
        echo html_writer::tag('td', s($entry['time'] ?? ''));
        echo html_writer::tag('td', s($level), array('style' => 'font-weight:bold;color:' . $color . ';'));
        echo html_writer::tag('td', s($entry['message'] ?? ''));
        echo html_writer::tag('td', html_writer::tag('code', s($context)));
        echo html_writer::end_tag('tr');
    }

    echo html_writer::end_tag('tbody');
    echo html_writer::end_tag('table');
}

echo html_writer::end_div();

echo $OUTPUT->footer();