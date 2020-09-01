<?php

require_once('../../../../config.php');
require_once($CFG->libdir . '/adminlib.php');

$action = optional_param('action', 'view', PARAM_ALPHANUMEXT);

$PAGE->set_context(context_system::instance());

$manager = new \quizaccess_proctoring\template_controller();
$manager->execute($action);
