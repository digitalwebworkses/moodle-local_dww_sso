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

/**
 * Displays the current operational status of the DWW Moodle SSO plugin.
 *
 * @package    local_dww_sso
 * @copyright  2026 Digital Web Works
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/version.php');

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

echo html_writer::start_div(
    'box generalbox',
    ['style' => 'max-width:900px;']
);

echo html_writer::tag(
    'h3',
    get_string('systemstatus', 'local_dww_sso')
);

echo html_writer::start_tag(
    'table',
    ['class' => 'generaltable']
);

echo html_writer::start_tag('tbody');

$rows = [
    get_string('pluginversion', 'local_dww_sso')      => $plugin->release,
    get_string('moodleversion', 'local_dww_sso')      => $CFG->release,
    get_string('sharedsecretstatus', 'local_dww_sso') => $secretconfigured
        ? get_string('configured', 'local_dww_sso')
        : get_string('notconfigured', 'local_dww_sso'),
    get_string('ssoendpoint', 'local_dww_sso')        => (new moodle_url('/local/dww_sso/login.php'))->out(false),
];

foreach ($rows as $label => $value) {
    echo html_writer::start_tag('tr');

    echo html_writer::tag(
        'th',
        s($label),
        ['style' => 'width:260px;']
    );

    echo html_writer::tag(
        'td',
        s($value)
    );

    echo html_writer::end_tag('tr');
}

echo html_writer::end_tag('tbody');
echo html_writer::end_tag('table');

echo html_writer::end_div();

echo $OUTPUT->footer();