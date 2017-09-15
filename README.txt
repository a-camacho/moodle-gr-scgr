A social comparison gradebook interface for students and teachers, showing the student's grades (or the group grades)
in comparison with the others students (or groups) grades.

            /*

            $groupid = $data->group;
            $course_item_id = 3;                    // Get item ID (activity 3)
            $course_module_id = 27;                 // Get module ID
            $course_module = get_coursemodule_from_id('assign', $course_module_id);

            // Get users from choosen group
            echo '<h5>Users</h5>';
            $users = getUsersFromGroup($groupid);           // Get users from this group
            $usernames = getUsernamesFromGroup($groupid);   // Get usernames from this group
            var_dump($usernames);

            // Get grades from user array and item_id
            echo '<br /><br /><h5>Grades</h5>';
            $grades = getGrades($users, $courseid, $course_item_id);
            var_dump($grades);

            echo html_writer::tag('hr', ' ');
            echo html_writer::tag('h3', 'Graph');

            $chart = new \core\chart_bar(); // Create a bar chart instance.
            $series1 = new \core\chart_series('Note de l\'exercice', $grades);

            $chart->add_series($series1);
            $chart->set_labels($usernames);

            echo $OUTPUT->render_chart($chart);

            */

/* ################################################################################################################ */
/* ######################################      OLD TESTS        ################################################### */
/* ################################################################################################################ */

/*

                    // Grades arrays for users

                    $users_formatted = array();
                    $users_rawgrades = array();

                    $sql = "SELECT *
                    FROM unitice_grade_grades WHERE `aggregationstatus`
                    LIKE 'used' AND `itemid` = 5";

                    $usergrades = $DB->get_records_sql($sql);

                    foreach ($usergrades as $usergrade) {

                        // echo 'user id ' . $usergrade->userid . ' has grade ' . $usergrade->rawgrade . '<br />';

                        array_push($users_formatted, 'User ' . $usergrade->userid);
                        array_push($users_rawgrades, $usergrade->rawgrade);
                    }

                    var_dump($users_rawgrades);



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
