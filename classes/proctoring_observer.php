<?php

namespace quizaccess_proctoring;

defined('MOODLE_INTERNAL') || die();


class proctoring_observer {

    public static function handle_quiz_attempt_started(\mod_quiz\event\attempt_started $event) {
        global $DB;
        $DB->update_record('quizaccess_proctoring_logs', $event);
    }

    public static function handle_quiz_attempt_submitted(\mod_quiz\event\quiz_attempt_submitted $event) {
        global $DB;
        $DB->update_record('quizaccess_proctoring_logs', $event);
    }

    public static function take_screenshot(\quizaccess_proctoring\take_screensho $event) {
        global $DB;
        $record = $event->get_record_snapshot('quizaccess_proctoring_logs', $event->objectid);
        $DB->update_record('quizaccess_proctoring_logs', $record);
    }

}
