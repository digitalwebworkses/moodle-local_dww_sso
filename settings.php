<?php

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {

    $ADMIN->add(
        'localplugins',
        new admin_category(
            'local_dww_sso_category',
            get_string('pluginname', 'local_dww_sso')
        )
    );

    $settings = new admin_settingpage(
        'local_dww_sso_settings',
        get_string('generalsettings', 'local_dww_sso'),
        'moodle/site:config'
    );

    $ADMIN->add('local_dww_sso_category', $settings);

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

    $settings->add(
        new admin_setting_heading(
            'local_dww_sso/general_heading',
            get_string('generalsettings', 'local_dww_sso'),
            get_string('generalsettings_desc', 'local_dww_sso')
        )
    );

    $settings->add(
        new admin_setting_configpasswordunmask(
            'local_dww_sso/sharedsecret',
            get_string('sharedsecret', 'local_dww_sso'),
            get_string('sharedsecret_desc', 'local_dww_sso'),
            ''
        )
    );
}
