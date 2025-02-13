<?php
class AI_Logger {
    public static function log($message) {
        $log_file = plugin_dir_path(__FILE__) . '../logs/ai-writer.log';
        $log_message = date('Y-m-d H:i:s') . " - " . $message . "\n";
        file_put_contents($log_file, $log_message, FILE_APPEND);
    }
}
