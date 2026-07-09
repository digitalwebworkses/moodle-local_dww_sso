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
 * Privacy API implementation for DWW Moodle SSO.
 *
 * @package    local_dww_sso
 * @copyright  2026 Digital Web Works
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_dww_sso\privacy;

defined('MOODLE_INTERNAL') || die();

use core_privacy\local\metadata\null_provider;

/**
 * Privacy provider for DWW Moodle SSO.
 *
 * This plugin does not store personal data in its own database tables.
 *
 * During the administrator setup wizard the plugin performs an optional
 * HTTP GET request to the companion DWW Moodle Bridge plugin running on
 * WordPress in order to verify the integration.
 *
 * This request does not transmit any personal data or user information.
 */
class provider implements null_provider {

    /**
     * Returns a reason why this plugin does not store personal data.
     *
     * @return string
     */
    public static function get_reason() {
        return 'privacy:metadata';
    }
}