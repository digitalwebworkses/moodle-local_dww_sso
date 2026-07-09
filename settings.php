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
 * Administration settings for DWW Moodle SSO.
 *
 * @package    local_dww_sso
 * @copyright  2026 Digital Web Works
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $ADMIN->add(
        'localplugins',
        new admin_category(
            'local_dww_sso_category',
            get_string('pluginname', 'local_dww_sso')
        )
    );

    $ADMIN->add(
        'local_dww_sso_category',
        new admin_externalpage(
            'local_dww_sso_setup',
            get_string('setupwizard', 'local_dww_sso'),
            new moodle_url('/local/dww_sso/setup.php'),
            'moodle/site:config'
        )
    );

    $settings = new admin_settingpage(
        'local_dww_sso',
        get_string('generalsettings', 'local_dww_sso'),
        'moodle/site:config'
    );

    $settings->add(
        new admin_setting_configpasswordunmask(
            'local_dww_sso/sharedsecret',
            get_string('sharedsecret', 'local_dww_sso'),
            get_string('sharedsecret_desc', 'local_dww_sso'),
            ''
        )
    );

    $settings->add(
        new admin_setting_configtext(
            'local_dww_sso/wordpressurl',
            get_string('wordpressurl', 'local_dww_sso'),
            get_string('wordpressurl_desc', 'local_dww_sso'),
            '',
            PARAM_URL
        )
    );

    $ADMIN->add(
        'local_dww_sso_category',
        $settings
    );

    $ADMIN->add(
        'local_dww_sso_category',
        new admin_externalpage(
            'local_dww_sso_status',
            get_string('ssostatus', 'local_dww_sso'),
            new moodle_url('/local/dww_sso/status.php'),
            'moodle/site:config'
        )
    );

    $ADMIN->add(
        'local_dww_sso_category',
        new admin_externalpage(
            'local_dww_sso_diagnostics',
            get_string('diagnostics', 'local_dww_sso'),
            new moodle_url('/local/dww_sso/diagnostics.php'),
            'moodle/site:config'
        )
    );

    $ADMIN->add(
        'local_dww_sso_category',
        new admin_externalpage(
            'local_dww_sso_security',
            get_string('security', 'local_dww_sso'),
            new moodle_url('/local/dww_sso/security.php'),
            'moodle/site:config'
        )
    );

    $ADMIN->add(
        'local_dww_sso_category',
        new admin_externalpage(
            'local_dww_sso_logs',
            get_string('logs', 'local_dww_sso'),
            new moodle_url('/local/dww_sso/logs.php'),
            'moodle/site:config'
        )
    );
}