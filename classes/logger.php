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
 * Lightweight logging wrapper for DWW Moodle SSO.
 *
 * This class intentionally avoids writing custom log files directly to
 * Moodle dataroot. Moodle plugin review guidelines recommend using Moodle
 * core APIs instead of manual filesystem operations.
 *
 * @package    local_dww_sso
 * @copyright  2026 Digital Web Works
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Lightweight Moodle-compatible logger.
 */
class local_dww_sso_logger {

    /**
     * Logs an informational message for developers.
     *
     * @param string $message Log message.
     * @param array $context Optional contextual data.
     * @return void
     */
    public static function info($message, array $context = array()) {
        self::debug($message, $context, DEBUG_DEVELOPER);
    }

    /**
     * Logs a warning message.
     *
     * @param string $message Log message.
     * @param array $context Optional contextual data.
     * @return void
     */
    public static function warning($message, array $context = array()) {
        self::debug($message, $context, DEBUG_NORMAL);
    }

    /**
     * Logs an error message.
     *
     * @param string $message Log message.
     * @param array $context Optional contextual data.
     * @return void
     */
    public static function error($message, array $context = array()) {
        self::debug($message, $context, DEBUG_NORMAL);
    }

    /**
     * Sends a message to Moodle debugging output.
     *
     * @param string $message Log message.
     * @param array $context Optional contextual data.
     * @param int $debuglevel Moodle debug level.
     * @return void
     */
    private static function debug($message, array $context, $debuglevel) {
        debugging(
            self::format_message($message, $context),
            $debuglevel
        );
    }

    /**
     * Formats a log message.
     *
     * @param string $message Log message.
     * @param array $context Optional contextual data.
     * @return string
     */
    private static function format_message($message, array $context) {
        $message = clean_param((string) $message, PARAM_TEXT);

        if (!empty($context)) {
            $contextjson = json_encode(
                $context,
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            );

            if (!empty($contextjson)) {
                $message .= ' ' . $contextjson;
            }
        }

        return '[local_dww_sso] ' . $message;
    }
}