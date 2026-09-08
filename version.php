<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Version details for quizaccess_oralexam.
 *
 * @package    quizaccess_oralexam
 * @copyright  2026 Mahmoud Salem
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'quizaccess_oralexam';
$plugin->version   = 2026090801;
$plugin->requires  = 2022041900;
$plugin->maturity  = MATURITY_STABLE;
$plugin->release   = 'v1.0.1';
$plugin->dependencies = [
    'mod_quiz'      => ANY_VERSION,
    'quiz_oralexam' => 2026090800,
];
