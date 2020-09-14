<?php

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . '/externallib.php');

class quizaccess_proctoring_external extends external_api
{

    public static function get_camshots_parameters()
    {
        return new external_function_parameters(
            array(
                'courseid' => new external_value(PARAM_ALPHANUM, 'camshot course id'),
                'quizid' => new external_value(PARAM_ALPHANUM, 'camshot quiz id'),
                'userid' => new external_value(PARAM_ALPHANUM, 'camshot user id')
            )
        );
    }

    public static function get_camshots($courseid, $quizid ='', $userid)
    {
        global $DB;

        $warnings = array();

        if ($quizid) {
            $camshots = $DB->get_records('quizaccess_proctoring_logs', array('courseid' => $courseid,'quizid' => $quizid,'userid' => $userid,'status'=>10001), 'id DESC');
        }else{
            $camshots = $DB->get_records('quizaccess_proctoring_logs', array('courseid' => $courseid,'userid' => $userid,'status'=>10001), 'id DESC');
        }

        $returnedcamhosts = array();

        foreach ($camshots as $camshot) {
            if ($camshot->webcampicture !== '') {
                $returnedcamhosts[] = array(
                    // 'id' => $camshot->id,
                    'courseid' => $camshot->courseid,
                    'quizid' => $camshot->quizid,
                    'userid' => $camshot->userid,
                    'webcampicture' => $camshot->webcampicture,
                    // 'status' => $camshot->status,
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
                            // 'id' => new external_value(PARAM_INT, 'camshot id'),
                            'courseid' => new external_value(PARAM_NOTAGS, 'camshot course id'),
                            'quizid' => new external_value(PARAM_NOTAGS, 'camshot quiz id'),
                            'userid' => new external_value(PARAM_NOTAGS, 'camshot user id'),
                            'webcampicture' => new external_value(PARAM_RAW, 'camshot webcam photo'),
                            // 'status' => new external_value(PARAM_NOTAGS, 'camshot status'),
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
                'courseid' => new external_value(PARAM_ALPHANUM, 'course id'),
                'screenshotid' => new external_value(PARAM_ALPHANUM, 'screenshot id'),
                'quizid' => new external_value(PARAM_ALPHANUM, 'screenshot quiz id'),
                'webcampicture' => new external_value(PARAM_RAW, 'webcam photo'),
            )
        );
    }

    public static function send_camshot($courseid, $screenshotid, $quizid, $webcampicture)
    {
        global $CFG, $DB, $USER;

        $warnings = array();
        
        $record = new stdClass();
        $record->filearea = 'picture';
        $record->component = 'quizaccess_proctoring';
        $record->filepath = '';
        $record->itemid   = 0;
        $record->license  = '';
        $record->author   = '';

        $context = context_user::instance($USER->id);
        $elname = 'repo_upload_file_proctoring';

        $fs = get_file_storage();
        $sm = get_string_manager();

        // if ($record->filepath !== '/') {
            $record->filepath = file_correct_filepath($record->filepath);
        // }

        // $record = new stdClass();
        // $record->id = $screenshotid;
        // $record->quizid = $quizid;
        // $record->userid = $USER->id;
        // $record->webcampicture = $webcampicture;
        // $record->timemodified = time();

        // $DB->update_record('quizaccess_proctoring_logs', $record);
        // $DB->insert_record('quizaccess_proctoring_logs', $record);

        

        // $url = $CFG->wwwroot/pluginfile.php/$forumcontextid/mod_forum/post/$postid/image.jpg


        $contextquiz = $DB->get_record('course_modules', array('id' => $cmid));


         // for base64 to file
         $data = $webcampicture;
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        $fileName = 'webcam-' . $USER->id . '-' . $courseid . '-quizaccess_proctoring-' . time() . '.png';
        
        // upload to moodle root for direct access
        // $path='/uploads/2020/';
        // file_put_contents($CFG->dirroot.$path.$fileName, $data);

        $record->courseid = $courseid;
        $record->filename = $fileName;
        $record->itemid = 0;
        $record->contextid = $context->id;
        $record->userid    = $USER->id;
        
        $stored_file = $fs->create_file_from_string($record, $data);

        // get the 
        $url = moodle_url::make_pluginfile_url($context->id, $record->component, $record->filearea, $record->itemid, $record->filepath, $record->filename,false);
    
        
        $record = new stdClass();
        $record->courseid = $courseid;
        $record->quizid = $quizid;
        $record->userid = $USER->id;
        $record->webcampicture = "{$url}";
        $record->status = 10001;
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