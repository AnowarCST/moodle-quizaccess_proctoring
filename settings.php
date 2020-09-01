<?php

defined('MOODLE_INTERNAL') || die();

// https://docs.moodle.org/dev/Admin_settings

global $ADMIN;

if ($hassiteconfig) {
    $settings->add(new admin_setting_configcheckbox('quizaccess_proctoring/autoreconfigureproctoring',
        get_string('setting:autoreconfigureproctoring', 'quizaccess_proctoring'),
        get_string('setting:autoreconfigureproctoring_desc', 'quizaccess_proctoring'),
        '1'));
}
