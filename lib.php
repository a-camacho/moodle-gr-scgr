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
function grade_report_scgr_settings_definition(&$mform) {
    global $CFG;

    echo '<br /><br /><br />';

    $options = array('a', 'b', 'c');
    $mform->addElement('select', 'scgr_test', 'bla bla', $options);
    // $mform->addHelpButton('report_user_showrank', 'showrank', 'grades');

}

/*
 * printTheOptions
 *
 * prints parameters given in form and analyzed for graph generation
 *
 * @formtype (string) simple | double
 * @courseid (id) id of course
 * @modality (string) inter | intra
 * @temporality (string) #####################      (optional)
 * @section (id) ####################               (optional)
 * @groupid (id) id of user group                   (optional)
 * @activity1 (id) id of first activity
 * @activity2 (id) id of second activity            (optional)
 * @return (html)
 */

function printTheOptions( $formtype, $courseid, $modality = NULL, $temporality = NULL, $section = NULL, $groupid = NULL,
                          $activity1, $activity2 = NULL, $average, $custom_title, $custom_weight_array ) {

    // @Camille : Ai-je besoin de déclarer les variables sachant que j'attribue des valeurs par défaut au cas où il n'y aurait rien ?
    if ($groupid) {
        $groupname = groups_get_group_name($groupid);
    }

    if ( $activity1 ) {
        $activity1name = getActivityName( $activity1 );
    }

    if ( $activity2 ) {
        $activity2name = getActivityName( $activity2 );
    }

    // Options
    echo html_writer::tag('h4', 'Options');

    echo '<ul>';

    // Form type
    echo html_writer::tag('li', 'Form type : ' . $formtype);

    // Group name
    if ( $modality ) {
        echo html_writer::tag('li', 'Modality : ' . $modality);
    }

    // Group name
    if ( $groupid ) {
        echo html_writer::tag('li', 'Group name : ' . $groupname . ' (#' . $groupid . ')');
    }

    // Activities
    echo html_writer::tag('li', 'Activity 1 : ' . $activity1name . ' (#' . $activity1 . ')');
    if ( $activity2 ) {
        echo html_writer::tag('li', 'Activity 2 : ' . $activity2name . ' (#' . $activity2 . ')');
    }

    // Average
    if ($average == true) {
        echo html_writer::tag('li', 'Average : yes');
    } else {
        echo html_writer::tag('li', 'Average : no');
    }

    // Custom average
    if ($custom_weight_array != NULL) {
        echo html_writer::tag('li', 'Custom weighting : yes');
        echo html_writer::tag('li', 'Activity 1 weight : ' . $custom_weight_array[0]);
        echo html_writer::tag('li', 'Activity 2 weight : ' . $custom_weight_array[1]);
    }

    // Custom title
    if ($custom_title) {
        echo html_writer::tag('li', 'Custom title : ' . $custom_title);
    }

    // Temporality and section
    // echo html_writer::tag('li', 'Temporality : ' . $temporality);
    // echo html_writer::tag('li', 'Section : ' . $section);

    echo '</ul>';

}

function printPluginConfig() {
    global $CFG;

    // Options
    echo html_writer::tag('h4', 'Plugin Config (for this course)');

    echo '<ul>';

    if ( $CFG->scgr_plugin_enabled ) {
        echo html_writer::tag('li', 'scgr_plugin_enabled : ' . $CFG->scgr_plugin_enabled );
    }

    if ( $CFG->scgr_plugin_disable ) {
        echo html_writer::tag('li', 'scgr_plugin_disable : ' . $CFG->scgr_plugin_disable );
    }

    if ( $CFG->scgr_course_activation_choice ) {
        echo html_writer::tag('li', 'scgr_course_activation_choice : ' . $CFG->scgr_course_activation_choice );
    }

    if ( $CFG->scgr_course_groups_activation_choice ) {
        echo html_writer::tag('li', 'scgr_course_groups_activation_choice : ' . $CFG->scgr_course_groups_activation_choice );
    }

    if ( $CFG->scgr_course_include_user_roles ) {
        echo html_writer::tag('li', 'scgr_course_include_user_roles : ' . $CFG->scgr_course_include_user_roles );
    }

    echo '</ul>';

    echo '<hr>';

}

