<?php


defined('MOODLE_INTERNAL') || die();

/**
 * Serve the files.
 *
 * @param stdClass $course the course object
 * @param stdClass $cm the course module object
 * @param \context $context the context
 * @param string $filearea the name of the file area
 * @param array $args extra arguments (itemid, path)
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 * @return bool false if the file not found, just send the file otherwise and do not return anything
 */
function quizaccess_proctoring_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    if ($context->contextlevel != CONTEXT_MODULE) {
        return false;
    }

    if ($filearea !== 'filemanager_proctoringconfigfile') {
        return false;
    }

    require_login($course, true, $cm);
    if (!has_capability('quizaccess/proctoring:manage_filemanager_proctoringconfigfile', $context)) {
        return false;
    }

    $itemid = array_shift($args);
    $filename = array_pop($args);

    if (!$args) {
        $filepath = '/';
    } else {
        $filepath = '/' .implode('/', $args) . '/';
    }

    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'quizaccess_proctoring', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        return false;
    }

    send_stored_file($file, 0, 0, $forcedownload, $options);
}