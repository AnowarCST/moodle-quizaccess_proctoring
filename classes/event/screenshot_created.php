<?php

namespace quizaccess_proctoring\event;

use core\event\base;
use quizaccess_proctoring\screenshot;
use context_system;

defined('MOODLE_INTERNAL') || die();


class screenshot_created extends base
{

    public static function create_strict(screenshot $screenshot, context_system $context) : base {
        global $USER, $COURSE;
        $tid = $screenshot->get('id');

        return self::create([
            'courseid' => $COURSE->id,
            'userid' => $USER->id,
            'objectid' => $tid,
            'context' => $context,
        ]);
    }

    protected function init()
    {
        $this->data['objecttable'] = 'quizaccess_proctoring_logs';
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    public function get_url() {
        $params = [
            'id' => $this->objectid,
            'action' => 'edit',
        ];
        return new \moodle_url('/mod/quiz/accessrule/proctoring/screenshot.php', $params);
    }

    public static function get_name()
    {
        return get_string('event:screenshotcreated', 'quizaccess_proctoring');
    }

    public function get_description()
    {
        return array('db' => 'quizaccess_proctoring_logs', 'restore' => 'quizaccess_proctoring_logs');
    }

    public static function get_objectid_mapping() : array {
        return array('db' => 'quizaccess_proctoring_logs', 'restore' => 'quizaccess_proctoring_logs');
    }

    public static function get_other_mapping()
    {
        return [];
    }
}
