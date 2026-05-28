<?php

defined('MOODLE_INTERNAL') || die();

class local_dww_sso_logger {

    public static function write($level, $message, $context = array()) {

        global $CFG;

        $dir = $CFG->dataroot . '/dww_sso/logs';

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $file = $dir . '/dww_sso.log';

        $entry = array(
            'time'    => date('Y-m-d H:i:s'),
            'level'   => strtoupper($level),
            'message' => $message,
            'context' => $context,
        );

        file_put_contents(
            $file,
            json_encode($entry, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL,
            FILE_APPEND
        );
    }

    public static function info($message, $context = array()) {
        self::write('info', $message, $context);
    }

    public static function warning($message, $context = array()) {
        self::write('warning', $message, $context);
    }

    public static function error($message, $context = array()) {
        self::write('error', $message, $context);
    }

}
