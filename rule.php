<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Quiz access rule: Oral / Practical Exam restriction.
 *
 * @package    quizaccess_oralexam
 * @copyright  2026 Mahmoud Salem
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if (class_exists('\mod_quiz\local\access_rule_base')) {
    if (!class_exists('quiz_access_rule_base', false)) {
        \class_alias('\mod_quiz\local\access_rule_base', 'quiz_access_rule_base');
    }
    if (!class_exists('quiz', false)) {
        \class_alias('\mod_quiz\quiz_settings', 'quiz');
    }
} else {
    require_once($CFG->dirroot . '/mod/quiz/accessrule/accessrulebase.php');
}

/**
 * A rule that designates a quiz as an oral/practical exam,
 * preventing student self-attempts while providing examiners direct grading access.
 */
class quizaccess_oralexam extends quiz_access_rule_base {

    /**
     * Factory method: returns an instance if enabled on this quiz.
     */
    public static function make(quiz $quizobj, $timenow, $canignoretimelimits) {
        if (empty($quizobj->get_quiz()->oralexamenabled)) {
            return null;
        }
        return new self($quizobj, $timenow);
    }

    /**
     * Prevent student from starting a new attempt.
     */
    public function prevent_new_attempt($numprevattempts, $lastattempt) {
        global $USER;
        $context = \context_module::instance($this->quizobj->get_cmid());

        // Teachers / graders can bypass to preview.
        if (has_capability('mod/quiz:grade', $context, $USER->id) || has_capability('quiz/oralexam:evaluate', $context, $USER->id)) {
            return false;
        }

        // Students are strictly blocked from attempting.
        return get_string('cannotattemptoral', 'quizaccess_oralexam');
    }

    /**
     * Prevent access to startattempt.php.
     */
    public function prevent_access() {
        global $USER;
        $context = \context_module::instance($this->quizobj->get_cmid());

        if (has_capability('mod/quiz:grade', $context, $USER->id) || has_capability('quiz/oralexam:evaluate', $context, $USER->id)) {
            return false;
        }

        return get_string('cannotattemptoral', 'quizaccess_oralexam');
    }

    /**
     * Display information notice on quiz view page.
     */
    public function description() {
        global $CFG, $USER;

        $context = \context_module::instance($this->quizobj->get_cmid());
        $cmid = $this->quizobj->get_cmid();
        $isgrader = has_capability('mod/quiz:grade', $context, $USER->id) || has_capability('quiz/oralexam:evaluate', $context, $USER->id);

        $html = '';
        if ($isgrader) {
            $evalurl = new \moodle_url('/mod/quiz/report.php', ['id' => $cmid, 'mode' => 'oralexam']);
            $html .= '<div class="alert alert-info shadow-sm p-3 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-3" style="border-left: 5px solid #0284c7 !important; border-radius: 10px;">';
            $html .= '  <div class="d-flex align-items-center">';
            $html .= '    <i class="fa fa-microphone fa-2x mr-3 text-primary"></i>';
            $html .= '    <div>';
            $html .= '      <h5 class="mb-1 font-weight-bold">' . get_string('oralexam_grader_title', 'quizaccess_oralexam') . '</h5>';
            $html .= '      <p class="mb-0 text-muted">' . get_string('oralexam_grader_desc', 'quizaccess_oralexam') . '</p>';
            $html .= '    </div>';
            $html .= '  </div>';
            $html .= '  <div>';
            $html .= '    <a href="' . $evalurl->out(false) . '" class="btn btn-primary btn-lg shadow-sm font-weight-bold">';
            $html .= '      <i class="fa fa-pencil-square-o mr-1"></i> ' . get_string('openoralexam', 'quizaccess_oralexam');
            $html .= '    </a>';
            $html .= '  </div>';
            $html .= '</div>';
        } else {
            $html .= '<div class="alert alert-warning shadow-sm p-3 mb-4 d-flex align-items-center" style="border-left: 5px solid #f59e0b !important; border-radius: 10px;">';
            $html .= '  <i class="fa fa-info-circle fa-2x mr-3 text-warning"></i>';
            $html .= '  <div>';
            $html .= '    <h5 class="mb-1 font-weight-bold text-dark">' . get_string('oralexam_student_title', 'quizaccess_oralexam') . '</h5>';
            $html .= '    <p class="mb-0 text-muted">' . get_string('oralexam_student_desc', 'quizaccess_oralexam') . '</p>';
            $html .= '  </div>';
            $html .= '</div>';
        }

        return $html;
    }

