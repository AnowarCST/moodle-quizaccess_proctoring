<?php

namespace quizaccess_proctoring;

use core\persistent;

defined('MOODLE_INTERNAL') || die();


class screenshot extends persistent {

    /** Table name for the persistent. */
    const TABLE = 'quizaccess_proctoring_logs';

    /**
     * Return the definition of the properties of this model.
     *
     * @return array
     */
    protected static function define_properties() {
        return [
            'courseid' => [
                'type' => PARAM_INT,
                'default' => '',
            ],
            'quizid' => [
                'type' => PARAM_INT,
                'default' => '',
            ],
            'userid' => [
                'type' => PARAM_INT,
                'default' => '',
            ],
            'webcampicture' => [
                'type' => PARAM_TEXT,
            ],
            'status' => [
                'type' => PARAM_INT,
                'default' => 0,
            ],
            'timemodified' => [
                'type' => PARAM_INT,
                'default' => 0,
            ],
        ];
    }

}
