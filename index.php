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
$categoryid = 2;                                                        // Why hard-coded ????

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
$course = $DB->get_record('course', array('id' => $courseid));


/* ################################################################################################################ */
/* #####################################      PAGE OUTPUT        ################################################## */
/* ################################################################################################################ */


// Print header
echo $OUTPUT->header();

// Create a report instance
// $report = new grade_report_scgr_overview($userid, $gpr, $context);

    // Initialize sections query and activities arrays

    // Sections
    $sql = "SELECT * FROM unitice_course_sections";         // SQL Query
    $records = $DB->get_records_sql($sql);                  // Get records with Moodle function
    $sections_list = array();                               // Initialize sections array (empty)
    foreach ( $records as $record ) {                       // This loop populates sections array
        $sections_list[$record->id] = $record->name . ' (' . $record->id . ')';
    }

    // Activities
    $sql = "SELECT * FROM unitice_grade_items
                    WHERE courseid = " . $courseid . "
                    AND categoryid = " . $categoryid;       // SQL Query
    $records = $DB->get_records_sql($sql);                  // Get records with Moodle function
    $activities_list = array();                             // Initialize sections array (empty)
    foreach ( $records as $record ) {
        $activities_list[$record->id] = $record->itemname . ' (' . $record->id . ')';
    }

    // Form that allows user to choose data to be included
    echo '<div class="form-box simple">';

        // Include title and subtitle
        echo html_writer::tag('h3', get_string('form_simple_title', 'gradereport_scgr') );
        echo html_writer::tag('p', get_string('form_simple_subtitle', 'gradereport_scgr') );
        echo html_writer::tag('hr');

        // Include the form
        require_once('form_simple_html.php');

        // Instantiate simplehtml_form
        $mform = new simplehtml_form( $forms_action_url, array( $sections_list, $activities_list ) );

        // Form processing and displaying is done here
        if ($mform->is_cancelled()) {
            //Handle form cancel operation, if cancel button is present on form
        } else if ($fromform = $mform->get_data()) {
            //In this case you process validated data. $mform->get_data() returns data posted in form.

                $data = $mform->get_data();

                echo html_writer::tag('p', 'Modality is : ' . $data->modality);
                echo html_writer::tag('p', 'Temporality is : ' . $data->temporality);
                echo html_writer::tag('p', 'Section is : ' . $data->section);
                echo html_writer::tag('p', 'Activity is : ' . $data->activity);

        } else {
            // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
            // or on the first display of the form.

            //Set default data (if any)
            $mform->set_data($toform);
            //displays the form
            $mform->display();
        }

    echo '</div>';

    echo html_writer::tag('hr');
    echo html_writer::tag('hr');
    echo html_writer::tag('hr');

    echo html_writer::tag('hr');


/* ################################################################################################################ */
/* ######################################      OLD TESTS        ################################################### */
/* ################################################################################################################ */

