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
		 
	$records = $DB->get_records_sql($sql);
	
	echo '<ul>';
	foreach ( $records as $record ) {
		
		echo '<li>' . $record->iteminstance . ' : ' . $record->itemname . ' (id=' . $record->id . ')</li>';
		
	}
	echo '</ul>';
	
	echo '<hr />';
	
	echo html_writer::tag('h4', 'Let\'s take exercice 3 (id=5) what did students do ?');
	
	$sql = "SELECT *
          FROM unitice_grade_grades WHERE `aggregationstatus` LIKE 'used'";
		 
	$records = $DB->get_records_sql($sql);
	
	var_dump($records);
	
	// echo $OUTPUT->notification('wa222arning bla bla bla updated', 'notifymessage');
	// echo $OUTPUT->notification('success', 'notifymessage');
	
	echo $OUTPUT->footer();