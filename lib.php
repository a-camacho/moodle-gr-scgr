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

function printOptions( $courseid, $modality, $temporality, $section = NULL, $groupid = NULL, $activity = NULL ) {

    $groupname = groups_get_group_name($groupid);

    // Options
    echo html_writer::tag('h1', 'Options');

    echo '<ul>';

    if ( $groupname ) {
        echo html_writer::tag('li', 'Group name : ' . $groupname . '(#' . $groupid . ')');
    } else {
        echo html_writer::tag('li', 'Group name : ignored');
    }

    if ( $modality ) {
        echo html_writer::tag('li', 'Modality : ' . $modality);
    } else {
        echo html_writer::tag('li', 'Modality : ignored');
    }

    if ( $temporality ) {
        echo html_writer::tag('li', 'Temporality : ' . $temporality);
    }else {
        echo html_writer::tag('li', 'Temporality : ignored');
    }

    if ( $section ) {
        echo html_writer::tag('li', 'Section : ' . $section);
    } else {
        echo html_writer::tag('li', 'Section : ignored');
    }

    if ( $activity ) {
        echo html_writer::tag('li', 'Activity : ' . getActivityName( $activity ) . ' (#' . $activity . ')');
    } else {
        echo html_writer::tag('li', 'Activity : ignored');
    }

    echo '</ul>';

    echo '<hr>';

}

function printGraph( $courseid, $modality, $temporality, $section = NULL, $groupid = NULL, $activity = NULL ) {
    global $OUTPUT;

    if ( isset($modality) && $modality == 'intra' ) {

        // Get users from choosen group
        $users = getUsersFromGroup($groupid);           // Get users from this group
        $usernames = getUsernamesFromGroup($groupid);   // Get usernames from this group

        echo html_writer::tag('h1', getActivityName( $activity ), array( 'class' => 'scgr-graph-title2') );
        echo html_writer::tag('h4', groups_get_group_name($groupid) );

        // Get grades from user array and item_id
        $grades = getGrades($users, $courseid, $activity);

        if ( $grades && $usernames ) {

            $chart = new \core\chart_bar(); // Create a bar chart instance.
            $series1 = new \core\chart_series('Note de l\'exercice', $grades);

            $chart->add_series($series1);
            $chart->set_labels($usernames);

            echo $OUTPUT->render_chart($chart);

            echo '<hr />';
            echo '<a href="http://d1abo.i234.me/labs/moodle/grade/report/scgr/index.php?id=' . $courseid . '">Revenir</a>';

        } else {

            echo html_writer::tag('h3', 'Error');
            echo html_writer::tag('p', 'users or grades not avalaible.');
            echo '<a href="http://d1abo.i234.me/labs/moodle/grade/report/scgr/index.php?id=' . $courseid . '">Revenir</a>';

        }

    } elseif ( isset($modality) && $modality == 'inter' ) {

        echo 'Error : inter graphs still not avalaible';

    }

}

function getActivityName($instanceitem) {
    global $DB;

    $sql = "SELECT * FROM unitice_assign WHERE id = $instanceitem";           // SQL Query
    $records = $DB->get_records_sql($sql);

    foreach ($records as $record) {
        return $record->name;
    }
}

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


// Get courses ID's
function getCoursesIDandNames() {
    $courses = get_courses();
    $courses_array = array();

    foreach ( $courses as $course ) {

        if ( $course->format != 'site' ) {

            $courses_array[$course->id] = $course->fullname;

            // array_push( $courses_array, intval($course->id) );
            // array_push( $courses_array, $course->fullname );

        }
    }

    return $courses_array;
}

// Get sections from courseID
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

// Returns an array with exercices from course
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

// Returns an array with users from the group
function getUsersFromGroup($groupid) {
    $fields = 'u.id, u.username';              //return these fields
    $users = groups_get_members($groupid, $fields, $sort='lastname ASC');
    $users_array = array();

    foreach ( $users as $user ) {
        array_push($users_array, intval($user->id));
    }

    return $users_array;
}

// Returns an array with user names (parameter : int groupid)
function getUsernamesFromGroup($groupid) {

    $fields = 'u.username';              //return these fields
    $users = groups_get_members($groupid, $fields, $sort='lastname ASC');

    $usernames = array();

    foreach ( $users as $user ) {
        array_push($usernames, $user->username);
    }

    return $usernames;
}

// Returns an array with Groups names (parameter : int courseID)
function getGroups($courseid) {
    $groups = groups_get_all_groups($courseid);
    $groups_array = array();

    foreach ( $groups as $group ) {
        $groups_array[$group->id] = $group->name;
    }

    return $groups_array;
}

/**
 * Definition of the grade_report_scgr_overview class
 *
 * @package   gradereport_scgr
 * @copyright 2017 onwards André Camacho http://www.camacho.pt
 * @author    André Camacho
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