/*
    // Define context
    $context = context_course::instance($courseid);
	
	echo '<p style="color:red;">Pourquoi est-ce que le $context me donne un id de cours = 1, et dans la base de données l\'id est 2</p>';

	
	// echo '<br /><br />';
	
	print_r('Course id is = ' . $courseid . ' (' . $course->id . ' in the database)</br>');
	echo ('Course name is = ' . $course->fullname . '</br>');
	echo ('Course shortname is = ' . $course->shortname . '</br>');
	
	echo '<br />';
	
	echo html_writer::tag('h2', 'Course sections');
	
	// SQL Query to know the sections of the course
	$sql = "SELECT *
          FROM unitice_course_sections";
		 
	$records = $DB->get_records_sql($sql);
	
foreach ( $records as $record ) {
    echo 'Section #' . $record->section . ' : ' . $record->name . ' (id=' . $record->id . ')';
    echo '<br />';
    // id / section / name
}
	
	echo '<br />';
	
	echo html_writer::tag('h2', 'Course information');
	
	$enrolled_users_number = count_enrolled_users($context);
	$enrolled_users = get_enrolled_users($context);
	
	echo ('Number of enrolled users = ' . $enrolled_users_number . '</br></br>');
	
	echo '<ul>';
	foreach ($enrolled_users as $enrolled_user) {
		
		echo '<li>' . $enrolled_user->firstname . ' ' . $enrolled_user->lastname . ' (' . $enrolled_user->username . ' - ' . $enrolled_user->id . ')</li>';
	
	}
	echo '</ul>';
	
	echo '<hr />';
	
	echo html_writer::tag('h4', 'Get exercices from course');
	
	echo html_writer::tag('p', 'Soit on chope les activités qu\'on veut, et on récupère les grade dans gradebook. Soit on prends le gradebook, on exporte toutes les activités qui ont une note, et on filtre ce qu\'on veut (deuxième méthode mieux) ');
	
	$courseid = $courseid_in_db;
	$categoryid = 2;
	
	$sql = "SELECT *
          FROM unitice_grade_items WHERE courseid = " . $courseid . " AND categoryid = " . $categoryid;
		 
	$exercices_records = $DB->get_records_sql($sql);
	
	echo '<ul>';
	foreach ( $exercices_records as $record ) {
		
		echo '<li>' . $record->iteminstance . ' : ' . $record->itemname . ' (id=' . $record->id . ')</li>';
		
	}
	echo '</ul>';
		
	$contextx = context_module::instance(3);
	var_dump($contextx);
	
	$varx = has_capability('mod/assign:view', $contextx, 5);
	var_dump($varx);
	
	echo '<hr />';
	
	echo html_writer::tag('h4', 'Get groups from course');
	
	$groupmode = groups_get_course_groupmode($course);
	
	switch ($groupmode) {
		case 0:
			$message = 'No groups - The course or activity has no groups';	
		case 1:
			$message = 'Separate groups - Teachers and students can normally only see information relevant to that group';	
		case 2:
			$message = 'Visible groups - Teachers and students are separated into groups but can still see all information';	
	}
	
	$yourgroups = groups_get_user_groups($courseid, 4);
	// User groups are in the first column of array (in form of array)
	$yourgroups = $yourgroups[0];
	$yourgroups = implode(', ', $yourgroups);
	
	echo '<p>Your group(s) : ' . $yourgroups . '<br />';
	echo 'Course groups mode : ' . $groupmode . '<ul><li>' . $message . '</li></ul></p>';
	
	echo '<h6>=> Groupes</h6>';
	
	$groups = groups_get_all_groups($courseid);
	
	echo '<ul>';
	foreach ( $groups as $group ) {
		
		$group_members = groups_get_members($group->id, $fields='u.*', $sort='lastname ASC');
		$group_members_items = array();
		
		foreach ( $group_members as $item ) {
			array_push($group_members_items, $item->id);
		}
		
		echo '<li>' . $group->name . ' (' . $group->id . ')';
		echo '<ul><li>' . count($group_members) . ' user(s) inside : ' . implode(', ', $group_members_items) . '</li></ul>';
		echo '</li>';
		
	}
	echo '</ul>';
	
	echo '<hr />';
	
	echo html_writer::tag('h4', 'Get grades from students ids and course module');
	echo html_writer::tag('p', 'I\'m trying to get grades for a certain "course module" = 27 (ex 5).');
	
	// We have our course module
	$course_module_id = 27;
	$users = array (3,4,5);
	$course_module = get_coursemodule_from_id('assign', $course_module_id);
	
	echo html_writer::tag('p', 'Name = ' . $course_module->name . '<br />UserIDs = ' . implode(",", $users));
	
	$grading_info = grade_get_grades($courseid, 'mod', $course_module->modname, $course_module->instance, $users);
	$grading_info = $grading_info->items[0];
	$grading_info = $grading_info->grades;
	
	$i = 0;
	foreach ( $grading_info as $item ) {
		echo 'User ' . $users[$i] . ' = ' . $item->grade . '<br />';
		$i++;		
	}
	
	echo '<hr />';
	
	 
	$grade_item_grademax = $grading_info->items[0]->grademax;
	foreach ($users as $user) {
	    $user_final_grade = $grading_info->items[0]->grades[$user->id];
	}
	
	echo html_writer::tag('h4', 'Let\'s take exercice 3 (id=5) what did students do ?');
	
	echo '<hr />';
	
	echo html_writer::tag('h5', 'Exercice 3 : ' . $exercices_records[5]->itemname . ' (id=5)');
	
	$sql = "SELECT *
          FROM unitice_grade_grades WHERE `aggregationstatus` LIKE 'used' AND `itemid` = 5";
		 
	$ex3usergrades = $DB->get_records_sql($sql);
	
	echo '<ul>';
	foreach ( $ex3usergrades as $record ) {
		echo '<li>User ' . $record->userid . ' = ' . $record->rawgrade . '/' . $record->rawgrademax . '</li>';
		// var_dump($record);
	}
	echo '</ul>';
	
	echo '<div style="max-width: 600px;">';
	
	$chart = new \core\chart_bar(); // Create a bar chart instance.
	
	// Grades arrays for users
	$users_formatted = array();
	$users_rawgrades = array(); 
	
	foreach ( $ex3usergrades as $ex3usergrade ) {
		array_push($users_formatted, 'User ' . $ex3usergrade->userid);
		array_push($users_rawgrades, $ex3usergrade->rawgrade);
	}
	
	$series1 = new \core\chart_series('Note de l\'exercice', $users_rawgrades);	
	$series2 = new \core\chart_series('Participation au forum', [90, 90, 90]);
	$series3 = new \core\chart_series('Moyenne', [ 90, 90, 90]);
	
	$series3->set_type(\core\chart_series::TYPE_LINE); // Set the series type to line chart.
	$series3->set_xaxis(0);
	$series3->set_smooth(true); // Calling set_smooth() passing true as parameter, will display smooth lines.
	
	$chart->add_series($series3);
	$chart->add_series($series2);
	$chart->add_series($series1);
	$chart->set_labels($users_formatted);

	echo $OUTPUT->render($chart);
	
	echo '</div>';
	
	echo '<hr />';
	
	echo html_writer::tag('h2', 'Charts test (using Moodle API)');
	
	echo '<div style="max-width: 600px;">';
	$chart = new \core\chart_bar(); // Create a bar chart instance.
	$series1 = new \core\chart_series('Series 1 (Bar)', [1000, 1170, 660, 1030]);
	$series2 = new \core\chart_series('Series 2 (Line)', [400, 460, 1120, 540]);
	$series2->set_type(\core\chart_series::TYPE_LINE); // Set the series type to line chart.
	$chart->add_series($series2);
	$chart->add_series($series1);
	$chart->set_labels(['2004', '2005', '2006', '2007']);
	echo $OUTPUT->render($chart);
	echo '</div>';

	echo "<canvas id='myChart' width='400' height='400'></canvas>";
	echo "<canvas id='myChart2' width='400' height='400'></canvas>";
	
	// echo $OUTPUT->notification('wa222arning bla bla bla updated', 'notifymessage');
	// echo $OUTPUT->notification('success', 'notifymessage');


    */
	
	echo $OUTPUT->footer();