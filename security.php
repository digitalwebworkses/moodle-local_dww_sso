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
 * Security status page for DWW Moodle SSO.
 *
 * @package    local_dww_sso
 * @copyright  2026 Digital Web Works
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

require_login();
require_capability('moodle/site:config', context_system::instance());

/**
 * Renders a security status badge.
 *
 * @param string $status Status key.
 * @return string
 */
function local_dww_sso_status_badge($status = 'ok') {
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
        [
            'style' => 'display:inline-block;padding:6px 12px;border-radius:999px;font-weight:bold;background:' .
                $background . ';color:' . $color . ';font-size:13px;',
        ]
    );
}

$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/local/dww_sso/security.php'));
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('security', 'local_dww_sso'));
$PAGE->set_heading(get_string('pluginname', 'local_dww_sso'));

$sharedsecret = get_config('local_dww_sso', 'sharedsecret');
$secretok = !empty($sharedsecret) && strlen($sharedsecret) >= 32;

$checks = [
    [
        'label' => get_string('security_sharedsecret', 'local_dww_sso'),
        'status' => $secretok,
        'message' => $secretok
            ? get_string('security_enabled', 'local_dww_sso')
            : get_string('security_attention', 'local_dww_sso'),
    ],
    [
        'label' => get_string('security_hmac', 'local_dww_sso'),
        'status' => true,
        'message' => get_string('security_enabled', 'local_dww_sso'),
    ],
    [
        'label' => get_string('security_expiration', 'local_dww_sso'),
        'status' => true,
        'message' => get_string('security_enabled', 'local_dww_sso'),
    ],
    [
        'label' => get_string('security_nonce', 'local_dww_sso'),
        'status' => true,
        'message' => get_string('security_enabled', 'local_dww_sso'),
    ],
    [
        'label' => get_string('security_returnurl', 'local_dww_sso'),
        'status' => true,
        'message' => get_string('security_enabled', 'local_dww_sso'),
    ],
    [
        'label' => get_string('security_enrolment', 'local_dww_sso'),
        'status' => true,
        'message' => get_string('security_enabled', 'local_dww_sso'),
    ],
];

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('security', 'local_dww_sso'));

echo html_writer::start_div('box generalbox', ['style' => 'max-width:1000px;']);

echo html_writer::tag('p', get_string('security_desc', 'local_dww_sso'));

echo html_writer::start_tag('table', ['class' => 'generaltable']);
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
    echo html_writer::tag('td', local_dww_sso_status_badge($ok ? 'ok' : 'warning'));
    echo html_writer::tag('td', s($check['message']));
    echo html_writer::end_tag('tr');
}

echo html_writer::end_tag('tbody');
echo html_writer::end_tag('table');

echo html_writer::end_div();

echo $OUTPUT->footer();
