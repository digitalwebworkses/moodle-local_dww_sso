<?php

defined('MOODLE_INTERNAL') || die();

$services = array(
    'DWW Moodle Bridge Service' => array(
        'functions' => array(
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
        ),
        'restrictedusers' => 1,
        'enabled' => 1,
        'shortname' => 'dww_moodle_bridge_service',
    ),
);