// 1 = manager, 2 = course creator, 3 = teacher, 4 = non-editing teacher, 5 = student, 6 = guest

function stripUserRolesFromUsers($users_array) {
    global $DB, $CFG;

    $new_users_array = array();
    $roles_to_include_string = $CFG->scgr_course_include_user_roles;
    $roles_to_include = array_map('intval', explode(',', $roles_to_include_string));

    foreach ( $users_array as $user ) {

        $current_user = $DB->get_record('user', array( 'id' => intval($user) ) );

        foreach ( $roles_to_include as $role ) {

            if ( user_has_role_assignment( $current_user->id, $role ) && !user_has_role_assignment( $current_user->id, 4 ) ) {

                array_push($new_users_array, $current_user->id);

            }

        }

    }

    return $new_users_array;

}

function getUsersFromCourse($courseid) {

    $fields = 'u.id, u.username';               // return these fields
    $users_array = array();                     // declare users array

    $context = context_course::instance($courseid);             // fix context
    $users = get_enrolled_users($context, '', 0, $fields);      // get users from courseid

    foreach ( $users as $user ) {
        array_push($users_array, intval($user->id));
    }

    return $users_array;

}

function getUsernamesFromUsers($users_array) {
    global $DB;

    $usernames_array = array();                 // declare usernames array

    foreach ( $users_array as $user ) {

        $current_user = $DB->get_record('user', array( 'id' => intval($user) ));
        array_push( $usernames_array, $current_user->username );

    }

    return $usernames_array;

}

function getUserRoles() {
    global $DB;

    $sql = "SELECT id, shortname FROM unitice_role ORDER BY id ASC";        // SQL Query
    $records = $DB->get_records_sql($sql);                                  // Get records with Moodle function
    $user_roles = array();

    foreach ( $records as $role ) {
        $user_roles[$role->id] = $role->shortname;
    }

    return $user_roles;

}

