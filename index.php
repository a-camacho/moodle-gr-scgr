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
 * The social comparison grade report
 *
 * @package   gradereport_scgr
 * @copyright 2017 onwards André Camacho http://www.camacho.pt
 * @author    André Camacho
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/* ################################################################################################################ */
/* ###############################      REQUIREMENTS AND CONTEXT        ########################################### */
/* ################################################################################################################ */

// Requirements
require_once '../../../config.php';
require_once $CFG->libdir.'/gradelib.php';
require_once $CFG->dirroot.'/grade/lib.php';
require_once $CFG->dirroot.'/grade/report/scgr/lib.php';

global $CFG;

// Parameters
$courseid = required_param('id', PARAM_INT);
$userid   = optional_param('userid', $USER->id, PARAM_INT);
$userview = optional_param('userview', 0, PARAM_INT);
$plugin_activated = false;

// Context
if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourseid');
}
require_login(null, false);
$PAGE->set_course($course);

// Set page moodle layout
$PAGE->set_pagelayout('report');

// Context
$context = context_course::instance($course->id);
require_capability('gradereport/user:view', $context);

if (empty($userid)) {
    require_capability('moodle/grade:viewall', $context);

} else {
    if (!$DB->get_record('user', array('id'=>$userid, 'deleted'=>0)) or isguestuser($userid)) {
        print_error('invaliduser');
    }
}


/* ################################################################################################################ */
/* #######################################      SECURITY        ################################################### */
/* ################################################################################################################ */

// Basic plugin activation status
if ( $CFG->scgr_plugin_enabled == '1' ) { $plugin_activated = true; }

/// Basic access checks
$access = false;
if (has_capability('moodle/grade:viewall', $context)) {
    //ok - can view all course grades
    $access = true;

} else if ($userid == $USER->id and has_capability('moodle/grade:view', $context) and $course->showgrades) {
    //ok - can view own grades
    $access = true;

} else if (has_capability('moodle/grade:viewall', context_user::instance($userid)) and $course->showgrades) {
    // ok - can view grades of this user- parent most probably
    $access = true;
}

if (!$access) {
    // no access to grades!
    print_error('nopermissiontoviewgrades', 'error',  $CFG->wwwroot.'/course/view.php?id='.$courseid);
}

/// return tracking object
$gpr = new grade_plugin_return(array('type'=>'report', 'plugin'=>'scgr', 'courseid'=>$courseid, 'userid'=>$userid));


/* ################################################################################################################ */
/* ####################################      PAGE SETTINGS        ################################################# */
/* ################################################################################################################ */


// Set URL of plugin page
$PAGE->set_url(new moodle_url('/grade/report/scgr/index.php', array('id'=>$courseid)));

// Set page header
    // FIX : Needs to be set dynamically
    $header = get_string('grades', 'grades') . ': Social Comparison GR';
$PAGE->set_title($header);

// Set page heading
    // FIX : Needs to be set dynamically
$PAGE->set_heading('UniTICE 2016-2017: Social Comparison GR');

// Include custom JS and CSS
$PAGE->requires->css('/grade/report/scgr/styles.css');
// $PAGE->requires->js_call_amd('formcontrol', 'init');

$forms_action_url = new moodle_url('/grade/report/scgr/index.php', array('id'=>$courseid));


/* ################################################################################################################ */
/* ###################################      COURSE SETTINGS        ################################################ */
/* ################################################################################################################ */

// Get course records
// $course = $DB->get_record('course', array('id' => $courseid));
// $modinfo = get_fast_modinfo($courseid);

$categoryid = $courseid;                 // Same as courseID ? In database, each course has an ID, and they are both in category 1

// Load plugin configuration
$config = get_config('grade_report_scgr');

/* ################################################################################################################ */
/* #####################################      PAGE OUTPUT        ################################################## */
/* ################################################################################################################ */

// Print header
echo $OUTPUT->header();


    // Checks if the plugin is activated (general)
    if ( $plugin_activated == true ) {

        // Create an array with courses that have the plugin activated
        $activated_on_this_course = explode(",", $CFG->scgr_course_activation_choice);

        // If plugin is not activated on this course
        if ( !in_array( $courseid, $activated_on_this_course , false ) ) {

            // Returns error message for "plugin not activated on this course"
            echo html_writer::tag('h3', get_string('page_not_active_on_this_course', 'gradereport_scgr') );
            echo html_writer::tag('p', get_string('page_not_active_on_this_course_description', 'gradereport_scgr') );

        // If the plugin is activated on this course
        } else {

            // If the user wants to generate a graph with key (beta)
            if ( isset($_GET['mode']) && $_GET['mode'] == 'direct' ) {

                // Output "direct" view
                include_once('views/view_direct.php');

            // If the user wants to generate a graph by form
            } elseif ( !isset($_GET['mode']) && isset($_GET["graph"]) ) {

                include_once('views/view_form.php');

                // If the user wants to generate a simple graph
                /* if ( $_GET["graph"] == 'simple' ) {

                    // Output "simple" view
                    include_once('views/view_simple_form.php');

                // If the user wants to generate a double graph
                } elseif ( $_GET["graph"] == 'double' ) {

                    // Output "simple" view
                    include_once('views/view_double_form.php');

                } */

            // Default behaviour (when clicking on the report page)
            } else {

                include_once('views/view_form.php');

            }

        }

    // If the plugin is not activated on this course
    } else {

        // Returns error message for "plugin not activated"
        echo html_writer::tag('h3', get_string('page_plugin_not_active', 'gradereport_scgr') );
        echo html_writer::tag('p', get_string('page_plugin_not_active_description', 'gradereport_scgr') );

    }

echo $OUTPUT->footer();