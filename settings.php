<?php

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {

    // -----------------------------------------------------------------
    // CATEGORY
    // -----------------------------------------------------------------

    $ADMIN->add(
        'localplugins',
        new admin_category(
            'local_dww_sso_category',
            get_string('pluginname', 'local_dww_sso')
        )
    );

    // -----------------------------------------------------------------
    // SETUP WIZARD
    // -----------------------------------------------------------------

    $ADMIN->add(
        'local_dww_sso_category',
        new admin_externalpage(
            'local_dww_sso_setup',
            get_string('setupwizard', 'local_dww_sso'),
            new moodle_url('/local/dww_sso/setup.php'),
            'moodle/site:config'
        )
    );

    // -----------------------------------------------------------------
    // GENERAL SETTINGS
    // -----------------------------------------------------------------

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

    // -----------------------------------------------------------------
    // STATUS
    // -----------------------------------------------------------------

    $ADMIN->add(
        'local_dww_sso_category',
        new admin_externalpage(
            'local_dww_sso_status',
            get_string('ssostatus', 'local_dww_sso'),
            new moodle_url('/local/dww_sso/status.php'),
            'moodle/site:config'
        )
    );

    // -----------------------------------------------------------------
    // DIAGNOSTICS
    // -----------------------------------------------------------------

    $ADMIN->add(
        'local_dww_sso_category',
        new admin_externalpage(
            'local_dww_sso_diagnostics',
            get_string('diagnostics', 'local_dww_sso'),
            new moodle_url('/local/dww_sso/diagnostics.php'),
            'moodle/site:config'
        )
    );

    // -----------------------------------------------------------------
    // SECURITY
    // -----------------------------------------------------------------

    $ADMIN->add(
        'local_dww_sso_category',
        new admin_externalpage(
            'local_dww_sso_security',
            get_string('security', 'local_dww_sso'),
            new moodle_url('/local/dww_sso/security.php'),
            'moodle/site:config'
        )
    );

    // -----------------------------------------------------------------
    // LOGS
    // -----------------------------------------------------------------

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
