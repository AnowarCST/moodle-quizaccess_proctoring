<?php

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . '/externallib.php');

class quizaccess_proctoring_external extends external_api
{

    public static function get_camshots_parameters()
    {
        return new external_function_parameters(
            array(
                'quizid' => new external_value(PARAM_ALPHANUM, 'camshot course id')
            )
        );
    }

    public static function get_camshots($quizid)
    {
        global $DB;

        $warnings = array();

        $camshots = $DB->get_records('quizaccess_proctoring_logs', array('quizid' => $quizid), 'id DESC');

        $returnedcamhosts = array();

        foreach ($camshots as $camshot) {
            if ($camshot->webcampicture !== '') {
                $returnedcamhosts[] = array(
                    'id' => $camshot->id,
                    'courseid' => $camshot->courseid,
                    'quizid' => $camshot->quizid,
                    'userid' => $camshot->userid,
                    'webcampicture' => $camshot->webcampicture,
                    'status' => $camshot->status,
                    'timemodified' => $camshot->timemodified,
                );

            }
        }

        $result = array();
        $result['camshots'] = $returnedcamhosts;
        $result['warnings'] = $warnings;
        return $result;
    }

    public static function get_camshots_returns()
    {
        return new external_single_structure(
            array(
                'camshots' => new external_multiple_structure(
                    new external_single_structure(
                        array(
                            'id' => new external_value(PARAM_INT, 'camshot id'),
                            'courseid' => new external_value(PARAM_NOTAGS, 'camshot course id'),
                            'quizid' => new external_value(PARAM_NOTAGS, 'camshot quiz id'),
                            'userid' => new external_value(PARAM_NOTAGS, 'camshot user id'),
                            'webcampicture' => new external_value(PARAM_RAW, 'camshot webcam photo'),
                            'status' => new external_value(PARAM_NOTAGS, 'camshot status'),
                            'timemodified' => new external_value(PARAM_NOTAGS, 'camshot time modified'),
                        )
                    ),
                    'list of camshots'
                ),
                'warnings' => new external_warnings()
            )
        );
    }


    public static function send_camshot_parameters()
    {
        return new external_function_parameters(
            array(
                'screenshotid' => new external_value(PARAM_ALPHANUM, 'screenshot id'),
                'quizid' => new external_value(PARAM_ALPHANUM, 'screenshot quiz id'),
                'webcampicture' => new external_value(PARAM_RAW, 'webcam photo'),
            )
        );
    }

    public static function send_camshot($screenshotid, $quizid, $webcampicture)
    {
        global $DB, $USER, $COURSE;

        $warnings = array();

        // $record = new stdClass();
        // $record->id = $screenshotid;
        // $record->quizid = $quizid;
        // $record->userid = $USER->id;
        // $record->webcampicture = $webcampicture;
        // $record->timemodified = time();

        // $DB->update_record('quizaccess_proctoring_logs', $record);
        // $DB->insert_record('quizaccess_proctoring_logs', $record);



        // global $DB, $COURSE, $USER;

        $contextquiz = $DB->get_record('course_modules', array('id' => $cmid));

        $record = new stdClass();
        $record->courseid = $COURSE->id;
        $record->quizid = $quizid;
        $record->userid = $USER->id;
        $record->webcampicture = $webcampicture;
        $record->status = 1;
        $record->timemodified = time();
        $screenshotid = $DB->insert_record('quizaccess_proctoring_logs', $record, true);




        $result = array();
        $result['screenshotid'] = $screenshotid;
        $result['warnings'] = $warnings;
        return $result;
    }


    public static function send_camshot_returns()
    {
        return new external_single_structure(
            array(
                'screenshotid' => new external_value(PARAM_INT, 'screenshot sent id'),
                'warnings' => new external_warnings()
            )
        );
    }

}