function printGraph( $courseid, $modality = NULL, $temporality = NULL, $section = NULL, $groupid = NULL,
                     $activity1 = NULL, $activity2 = NULL, $aregroupsactivated = NULL, $average, $custom_title = NULL,
                     $custom_weight_array = NULL ) {

    global $OUTPUT;

    if ( !isset($modality) || $modality == 'intra' ) {

        // If there are user groups and $groupid variable
        if ( $aregroupsactivated == true && $groupid != NULL ) {

            $users = getUsersFromGroup($groupid);           // Get users from this group
            $usernames = getUsernamesFromGroup($groupid);   // Get usernames from this group

        // If there are no groups = grab all users from course
        } elseif ( $aregroupsactivated == false ) {

            $users = getUsersFromCourse($courseid);         // Get all users from course
            $users = stripUserRolesFromUsers($users);       // Remove all non-wanted user roles

            $usernames = getUsernamesFromUsers($users);     // Get usernames from users

        }

        echo html_writer::tag('h1', 'Graph' );

        // Get grades from user array and item_id
        $grades1 = getGrades($users, $courseid, $activity1);

        if ( $grades1 && $usernames ) {

            $chart = new \core\chart_bar(); // Create a bar chart instance.
            $series1 = new \core\chart_series( getActivityName( $activity1 ) , $grades1);

            if ( $custom_title != NULL ) {
                $chart->set_title( $custom_title );
            }

            $chart->add_series($series1);
            $chart->set_labels($usernames);

            if ( $activity2 ) {
                $grades2 = getGrades($users, $courseid, $activity2);
                $series2 = new \core\chart_series( getActivityName( $activity2 ) , $grades2);
                $chart->add_series($series2);

                if ( $average == true && $custom_weight_array == NULL ) {

                    $grades_average = getSimpleAverage($grades1, $grades2);
                    $series_average = new \core\chart_series( get_string('form_simple_label_average', 'gradereport_scgr') , $grades_average);
                    $chart->add_series($series_average);

                } elseif ( $average == true && $custom_weight_array != NULL ) {

                    $grades_average = getWeightedAverage($grades1, $grades2, $custom_weight_array);
                    $grades_average_string = get_string('form_simple_label_average', 'gradereport_scgr') . ' ('.$custom_weight_array[0].'+'.$custom_weight_array[1].')';
                    $series_average = new \core\chart_series( $grades_average_string , $grades_average);
                    $chart->add_series($series_average);

                }
            }

            echo $OUTPUT->render_chart($chart);

            echo '<hr />';

            echo '<a href="http://d1abo.i234.me/labs/moodle/grade/report/scgr/index.php?id=' . $courseid . '">Back</a>';

            exportAsJPEG();

        } else {

            echo html_writer::tag('h3', 'Error');
            echo html_writer::tag('p', 'users or grades not avalaible.');
            echo '<a href="http://d1abo.i234.me/labs/moodle/grade/report/scgr/index.php?id=' . $courseid . '">Back</a>';

        }

    } elseif ( isset($modality) && $modality == 'inter' ) {

        $grades1 = getGradesFromGroups($courseid, $activity1);                  // Get grades for activity 1
        $groupnames = getGroupNames($courseid);                                 // Get groupnames

        // Output graph if $groupnames and $grades
        if ( $grades1 && $groupnames ) {

            $chart = new \core\chart_bar(); // Create a bar chart instance.
            $series1 = new \core\chart_series( getActivityName( $activity1 ) , $grades1);

            if ( $custom_title != NULL ) {
                $chart->set_title( $custom_title );
            }

            $chart->add_series($series1);
            $chart->set_labels($groupnames);

            if ( $activity2 ) {
                $grades2 = getGradesFromGroups($courseid, $activity2);          // Get grades for activity 2
                $series2 = new \core\chart_series( getActivityName( $activity2 ) , $grades2);
                $chart->add_series($series2);

                if ( $average == true && $custom_weight_array == NULL ) {

                    $grades_average = getSimpleAverage($grades1, $grades2);
                    $series_average = new \core\chart_series( get_string('form_simple_label_average', 'gradereport_scgr') , $grades_average);
                    $chart->add_series($series_average);

                } else if ( $average == true && $custom_weight_array != NULL ) {

                    $grades_average = getWeightedAverage($grades1, $grades2, $custom_weight_array);
                    $grades_average_string = get_string('form_simple_label_average', 'gradereport_scgr') . ' ('.$custom_weight_array[0].'+'.$custom_weight_array[1].')';
                    $series_average = new \core\chart_series( $grades_average_string , $grades_average);
                    $chart->add_series($series_average);

                }

            }

            // $chart->set_title( 'Double graph' );

            echo $OUTPUT->render_chart($chart);

            echo '<hr />';

            echo '<a href="http://d1abo.i234.me/labs/moodle/grade/report/scgr/index.php?id=' . $courseid . '">Back</a> - ';

            exportAsJPEG();

        } else {

            echo html_writer::tag('h3', 'Error');
            echo html_writer::tag('p', 'users or grades not avalaible.');
            echo '<a href="http://d1abo.i234.me/labs/moodle/grade/report/scgr/index.php?id=' . $courseid . '">Revenir</a>';

        }

    }

}

/*
 * getAverage
 *
 * returns an array with simple averages (automatic weighting) from two arrays with float values inside.
 *
 * @activity1 (array) array containing X float values inside
 * @activity2 (array) array containing X float values inside
 * @return (array)
 */

function getSimpleAverage( $activity1, $activity2 ) {

    $average = array();

    $i = 0;
    foreach ( $activity1 as $grade1 ) {
        $val = ( $grade1 + $activity2[$i] ) / 2;
        array_push($average, $val);
        $i++;
    }

    return $average;
}

