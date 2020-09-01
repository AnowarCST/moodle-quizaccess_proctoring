<?php

namespace quizaccess_proctoring;

use moodle_url;

defined('MOODLE_INTERNAL') || die();


class link_generator {

    /**
     * Get a link to force the download of the file over https or proctorings protocols.
     *
     * @param string $cmid Course module ID.
     * @param bool $proctoring Whether to use a proctoring:// scheme or fall back to http:// scheme.
     * @param bool $secure Whether to use HTTPS or HTTP protocol.
     * @return string A URL.
     */
    public static function get_link(string $cmid, bool $proctoring = false, bool $secure = true) : string {
        // Check if course module exists.
        get_coursemodule_from_id('quiz', $cmid, 0, false, MUST_EXIST);

        $url = new moodle_url('/mod/quiz/accessrule/proctoring/config.php?cmid=' . $cmid);
        if ($proctoring) {
            $secure ? $url->set_scheme('proctorings') : $url->set_scheme('proctoring');
        } else {
            $secure ? $url->set_scheme('https') : $url->set_scheme('http');
        }
        return $url->out();
    }
}
