<?php

$string['pluginname'] = 'DWW SSO';
$string['sharedsecret'] = 'Shared SSO secret';
$string['sharedsecret_desc'] = 'Paste here the same SSO secret generated in the WordPress DWW Moodle Bridge plugin.';
$string['generalsettings'] = 'General settings';
$string['generalsettings_desc'] = 'Configure the Moodle-side companion settings required by DWW Moodle Bridge for WordPress.';
$string['ssostatus'] = 'SSO status';
$string['systemstatus'] = 'System status';
$string['pluginversion'] = 'Plugin version';
$string['moodleversion'] = 'Moodle version';
$string['sharedsecretstatus'] = 'Shared secret';
$string['configured'] = 'Configured';
$string['notconfigured'] = 'Not configured';
$string['ssoendpoint'] = 'SSO endpoint';
$string['diagnostics'] = 'Diagnostics';
$string['diagnostics_desc'] = 'Basic operational checks for the Moodle-side DWW Moodle Bridge companion plugin.';
$string['endpointmissing'] = 'Endpoint file not found or not readable';
$string['noncedirectory'] = 'Nonce directory';
$string['notwritable'] = 'Not writable';
$string['loggerstatus'] = 'Logger';
$string['available'] = 'Available';
$string['notavailable'] = 'Not available';
$string['phpversion'] = 'PHP version';
$string['check'] = 'Check';
$string['status'] = 'Status';
$string['details'] = 'Details';
$string['ok'] = 'OK';
$string['error'] = 'Error';
$string['security'] = 'Security';
$string['security_desc'] = 'Security overview for the Moodle-side SSO companion plugin.';
$string['security_sharedsecret'] = 'Shared secret strength';
$string['security_hmac'] = 'HMAC SHA-256 signature validation';
$string['security_expiration'] = 'Expiring SSO tokens';
$string['security_nonce'] = 'Nonce replay protection';
$string['security_returnurl'] = 'Safe return URL validation';
$string['security_enrolment'] = 'User, course and enrolment validation';
$string['security_enabled'] = 'Enabled';
$string['security_attention'] = 'Requires attention';
$string['warning'] = 'Warning';
$string['logs'] = 'Logs';
$string['logs_desc'] = 'Latest events recorded by the Moodle SSO companion plugin.';
$string['nologsfound'] = 'No logs found yet.';
$string['time'] = 'Time';
$string['level'] = 'Level';
$string['message'] = 'Message';
$string['setupwizard'] = 'Setup Wizard';
$string['setupwizard_desc'] = 'Initial guided configuration for connecting Moodle with DWW Moodle Bridge for WordPress/WooCommerce.';

$string['setup_step1'] = 'Step 1 — Moodle Configuration';
$string['setup_step1_item1'] = 'Install this plugin into /local/dww_sso.';
$string['setup_step1_item2'] = 'Configure a secure shared secret.';
$string['setup_step1_item3'] = 'Verify SSO endpoint availability.';

$string['setup_validation'] = 'Current validations';

$string['setup_sharedsecret'] = 'Shared secret configured';
$string['setup_login_endpoint'] = 'login.php endpoint available';
$string['setup_logs'] = 'Writable logs directory';

$string['setup_nextsteps'] = 'Next steps';
$string['setup_nextsteps_item1'] = 'Install DWW Moodle Bridge on WordPress.';
$string['setup_nextsteps_item2'] = 'Configure Moodle URL and API token.';
$string['setup_nextsteps_item3'] = 'Configure the same shared secret in WordPress.';

$string['setup_wordpress'] = 'WordPress connection information';

$string['setup_moodle_url'] = 'Public Moodle URL';
$string['setup_sso_endpoint'] = 'SSO endpoint';
$string['setup_sharedsecret_status'] = 'Shared secret status';
$string['setup_moodle_version'] = 'Moodle version';
$string['setup_php_version'] = 'PHP version';

$string['setup_wordpress_note'] = 'Use these values to complete the setup wizard on WordPress.';
$string['setup_readiness'] = 'System readiness';

$string['copy'] = 'Copy';
$string['copied'] = 'Copied';

$string['wordpressurl'] = 'WordPress URL';
$string['wordpressurl_desc'] = 'Public WordPress site URL where DWW Moodle Bridge is installed.';

$string['setup_wordpress_validation'] = 'WordPress validation';
$string['setup_wp_reachable'] = 'WordPress reachable';
$string['setup_wp_plugin'] = 'DWW Moodle Bridge plugin detected';
$string['setup_wp_woocommerce'] = 'WooCommerce active';
$string['setup_wp_moodleapi'] = 'Moodle API configured';
$string['setup_wp_sso'] = 'SSO secret configured';

$string['setup_webservice'] = 'Moodle Web Service';
$string['setup_token_warning'] = 'Tokens created from other Moodle services may cause authentication or access control errors.';
$string['setup_webservice_item1'] = 'The "DWW Moodle Bridge Service" service is created automatically during plugin installation or upgrade.';
$string['setup_webservice_item2'] = 'Before generating the token, add an authorised user to the service.';
$string['setup_webservice_item3'] = 'Generate the token using only the "DWW Moodle Bridge Service".';
$string['setup_webservice_item4'] = 'Paste the generated token into the WordPress plugin settings.';

$string['returntosite'] = 'Return to site';
$string['errorinvalidlink'] = 'Invalid link';
$string['errorinvalidlink_desc'] = 'The access link does not have a valid format.';
$string['errorinvalidrequest'] = 'Invalid request';
$string['errorinvalidaccesslink'] = 'The access link is not valid.';
$string['errorssonotavailable'] = 'SSO unavailable';
$string['errorssonotavailable_desc'] = 'Automatic access is not configured correctly.';
$string['erroraccessinvalid'] = 'Invalid access';
$string['errorsecurityvalidationfailed'] = 'The security validation for this access has failed.';
$string['errordatainvalid'] = 'Invalid data';
$string['erroraccessdatainvalid'] = 'The access information could not be validated.';
$string['erroraccessexpired'] = 'Access expired';
$string['erroraccessexpired_desc'] = 'The access link has expired. Please access again from your course area.';
$string['errordataincomplete'] = 'Incomplete data';
$string['errordataincomplete_desc'] = 'Automatic access could not be completed.';
$string['erroraccessusedorinvalid'] = 'The access link is invalid or can no longer be used.';
$string['erroraccessused'] = 'Access already used';
$string['erroraccessused_desc'] = 'This access link has already been used. Please access again from your course area.';
$string['erroruserunavailable'] = 'User unavailable';
$string['erroruserunavailable_desc'] = 'Your Moodle account is currently unavailable.';
$string['errorcourseunavailable'] = 'Course unavailable';
$string['errorcourseunavailable_desc'] = 'The requested course is no longer available.';
$string['erroraccessunavailable'] = 'Access unavailable';
$string['erroraccessunavailable_desc'] = 'You do not have an active enrolment for this course.';

$string['noncestorage'] = 'Nonce storage';
$string['noncestorage_config'] = 'Nonces are stored using Moodle configuration APIs.';

$string['privacy:metadata'] = 'The DWW Moodle SSO plugin does not store personal data in its own database tables. It only processes temporary SSO tokens to authenticate existing Moodle users.';

$string['logs_moodle_debugging_notice'] = 'DWW Moodle SSO uses Moodle debugging facilities and does not write custom log files.';

$string['logs_no_custom_files'] = 'Operational logs are not stored in plugin-managed files. For troubleshooting, enable Moodle debugging or review the web server and Moodle diagnostic information.';

$string['local_dww_sso_service'] = 'DWW Moodle Bridge Service';