<?php

namespace quizaccess_proctoring\event;

use context_system;
use core\event\base;
use quizaccess_proctoring\screenshot;

defined('MOODLE_INTERNAL') || die();


class take_screenshot extends base
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
        return get_string('event:takescreenshot', 'quizaccess_proctoring');
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
