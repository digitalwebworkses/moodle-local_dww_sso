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

 * External service definitions for DWW Moodle SSO.

 *

 * @package    local_dww_sso

 * @copyright  2026 Digital Web Works

 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later

 */

defined('MOODLE_INTERNAL') || die();

$services = [

    'local_dww_sso_service' => [

        'functions' => [

            'core_webservice_get_site_info',

            'core_course_get_courses',

            'core_course_get_courses_by_field',

            'core_user_get_users',

            'core_user_get_users_by_field',

            'core_user_create_users',

            'core_user_update_users',

            'core_enrol_get_enrolled_users',

            'enrol_manual_enrol_users',

            'enrol_manual_unenrol_users',

        ],

        'restrictedusers' => 1,

        'enabled' => 1,

        'shortname' => 'dww_moodle_bridge_service',

    ],

];