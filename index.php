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
$activated_on = explode(",", $CFG->scgr_course_activation_choice);

if ( !in_array( $courseid, $activated_on , false ) || $CFG->scgr_plugin_disable == '1' ) {

    echo html_writer::tag('h3', get_string('page_not_active_on_this_course', 'gradereport_scgr') );
    echo html_writer::tag('p', get_string('page_not_active_on_this_course_description', 'gradereport_scgr') );

// If plugin is activated for this course
} else {

    // Get user role to show the defined graphs
    if ( current(get_user_roles($context, $USER->id))->shortname == 'student' ) {
        $role = 'student';

        if ( isset($_GET['view']) ) {
            $view = $_GET['view'];
        } else {
            $view = 'default';
        }

        include_once('views/student.php');

    } elseif ( current(get_user_roles($context, $USER->id))->shortname == 'teacher' ) {
        $role = 'teacher';

        if ( isset($_GET['view']) ) {
            $view = $_GET['view'];
        } else {
            $view = 'default';
        }

        include_once('views/teacher.php');

    } elseif ( current(get_user_roles($context, $USER->id))->shortname == 'editingteacher' ) {
        $role = 'editingteacher';
        $view = 'default';

        include_once('views/editingteacher.php');

    } else {

        echo 'error : user role error';

    }

    /*
    if ( isset($_GET['mode']) && $_GET['mode'] == 'direct' ) {

        include_once('views/view_direct.php');

    } elseif ( !isset($_GET['mode']) && isset($_GET["graph"]) ) {

        if ( $_GET["graph"] == 'simple' ) {

            include_once('views/view_simple_form.php');

        } elseif ( $_GET["graph"] == 'double' ) {

            include_once('views/view_double_form.php');

        }

    } elseif ( isset($_GET['mode']) && $_GET['mode'] == 'test' ) {

        /*

        echo '<div style="border: 2px solid #d1d1d1; padding: 15px; margin-bottom: 15px;">';
        echo '<h2>Graph #2 : STU - Us vs Them</h2>';
        echo '<p>L\'étudiant peut voir une visualisation comparant les résultats des différents groupes à travers
                    différentes activités.</p>';
        $chart2 = new \core\chart_line();
        $chart2->set_title('Graph #2 : STU - Us vs Them');
        $chart2->set_smooth(true); // Calling set_smooth() passing true as parameter, will display smooth lines.
        $CFG->chart_colorset = ['#001f3f', '#11ad55', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6'];
        $seriesA = new core\chart_series('Groupe A', [98, 76, 69, 85, 80, 74, 86, 0, 0, 0]);
        $seriesB = new core\chart_series('Groupe B', [90, 79, 69, 80, 83, 70, 88, 0, 0, 0]);
        $seriesC = new core\chart_series('Groupe C', [62, 87, 68, 90, 87, 73, 81, 0, 0, 0]);
        $seriesD = new core\chart_series('Mon groupe', [73, 62, 63, 92, 78, 79, 82, 0, 0, 0]);
        $series2->set_type(\core\chart_series::TYPE_LINE); // Set the series type to line chart.
        $chart2->add_series($seriesD);
        $chart2->add_series($seriesA);
        $chart2->add_series($seriesB);
        $chart2->add_series($seriesC);
        $chart2->set_labels(['act1', 'act2', 'act3', 'act4', 'act5', 'act6', 'act7', 'act8', 'act9', 'act10']);
        echo $OUTPUT->render($chart2);
        echo '</div><div style="border: 2px solid #d1d1d1; padding: 15px; margin-bottom: 15px;">';
        echo '<h2>Graph #3 : TUT - Progression</h2>';
        echo '<p>Le tuteur peut voir la progression de ses apprenants (leur réussite sur différentes activités au choix)</p>';
        $chart2 = new \core\chart_line();
        $chart2->set_title('Graph #3 : TUT - Group students progression');
        $chart2->set_smooth(true); // Calling set_smooth() passing true as parameter, will display smooth lines.
        $CFG->chart_colorset = ['#001f3f', '#11ad55', '#d6d6d6', '#a0a0a0', '#b27b7b', '#7bb28a', '#7b86b2', '#ad7bb2', '#b27b9a'];
        $series1 = new core\chart_series('User1', [98, 76, 69, 85, 80, 74, 86, 0, 0, 0]);
        $series2 = new core\chart_series('User2', [90, 79, 69, 80, 83, 70, 88, 0, 0, 0]);
        $series3 = new core\chart_series('User3', [62, 87, 68, 90, 87, 73, 81, 0, 0, 0]);
        $series4 = new core\chart_series('User4', [73, 62, 63, 92, 78, 79, 82, 0, 0, 0]);
        $series5 = new core\chart_series('User5', [78, 72, 76, 72, 68, 59, 62, 0, 0, 0]);
        $series6 = new core\chart_series('User6', [88, 66, 59, 75, 70, 64, 76, 0, 0, 0]);
        $series7 = new core\chart_series('User7', [80, 69, 59, 70, 73, 60, 78, 0, 0, 0]);
        $series8 = new core\chart_series('User8', [52, 77, 58, 80, 77, 63, 71, 0, 0, 0]);
        $series9 = new core\chart_series('User9', [63, 52, 53, 82, 68, 69, 72, 0, 0, 0]);
        $series10 = new core\chart_series('User10', [68, 62, 66, 62, 58, 49, 72, 0, 0, 0]);
        $series2->set_type(\core\chart_series::TYPE_LINE); // Set the series type to line chart.
        $chart2->add_series($series1);
        $chart2->add_series($series2);
        $chart2->add_series($series3);
        $chart2->add_series($series4);
        $chart2->add_series($series5);
        $chart2->add_series($series6);
        $chart2->add_series($series7);
        $chart2->add_series($series8);
        $chart2->add_series($series9);
        $chart2->add_series($series10);
        $chart2->set_labels(['act1', 'act2', 'act3', 'act4', 'act5', 'act6', 'act7', 'act8', 'act9', 'act10']);
        echo $OUTPUT->render($chart2);
        echo '</div><div style="border: 2px solid #d1d1d1; padding: 15px; margin-bottom: 15px;">';
        echo '<h2>Graph #4 : TUT - Comparison</h2>';
        echo '<p>Le tuteur peut comparer la réussite sur différentes activités (au choix) pour chaque apprenant de son groupe</p>';
        $chart4 = new core\chart_bar();
        $chart4->set_title('Graph #4 : TUT - Comparison');
        $CFG->chart_colorset = ['#001f3f', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#11ad55'];
        $series1 = new core\chart_series('Act1', [98, 76, 69, 85, 80, 74, 86, 0, 0, 0]);
        $series2 = new core\chart_series('Act2', [90, 79, 69, 80, 83, 70, 88, 0, 0, 0]);
        $series3 = new core\chart_series('Act3', [62, 87, 68, 90, 87, 73, 81, 0, 0, 0]);
        $series4 = new core\chart_series('Act4', [73, 62, 63, 92, 78, 79, 82, 0, 0, 0]);
        $series5 = new core\chart_series('Act5', [98, 76, 69, 85, 80, 74, 86, 0, 0, 0]);
        $series6 = new core\chart_series('Act6', [90, 79, 69, 80, 83, 70, 88, 0, 0, 0]);
        $series7 = new core\chart_series('Moyenne', [85, 79, 67, 83, 73, 80, 68, 0, 0, 0]);
        $chart4->add_series($series1);
        $chart4->add_series($series2);
        $chart4->add_series($series3);
        $chart4->add_series($series4);
        $chart4->add_series($series5);
        $chart4->add_series($series6);
        $chart4->add_series($series7);
        $chart4->set_labels(['user1', 'user2', 'user3', 'user4', 'user5', 'user6', 'user7', 'user8', 'user9', 'user10']);
        echo $OUTPUT->render($chart4);

    } else {

        include_once('views/view_simple_form.php');

    } */

}

echo $OUTPUT->footer();