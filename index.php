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

// Include custom JS and CSS
$PAGE->requires->css('/grade/report/scgr/styles.css');
$PAGE->requires->js_call_amd('formcontrol', 'init');

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
	    
	var_dump($OUTPUT->header);
	    
	echo $OUTPUT->header();
	
	// One way of writing HTML
	echo '<h1>Course information</h1>';
	
	// Other way of writing HTML
	echo html_writer::tag('p', 'Example of text paragraph');

    // Form that allows user to choose data to be included

    echo '<div class="form-box simple">
            <h3>Simple graph generator</h3><hr />';

    echo '<form>
            <div class="form-group">
                <label for="selectModality">Modalité</label>
                <select class="form-control" id="selectModality">
                <option>inter-groupe (groupes)</option>
                <option>intra-groupe (élèves d\'un groupe)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="selectTemporality">Temporalité</label>
                <select class="form-control" id="selectTemporality">
                <option value="tempoAll">Tout (jusqu\'ici)</option>
                <option value="tempoSection">Une section particulière</option>
                <option value="tempoActivity">Une activité particulière</option>
                </select>
            </div>
            <div class="form-group">
                <label for="selectSection">Choisir une section</label>
                <select class="form-control" id="selectSection" disabled>
                <option>Section 1</option>
                <option>Section 2</option>
                <option>Section 3</option>
                </select>
            </div>
            <div class="form-group">
                <label for="selectActivity">Choisir une activité</label>
                <select class="form-control" id="selectActivity" disabled>
                <option>Activity 1</option>
                <option>Activity 2</option>
                <option>Activity 3</option>
                <option>Activity 4</option>
                <option>Activity 5</option>
                <option>Activity 6</option>
                </select>
            </div>
          </form>';

    echo '</div>';

    echo '<div class="form-box double">
                <h3>Double graph generator</h3><hr />';

    echo '<form>
                <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We\'ll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                <label for="exampleSelect1">Example select</label>
                <select class="form-control" id="exampleSelect1">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select>
                </div>
              </form>';

    echo '</div>';

    echo '<hr />';

    echo '<hr />';
	
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
	
	 
	/* $grade_item_grademax = $grading_info->items[0]->grademax;
	foreach ($users as $user) {
	    $user_final_grade = $grading_info->items[0]->grades[$user->id];
	} */
	
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