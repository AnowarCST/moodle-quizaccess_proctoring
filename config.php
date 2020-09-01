<?php

require_once(__DIR__ . '/../../../../config.php');

$CFG->cachejs = false;

$cmid = required_param('cmid', PARAM_RAW);

$config = \quizaccess_proctoring\helper::get_proctoring_config_content($cmid);
\quizaccess_proctoring\helper::send_proctoring_config_file($config);
