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

// Requirements
require_once '../../../config.php';
require_once $CFG->libdir.'/gradelib.php';
require_once $CFG->dirroot.'/grade/lib.php';
require_once $CFG->dirroot.'/grade/report/scgr/lib.php';


// Parameters
$courseid = required_param('id', PARAM_INT);
$userid   = optional_param('userid', $USER->id, PARAM_INT);
$userview = optional_param('userview', 0, PARAM_INT);

// Set URL of plugin page
$PAGE->set_url(new moodle_url('/grade/report/scgr/index.php', array('id'=>$courseid)));
$PAGE->requires->js('/grade/report/scgr/js/chartjs-plugin-annotation.js', true);
$PAGE->requires->js('/grade/report/scgr/js/custom.js', false);
$PAGE->requires->css('/grade/report/scgr/js/custom.css');

    // Create a report instance
    // $report = new grade_report_scgr_overview($userid, $gpr, $context);

	// Set page moodle layout
	$PAGE->set_pagelayout('standard');
	
	// Set page header
		
		// FIX : Needs to be set dynamically
		$header = get_string('grades', 'grades') . ': Social Comparison GR';
	
	$PAGE->set_title($header);
		
		// FIX : Needs to be set dynamically
		// $PAGE->set_heading(fullname($report->user));
		$PAGE->set_heading('UniTICE 2016-2017: Social Comparison GR');
	    
	echo $OUTPUT->header();
	
	// One way of writing HTML
	echo '<h1>Course information</h1>';
	
	// Other way of writing HTML
	echo html_writer::tag('p', 'Example of text paragraph');
	
	/* Trying to pull of data of moodle database */
	$courseid = $PAGE->course->id;
	$courseid_in_db = 2;
	
	$course = $DB->get_record('course', array('id' => $courseid_in_db));
	
	echo '<p style="color:red;">Pourquoi est-ce que le $context me donne un id de cours = 1, et dans la base de données l\'id est 2</p>';
	
	// Define context
	$context = context_course::instance($courseid);
	
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
	
	echo '<hr />';
	
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
	
	echo html_writer::tag('h2', 'Tests with tabs');
	
	echo '<div class="tabs">
	<input name="tabs" type="radio" id="tab-1" checked="checked" class="input"/>
	<label for="tab-1" class="label">Orange</label>
	<div class="panel">';
		
	echo '<div style="width: 100%;">';
	$chart = new \core\chart_bar(); // Create a bar chart instance.
	$series1 = new \core\chart_series('Series 1 (Bar)', [1000, 1170, 660, 1030]);
	$series2 = new \core\chart_series('Series 2 (Line)', [400, 460, 1120, 540]);
	$series2->set_type(\core\chart_series::TYPE_LINE); // Set the series type to line chart.
	$chart->add_series($series2);
	$chart->add_series($series1);
	$chart->set_labels(['2004', '2005', '2006', '2007']);
	echo $OUTPUT->render($chart);
	echo '</div>';
		
	echo'</div>

	<input name="tabs" type="radio" id="tab-2" class="input"/>
	<label for="tab-2" class="label">Tangerine</label>
	<div class="panel">
		<h1>Tangerine</h1>
		<p>The tangerine (Citrus tangerina) is an orange-colored citrus fruit that is closely related to, or possibly a type of, mandarin orange (Citrus reticulata).</p>
		<p>The name was first used for fruit coming from Tangier, Morocco, described as a mandarin variety. Under the Tanaka classification system, Citrus tangerina is considered a separate species.</p>
	</div>

	<input name="tabs" type="radio" id="tab-3" class="input"/>
	<label for="tab-3" class="label">Clemantine</label>
	<div class="panel">
		<h1>Clemantine</h1>
		<p>A clementine (Citrus ×clementina) is a hybrid between a mandarin orange and a sweet orange, so named in 1902. The exterior is a deep orange colour with a smooth, glossy appearance. Clementines can be separated into 7 to 14 segments. Similarly to tangerines, they tend to be easy to peel.</p>
	</div>
</div>';

	echo "<canvas id='myChart' width='400' height='400'></canvas>";
	echo "<canvas id='myChart2' width='400' height='400'></canvas>";
	
	// echo $OUTPUT->notification('wa222arning bla bla bla updated', 'notifymessage');
	// echo $OUTPUT->notification('success', 'notifymessage');
	
	echo $OUTPUT->footer();