    /**
     * Add settings to the quiz form.
     */
    public static function add_settings_form_fields(mod_quiz_mod_form $quizform, MoodleQuickForm $mform) {
        global $DB;

        $mform->addElement('header', 'oralexamheader', get_string('pluginname', 'quizaccess_oralexam'));

        $mform->addElement('selectyesno', 'oralexamenabled', get_string('oralexamenabled', 'quizaccess_oralexam'));
        $mform->setDefault('oralexamenabled', 0);
        $mform->addHelpButton('oralexamenabled', 'oralexamenabled', 'quizaccess_oralexam');

        // Check if this quiz already has attempts / evaluations recorded.
        $current = method_exists($quizform, 'get_current') ? $quizform->get_current() : null;
        $quizid = ($current && !empty($current->id)) ? (int)$current->id : 0;

        if ($quizid > 0) {
            $hasattempts = $DB->record_exists('quiz_attempts', ['quiz' => $quizid]);
            $isoral = $DB->record_exists('quizaccess_oralexam', ['quizid' => $quizid, 'oralexamenabled' => 1]);

            if ($hasattempts && $isoral) {
                // Permanently freeze the setting once evaluations have started.
                $mform->freeze('oralexamenabled');
                $mform->addElement('static', 'oralexam_locked_info', '',
                    '<div class="alert alert-danger py-2 px-3 mt-2 mb-0 d-inline-flex align-items-center" style="border-radius: 6px;">' .
                    '<i class="fa fa-lock fa-lg mr-2"></i> <strong>' . get_string('locked_has_evaluations', 'quizaccess_oralexam') . '</strong>' .
                    '</div>'
                );
            }
        }
    }

    /**
     * Save settings to DB.
     */
    public static function save_settings($quiz) {
        global $DB;

        if (empty($quiz->id)) {
            return;
        }

        // Strict safeguard: If oral evaluations/attempts exist on this quiz, never allow reverting to 0!
        $hasattempts = $DB->record_exists('quiz_attempts', ['quiz' => $quiz->id]);
        $wasoral = $DB->record_exists('quizaccess_oralexam', ['quizid' => $quiz->id, 'oralexamenabled' => 1]);

        if ($hasattempts && $wasoral) {
            // Force oral exam mode to stay locked!
            $quiz->oralexamenabled = 1;
        }

        if (empty($quiz->oralexamenabled)) {
            $DB->delete_records('quizaccess_oralexam', ['quizid' => $quiz->id]);
        } else {
            if (!$DB->record_exists('quizaccess_oralexam', ['quizid' => $quiz->id])) {
                $rec = new \stdClass();
                $rec->quizid = $quiz->id;
                $rec->oralexamenabled = 1;
                $DB->insert_record('quizaccess_oralexam', $rec);
            } else {
                $rec = $DB->get_record('quizaccess_oralexam', ['quizid' => $quiz->id]);
                $rec->oralexamenabled = 1;
                $DB->update_record('quizaccess_oralexam', $rec);
            }
        }
    }

    /**
     * Delete settings when quiz is deleted.
     */
    public static function delete_settings($quiz) {
        global $DB;
        $DB->delete_records('quizaccess_oralexam', ['quizid' => $quiz->id]);
    }

    /**
     * Return SQL snippet to join rule settings.
     */
    public static function get_settings_sql($quizid) {
        return [
            'oralexam.oralexamenabled AS oralexamenabled',
            'LEFT JOIN {quizaccess_oralexam} oralexam ON oralexam.quizid = quiz.id',
            [],
        ];
    }
}
