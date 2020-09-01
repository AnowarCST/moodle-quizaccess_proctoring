<?php

namespace quizaccess_proctoring;

use core\notification;

defined('MOODLE_INTERNAL') || die();

class template_controller {

    /**
     * Execute required action.
     *
     * @param string $action Action to execute.
     */
    public function execute($action) {

        $this->set_external_page();

        switch($action) {
            case self::ACTION_ADD:
            case self::ACTION_EDIT:
                $this->edit($action, optional_param('id', null, PARAM_INT));
                break;

            case self::ACTION_DELETE:
                $this->delete(required_param('id', PARAM_INT));
                break;

            case self::ACTION_HIDE:
                $this->hide(required_param('id', PARAM_INT));
                break;

            case self::ACTION_SHOW:
                $this->show(required_param('id', PARAM_INT));
                break;

            case self::ACTION_VIEW:
            default:
                $this->view();
                break;
        }
    }

    /**
     * Set external page for the manager.
     */
    protected function set_external_page() {
        admin_externalpage_setup('quizaccess_proctoring/template');
    }

    /**
     * Execute view action.
     */
    protected function view() {
        global $PAGE;

//        $this->header($this->get_view_heading());
//        $this->print_add_button();
//        $this->display_all_records();

        // JS for Template management.
        $PAGE->requires->js_call_amd('quizaccess_proctoring/proctoring', 'init');

//        $this->footer();
    }

}