function getWeightedAverage( $activity1, $activity2, $custom_weight_array ) {

    $total_weight = array_sum($custom_weight_array);
    $average = array();

    $i = 0;
    foreach ( $activity1 as $grade1 ) {
        $val = ( $grade1 * $custom_weight_array[0] + $activity2[$i] * $custom_weight_array[1] ) / $total_weight;
        array_push($average, $val);
        $i++;
    }

    return $average;

}

/*
 * getAverage
 *
 * prints an url that creates JPG from cavas onclick and downloads image
 *
 * @echo (url)
 */

function exportAsJPEG() {

    echo '<a onclick="canvasToImage(\'#FFFFFF\')" download="export.jpg" href="" id="chartdl">Export as JPG</a>';

    // Improve heritage
    echo '<script type="text/javascript">
	    	function canvasToImage(backgroundColor)	{
			var canvas = document.getElementsByTagName("canvas")[0];
			var context = canvas.getContext("2d");
			//cache height and width		
			//var w = canvas.width;
			//var h = canvas.height;
			var w = 1920;
			var h = 1080;

			var data;

			if(backgroundColor)
			{
				//get the current ImageData for the canvas.
				data = context.getImageData(0, 0, w, h);

				//store the current globalCompositeOperation
				var compositeOperation = context.globalCompositeOperation;

				//set to draw behind current content
				context.globalCompositeOperation = "destination-over";

				//set background color
				context.fillStyle = backgroundColor;

				//draw background / rect on entire canvas
				context.fillRect(0,0,w,h);
			}

			//get the image data from the canvas
			var imageData = canvas.toDataURL("image/jpeg");

			if(backgroundColor)
			{
				//clear the canvas
				context.clearRect (0,0,w,h);

				//restore it with original / cached ImageData
				context.putImageData(data, 0,0);

				//reset the globalCompositeOperation to what it was
				context.globalCompositeOperation = compositeOperation;
			}

			//return the Base64 encoded data url string
			document.getElementById("chartdl").href=imageData;
		}
	    </script>';

}

/*
 * getGradesFromGroups
 *
 * returns an array with X grades (average grade for each group) for a given activity.
 *
 * @courseid (int)
 * @activity (int) Moodle activity ID
 * @return (array)
 */

function getGradesFromGroups( $courseid, $activity ) {

    $groups = getGroupsIDS($courseid);
    $groups_grades = array();

    foreach ( $groups as $groupid ) {

        $users = getUsersFromGroup($groupid);
        $grading_info = grade_get_grades($courseid, 'mod', 'assign', $activity, $users);
        $users_grades = array();
        $total = 0;

        foreach ($users as $user) {

            $user_grade = $grading_info->items[0]->grades[$user]->grade;
            array_push( $users_grades, floatval($user_grade) );

            $total = $total + floatval($user_grade);
        }

        $count = count( $users_grades );
        $average = $total / $count;

        // Push average grade of group in array
        array_push($groups_grades, $average);

    }

    return $groups_grades;

}

/*
 * getGroupsIDS
 *
 * returns an array with ID's of groups found in a course
 *
 * @courseid (int)
 * @return (array)
 */

function getGroupsIDS( $courseid ) {
    $groups = groups_get_all_groups($courseid);
    $groups_array = array();

    foreach ( $groups as $group ) {
        array_push( $groups_array, intval($group->id) );
    }

    return $groups_array;

}

/*
 * getActivityName
 *
 * returns the name of an activity (based on it's instance)
 *
 * @instanceitem (object)
 * @return (string)
 */

function getActivityName($instanceitem) {
    global $DB;

    $sql = "SELECT * FROM unitice_assign WHERE id = $instanceitem";           // SQL Query
    $records = $DB->get_records_sql($sql);

    foreach ($records as $record) {
        return $record->name;
    }
}

