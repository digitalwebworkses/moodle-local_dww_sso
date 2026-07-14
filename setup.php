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
 * Retrieves the health status exposed by the companion
 * DWW Moodle Bridge plugin running on WordPress.
 *
 * This request is optional and is only executed from the
 * administrator setup page in order to validate the
 * installation.
 *
 * No personal user information is transmitted.
 */


require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/filelib.php');

require_login();
require_capability('moodle/site:config', context_system::instance());

$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/local/dww_sso/setup.php'));
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('setupwizard', 'local_dww_sso'));
$PAGE->set_heading(get_string('pluginname', 'local_dww_sso'));

global $CFG;

function local_dww_sso_status_badge($ok = true)
{
    $label = $ok
        ? get_string('ok', 'local_dww_sso')
        : get_string('warning', 'local_dww_sso');

    $background = $ok
        ? '#e8f5e9'
        : '#fff3e0';

    $color = $ok
        ? '#2e7d32'
        : '#ef6c00';

    return html_writer::tag(
        'span',
        $label,
        array(
            'style' => '
                display:inline-block;
                padding:6px 12px;
                border-radius:999px;
                font-weight:bold;
                background:' . $background . ';
                color:' . $color . ';
                font-size:13px;
            '
        )
    );
}

$sharedsecret = get_config('local_dww_sso', 'sharedsecret');

$wordpressurl = trim(
    (string) get_config('local_dww_sso', 'wordpressurl')
);

$wphealth = null;

if (!empty($wordpressurl)) {

    $healthurl = rtrim($wordpressurl, '/') . '/wp-json/dwwmb/v1/health';

    $curl = new curl();

    try {

        $response = $curl->get($healthurl);

        if (!empty($response)) {

            $decoded = json_decode($response, true);

            if (
                !empty($decoded) &&
                is_array($decoded)
            ) {
                $wphealth = $decoded;
            }
        }
    } catch (Exception $e) {
        local_dww_sso_logger::warning(
            'Unable to retrieve WordPress health information.',
            [
                'exception' => $e->getMessage(),
            ]
        );
        $wphealth = null;
    }
}

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

$totalchecks = count($checks);

$passedchecks = 0;

foreach ($checks as $check) {
    if (!empty($check['status'])) {
        $passedchecks++;
    }
}

$readiness = (int) round(
    ($passedchecks / $totalchecks) * 100
);

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('setupwizard', 'local_dww_sso'));

$color = '#c62828';

if ($readiness >= 100) {
    $color = '#2e7d32';
} else if ($readiness >= 60) {
    $color = '#ef6c00';
}

echo html_writer::div(
    html_writer::tag(
        'strong',
        get_string('setup_readiness', 'local_dww_sso') . ': ' . $readiness . '%'
    ),
    '',
    array(
        'style' => '
            margin-bottom:25px;
            padding:16px;
            border-radius:8px;
            background:#f5f5f5;
            font-size:18px;
            color:' . $color . ';
        '
    )
);

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
        local_dww_sso_status_badge($ok)
    );

    echo html_writer::end_tag('tr');
}

echo html_writer::end_tag('tbody');
echo html_writer::end_tag('table');

// -----------------------------------------------------------------
// WORDPRESS VALIDATION
// -----------------------------------------------------------------

if (!empty($wordpressurl)) {

    echo html_writer::tag(
        'h3',
        get_string('setup_wordpress_validation', 'local_dww_sso')
    );

    echo html_writer::start_tag(
        'table',
        array(
            'class' => 'generaltable'
        )
    );

    echo html_writer::start_tag('tbody');

    $validationrows = array(
        array(
            get_string('setup_wp_reachable', 'local_dww_sso'),
            !empty($wphealth['success']),
        ),
        array(
            get_string('setup_wp_plugin', 'local_dww_sso'),
            !empty($wphealth['plugin']),
        ),
        array(
            get_string('setup_wp_woocommerce', 'local_dww_sso'),
            !empty($wphealth['woocommerce']),
        ),
        array(
            get_string('setup_wp_moodleapi', 'local_dww_sso'),
            !empty($wphealth['moodle_api_configured']),
        ),
        array(
            get_string('setup_wp_sso', 'local_dww_sso'),
            !empty($wphealth['sso_secret_configured']),
        ),
    );

    foreach ($validationrows as $row) {

        $ok = !empty($row[1]);

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
            local_dww_sso_status_badge($ok)
        );

        echo html_writer::end_tag('tr');
    }

    echo html_writer::end_tag('tbody');
    echo html_writer::end_tag('table');
}

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

    $valueid = 'dww-copy-' . md5($row[0]);

    $content = html_writer::tag(
        'code',
        s($row[1]),
        array(
            'id' => $valueid,
            'style' => '
                display:inline-block;
                margin-right:10px;
            '
        )
    );

    if (strpos($row[1], 'http') === 0) {
        $content .= html_writer::tag(
            'button',
            get_string('copy', 'local_dww_sso'),
            array(
                'type' => 'button',
                'onclick' => "
                    navigator.clipboard.writeText(
                        document.getElementById('" . $valueid . "').innerText
                    );
                    this.innerText = '" . get_string('copied', 'local_dww_sso') . "';
                ",
                'style' => '
                    border:none;
                    border-radius:6px;
                    padding:6px 10px;
                    cursor:pointer;
                    background:#1976d2;
                    color:#fff;
                    font-weight:bold;
                '
            )
        );
    }

    echo html_writer::tag(
        'td',
        $content
    );

    echo html_writer::end_tag('tr');
}

echo html_writer::end_tag('tbody');
echo html_writer::end_tag('table');

// -----------------------------------------------------------------
// MOODLE WEB SERVICE
// -----------------------------------------------------------------

echo html_writer::tag(
    'h3',
    get_string('setup_webservice', 'local_dww_sso')
);

echo $OUTPUT->notification(
    get_string('setup_token_warning', 'local_dww_sso'),
    'warning'
);

echo html_writer::alist(array(
    get_string('setup_webservice_item1', 'local_dww_sso'),
    get_string('setup_webservice_item2', 'local_dww_sso'),
    get_string('setup_webservice_item3', 'local_dww_sso'),
    get_string('setup_webservice_item4', 'local_dww_sso'),
));

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
