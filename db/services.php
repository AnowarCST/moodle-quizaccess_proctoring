<?php

defined('MOODLE_INTERNAL') || die;

$functions = array(
    'quizaccess_proctoring_send_camshot' => array(
        'classname' => 'quizaccess_proctoring_external',
        'methodname' => 'send_camshot',
        'description' => 'Send a camera snapshot on the given session.',
        'type' => 'write',
        'ajax'        => true, 
        'capabilities' => '\quizaccess_proctoring:sendcamshot',
    ),
    'quizaccess_proctoring_get_camshots' => array(
        'classname' => 'quizaccess_proctoring_external',
        'methodname' => 'get_camshots',
        'description' => 'Get the list of camera snapshots in the given session.',
        'type' => 'read',
        'ajax'        => true, 
        'capabilities' => '\quizaccess_proctoring:getcamshots',
    ),
);

$services = array(
    'Moodle Proctoring Web Service' => array(
        'functions' => array('quizaccess_proctoring_get_camshots', 'quizaccess_proctoring_send_camshot'),
        'shortname' => 'Proctoring',
        'restrictedusers' => 0,
        'enabled' => 1,
        'ajax' => true,
        'downloadfiles' => 1,
        'uploadfiles' => 1,
    )
);

