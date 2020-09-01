<?php

defined('MOODLE_INTERNAL') || die();

$observers = array(
    array(
        'eventname' => '\mod_quiz\event\attempt_started',
        'callback' => 'quizaccess_proctoring\proctoring_observer::handle_quiz_attempt_started',
    ),
    array(
        'eventname' => '\mod_quiz\event\quiz_attempt_submitted',
        'callback' => 'quizaccess_proctoring\proctoring_observer::handle_quiz_attempt_submitted',
    ),
    array(
        'eventname' => 'quizaccess_proctoring\take_screenshot',
        'callback' => 'quizaccess_proctoring\proctoring_observer::take_screenshot',
    ),
);
