<?php

require_once(__DIR__ . '/../../config.php');

require_login();
require_capability('moodle/site:config', context_system::instance());

$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/local/dww_sso/setup.php'));
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('setupwizard', 'local_dww_sso'));
$PAGE->set_heading(get_string('pluginname', 'local_dww_sso'));

global $CFG;

$sharedsecret = get_config('local_dww_sso', 'sharedsecret');

$checks = array(
    array(
        'label' => get_string('setup_sharedsecret', 'local_dww_sso'),
        'status' => !empty($sharedsecret) && strlen($sharedsecret) >= 32,
    ),
    array(
        'label' => get_string('setup_login_endpoint', 'local_dww_sso'),
        'status' => file_exists(__DIR__ . '/login.php'),
    ),
    array(
        'label' => get_string('setup_logs', 'local_dww_sso'),
        'status' => is_writable($CFG->dataroot),
    ),
);

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('setupwizard', 'local_dww_sso'));

echo html_writer::start_div(
    'box generalbox',
    array(
        'style' => 'max-width:1000px;'
    )
);

echo html_writer::tag(
    'p',
    get_string('setupwizard_desc', 'local_dww_sso')
);

// -----------------------------------------------------------------
// STEP 1
// -----------------------------------------------------------------

echo html_writer::tag(
    'h3',
    get_string('setup_step1', 'local_dww_sso')
);

echo html_writer::alist(array(
    get_string('setup_step1_item1', 'local_dww_sso'),
    get_string('setup_step1_item2', 'local_dww_sso'),
    get_string('setup_step1_item3', 'local_dww_sso'),
));

// -----------------------------------------------------------------
// VALIDATIONS
// -----------------------------------------------------------------

echo html_writer::tag(
    'h3',
    get_string('setup_validation', 'local_dww_sso')
);

echo html_writer::start_tag(
    'table',
    array(
        'class' => 'generaltable'
    )
);

echo html_writer::start_tag('thead');

echo html_writer::start_tag('tr');

echo html_writer::tag(
    'th',
    get_string('check', 'local_dww_sso')
);

echo html_writer::tag(
    'th',
    get_string('status', 'local_dww_sso')
);

echo html_writer::end_tag('tr');

echo html_writer::end_tag('thead');

echo html_writer::start_tag('tbody');

foreach ($checks as $check) {

    $ok = !empty($check['status']);

    echo html_writer::start_tag('tr');

    echo html_writer::tag(
        'td',
        s($check['label'])
    );

    echo html_writer::tag(
        'td',
        $ok
            ? get_string('ok', 'local_dww_sso')
            : get_string('warning', 'local_dww_sso'),
        array(
            'style' => $ok
                ? 'font-weight:bold;color:#357a38;'
                : 'font-weight:bold;color:#b26a00;',
        )
    );

    echo html_writer::end_tag('tr');
}

echo html_writer::end_tag('tbody');

echo html_writer::end_tag('table');

// -----------------------------------------------------------------
// WORDPRESS CONNECTION INFO
// -----------------------------------------------------------------

echo html_writer::tag(
    'h3',
    get_string('setup_wordpress', 'local_dww_sso')
);

echo html_writer::start_tag(
    'table',
    array(
        'class' => 'generaltable'
    )
);

echo html_writer::start_tag('tbody');

$rows = array(
    array(
        get_string('setup_moodle_url', 'local_dww_sso'),
        $CFG->wwwroot,
    ),
    array(
        get_string('setup_sso_endpoint', 'local_dww_sso'),
        $CFG->wwwroot . '/local/dww_sso/login.php',
    ),
    array(
        get_string('setup_sharedsecret_status', 'local_dww_sso'),
        !empty($sharedsecret)
            ? get_string('configured', 'local_dww_sso')
            : get_string('notconfigured', 'local_dww_sso'),
    ),
    array(
        get_string('setup_moodle_version', 'local_dww_sso'),
        $CFG->release,
    ),
    array(
        get_string('setup_php_version', 'local_dww_sso'),
        PHP_VERSION,
    ),
);

foreach ($rows as $row) {

    echo html_writer::start_tag('tr');

    echo html_writer::tag(
        'th',
        s($row[0]),
        array(
            'style' => 'width:320px;'
        )
    );

    echo html_writer::tag(
        'td',
        s($row[1])
    );

    echo html_writer::end_tag('tr');
}

echo html_writer::end_tag('tbody');

echo html_writer::end_tag('table');

// -----------------------------------------------------------------
// NEXT STEPS
// -----------------------------------------------------------------

echo html_writer::tag(
    'h3',
    get_string('setup_nextsteps', 'local_dww_sso')
);

echo html_writer::alist(array(
    get_string('setup_nextsteps_item1', 'local_dww_sso'),
    get_string('setup_nextsteps_item2', 'local_dww_sso'),
    get_string('setup_nextsteps_item3', 'local_dww_sso'),
));

echo html_writer::tag(
    'p',
    get_string('setup_wordpress_note', 'local_dww_sso'),
    array(
        'style' => 'margin-top:20px;font-weight:bold;'
    )
);

echo html_writer::end_div();

echo $OUTPUT->footer();