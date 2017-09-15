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

// Parameters
$courseid = required_param('id', PARAM_INT);
$userid   = optional_param('userid', $USER->id, PARAM_INT);
$userview = optional_param('userview', 0, PARAM_INT);

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

// Check if plugin is activated for this course
$activated_on = explode(",", $config->course_activation_choice);
if ( !in_array( $courseid, $activated_on , false )  ) {

    // echo $OUTPUT->notification('The SCGR plugin is not activated for this course. Please check the settings page.', 'notifymessage');

    echo html_writer::tag('h3', get_string('page_not_active_on_this_course', 'gradereport_scgr') );
    echo html_writer::tag('p', get_string('page_not_active_on_this_course_description', 'gradereport_scgr') );

} else {

    /* ######################  SIMPLE GENERATION FORM  ###################### */

    // Initialize sections query and activities arrays
    $sections = getSectionsFromCourseID($courseid);                         // Sections
    $activities = getActivitiesFromCourseID($courseid, $categoryid);        // Activites
    $groups = getGroups($courseid);

    // Form that allows user to choose data to be included
    echo '<div class="form-box simple">';

    // Include title and subtitle
    echo html_writer::tag('h3', get_string('form_simple_title', 'gradereport_scgr') );
    echo html_writer::tag('p', get_string('form_simple_subtitle', 'gradereport_scgr') );
    echo html_writer::tag('p', get_string('form_simple_subtitle2', 'gradereport_scgr') );
    echo html_writer::tag('hr', '');

    // Include the form
    require_once('forms/form_simple_html.php');

    // Instantiate simplehtml_form
    $mform = new simplehtml_form( $forms_action_url, array( $sections, $activities, $groups ) );

    // Form processing and displaying is done here
    if ($mform->is_cancelled()) {
        //Handle form cancel operation, if cancel button is present on form


        /* ######################  CHART RESULT  ###################### */


    } else if ($fromform = $mform->get_data()) {

        $data = $mform->get_data();

        echo html_writer::tag('p', 'Whatever you choose up there, the form uses INTER + ACTIVITY.');

        echo '<hr />';

        printGraph( $courseid, 'inter', 'all', 0,
            $data->group, $data->activity );

        echo '<hr />';


        /* ######################  END RESULT  ###################### */


    } else {
        // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
        // or on the first display of the form.

        //Set default data (if any)
        $toform = '';
        $mform->set_data($toform);
        //displays the form
        $mform->display();
    }

    echo '</div>';

    /* ######################  END SIMPLE GENERATION FORM  ###################### */

}

echo $OUTPUT->footer();