/*
 * getGrades
 *
 * returns the grade of users for a certain activity
 *
 * @users (array)
 * @courseid (int)
 * @activity (int?)
 *
 * @return (array)
 */

function getGrades($users, $courseid, $activity) {

    $grading_info = grade_get_grades($courseid, 'mod', 'assign', $activity, $users);
    $grades = array();

    foreach ($users as $user) {

        if ( !empty($grading_info->items) ) {
            $grade = $grading_info->items[0]->grades[$user]->grade;
            array_push($grades, floatval($grade));
        }

    }

    return $grades;

}

/*
 * getCoursesIDandNames
 *
 * returns an array with courses ID's and names
 *
 * @return (array)
 */

function getCoursesIDandNames() {
    $courses = get_courses();
    $courses_array = array();

    foreach ( $courses as $course ) {

        if ( $course->format != 'site' ) {

            $courses_array[$course->id] = $course->fullname;

        }
    }

    return $courses_array;
}

/*
 * getSectionsFromCourseID
 *
 * returns the sections included in a course
 *
 * @courseid (int)
 *
 * @return (array)
 */

function getSectionsFromCourseID($courseid) {
    global $DB;

    $sql = "SELECT * FROM unitice_course_sections
            WHERE course = $courseid";         // SQL Query
    $records = $DB->get_records_sql($sql);                  // Get records with Moodle function
    $sections_list = array();                               // Initialize sections array (empty)
    foreach ( $records as $record ) {                       // This loop populates sections array
        $sections_list[$record->id] = $record->name . ' (' . $record->id . ')';
    }

    return $sections_list;
}

/*
 * getActivitiesFromCourseID
 *
 * returns the an array with all the activities included in a course
 *
 * @courseid (int)
 * @categoryid (int)
 *
 * @return (array)
 */

function getActivitiesFromCourseID($courseid, $categoryid) {
    global $DB;

    $sql = "SELECT * FROM unitice_grade_items
                    WHERE courseid = " . $courseid . "
                    AND hidden != 1
                    AND categoryid = " . $categoryid . " ORDER BY iteminstance";       // SQL Query
    $records = $DB->get_records_sql($sql);                  // Get records with Moodle function
    $activities_list = array();

    foreach ( $records as $record ) {
        $activities_list[$record->iteminstance] = $record->itemname . ' (' . $record->iteminstance . ')';
    }

    return $activities_list;
}

/*
 * getUsersFromGroup
 *
 * returns an array with users from a given group
 *
 * @groupid (int)
 *
 * @return (array)
 */

function getUsersFromGroup($groupid) {
    $fields = 'u.id, u.username';              //return these fields
    $users = groups_get_members($groupid, $fields, $sort='lastname ASC');
    $users_array = array();

    foreach ( $users as $user ) {
        array_push($users_array, intval($user->id));
    }

    return $users_array;
}

/*
 * getUsernamesFromGroup
 *
 * returns an array with the user's names from a group
 *
 * @groupid (int)
 *
 * @return (array)
 */

function getUsernamesFromGroup($groupid) {

    $fields = 'u.username';              //return these fields
    $users = groups_get_members($groupid, $fields, $sort='lastname ASC');

    $usernames = array();

    foreach ( $users as $user ) {
        array_push($usernames, $user->username);
    }

    return $usernames;
}

/*
 * getGroups
 *
 * returns an array with Groups id's and names
 *
 * @courseid (int)
 *
 * @return (array)
 */

function getGroups($courseid) {
    $groups = groups_get_all_groups($courseid);
    $groups_array = array();

    foreach ( $groups as $group ) {
        $groups_array[$group->id] = $group->name;
    }

    return $groups_array;
}

/*
 * getGroupNames
 *
 * returns an array with Groups names
 *
 * @courseid (int)
 *
 * @return (array)
 */

function getGroupNames($courseid) {
    $groups = groups_get_all_groups($courseid);
    $groups_array = array();

    foreach ( $groups as $group ) {
        array_push($groups_array, $group->name);
    }

    return $groups_array;
}