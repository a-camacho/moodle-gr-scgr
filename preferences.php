<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * SCGR preferences configuration page
 *
 * @package   gradereport_scgr
 * @copyright 2017 onwards André Camacho http://www.camacho.pt
 * @author    André Camacho
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once '../../../config.php';
require_once $CFG->libdir . '/gradelib.php';
require_once '../../lib.php';
core_php_time_limit::raise();

$courseid      = required_param('id', PARAM_INT);

$PAGE->set_url(new moodle_url('/grade/report/scgr/preferences.php', array('id'=>$courseid)));
$PAGE->set_pagelayout('admin');

/// Make sure they can even access this course

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourseid');
}

require_login($course);

$context = context_course::instance($course->id);
$systemcontext = context_system::instance();
require_capability('gradereport/grader:view', $context);            // BETA Capabilities based on grader

require('preferences_form.php');
$mform = new scgr_course_settings_form();

$settings = grade_get_settings($course->id);

$mform->set_data($settings);

print_grade_page_head($courseid, 'settings', 'scgr', get_string('pref_page_title', 'gradereport_scgr'));

// The settings could have been changed due to a notice shown in print_grade_page_head, we need to refresh them.
$settings = grade_get_settings($course->id);
$mform->set_data($settings);

echo $OUTPUT->box_start('generalbox boxaligncenter boxwidthnormal centerpara');
echo get_string('pref_explanation', 'gradereport_scgr');
echo $OUTPUT->box_end();

// If USER has admin capability, print a link to the site config page for this report
if (has_capability('moodle/site:config', $systemcontext)) {
    echo '<div id="siteconfiglink">';
    echo '<a href="'.$CFG->wwwroot.'/'.$CFG->admin.'/settings.php?section=gradereportscgr">';
    echo get_string('pref_changereportdefaults', 'gradereport_scgr');
    echo "</a><br />";
    echo '<a href="'.$CFG->wwwroot.'/grade/report/scgr/index.php?id='.$courseid .'">';
    echo get_string('pref_gotoreportpage', 'gradereport_scgr');
    echo "</a>";
    echo "</div>\n";
}

echo $OUTPUT->footer();