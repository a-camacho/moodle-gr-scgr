<?php

function getTempResultz() {
    generateSimpleGraph( 'intra', 'activity', null, 5);
}

function getGrades($users, $courseid, $course_item_id) {

    $grading_info = grade_get_grades($courseid, 'mod', 'assign', $course_item_id, $users);
    $grades = array();

    foreach ($users as $user) {

        $grade = $grading_info->items[0]->grades[$user]->grade;
        array_push($grades, floatval($grade));

    }

    return $grades;
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

function getTempResults( $data ) {

    $result = get_string('form_result_default_result', 'gradereport_scgr');
    $phrase = get_string('form_result_default_phrase', 'gradereport_scgr');

    if ( $data->modality == 'intra' ) {
        $result .= 'INTRA-';
        $phrase .= 'intra-group graph (showing grades of persons), ';
    }  elseif ( $data->modality == 'inter' ) {
        $result .= 'INTER-';
        $phrase .= 'inter-group graph (showing average grade of groups), ';
    }

    if ( $data->temporality == 'all' ) {
        $result .= 'ALL';
        $phrase .= 'from the beginning of the course until last graded activity.';
    } elseif ( $data->temporality == 'section' && $data->section ) {
        $section = $data->section;
        $result .= 'S-' . $section;
        $phrase .= 'from all graded activities the section number ' . $section . ' with name Y.';
    } elseif ( $data->temporality == 'activity' && $data->activity ) {
        $activity = $data->activity;
        $result .= 'A-' . $activity;
        $phrase .= 'from the activity number ' . $activity . ' with name Y.';
    }

    echo html_writer::tag('h3', $result );
    echo html_writer::tag('p', $phrase );

    if ( $result == 'S-INTRA-A-5' ) {
        echo html_writer::tag('hr');
        echo html_writer::tag('h2', 'BOOM !' );
        echo html_writer::tag('hr');

        // generateSimpleGraph( 'intra', 'activity', null, 5);
    }

}

function generateSimpleGraph( $modality, $temporality, $section, $activity ) {
    global $DB;

    // Parameters
    $users = array (3,4,5);
    $course_item_id = 5;
    $course_module_id = 27;
    $course_module = get_coursemodule_from_id('assign', $course_module_id);

    // Grades arrays for users
    $users_formatted = array();
    $users_rawgrades = array();

    $sql = "SELECT *
            FROM unitice_grade_grades WHERE `aggregationstatus`
            LIKE 'used' AND `itemid` = 5";

    $usergrades = $DB->get_records_sql($sql);

    foreach ( $usergrades as $usergrade ) {

        echo 'user id ' . $usergrade->userid . ' has grade ' . $usergrade->rawgrade . '<br />';

        array_push($users_formatted, 'User ' . $usergrade->userid);
        array_push($users_rawgrades, $usergrade->rawgrade);
    }

    echo '<hr />';

    $chart = new \core\chart_bar(); // Create a bar chart instance.
    $series1 = new \core\chart_series('Note de l\'exercice', $users_rawgrades);

    $chart->add_series($series1);
    $chart->set_labels($users_formatted);

    var_dump($chart);

    echo html_writer::tag('hr', '');

    echo $OUTPUT->render_chart($chart);
}