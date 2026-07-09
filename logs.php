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

 * Logging information page for DWW Moodle SSO.

 *

 * @package    local_dww_sso

 * @copyright  2026 Digital Web Works

 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

require_once(__DIR__ . '/../../config.php');

require_login();

require_capability('moodle/site:config', context_system::instance());

$PAGE->set_context(context_system::instance());

$PAGE->set_url(new moodle_url('/local/dww_sso/logs.php'));

$PAGE->set_pagelayout('admin');

$PAGE->set_title(get_string('logs', 'local_dww_sso'));

$PAGE->set_heading(get_string('pluginname', 'local_dww_sso'));

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('logs', 'local_dww_sso'));

echo html_writer::start_div(

    'box generalbox',

    [

        'style' => 'max-width:1100px;',

    ]

);

echo html_writer::tag(

    'p',

    get_string('logs_desc', 'local_dww_sso')

);

echo $OUTPUT->notification(

    get_string('logs_moodle_debugging_notice', 'local_dww_sso'),

    'info'

);

echo html_writer::tag(

    'p',

    get_string('logs_no_custom_files', 'local_dww_sso')

);

echo html_writer::end_div();

echo $OUTPUT->footer();