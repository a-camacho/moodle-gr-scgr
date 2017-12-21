<?php

global $USER, $CFG;

// Check if this course has groups
$courses_with_groups = array_map('intval', explode(',', $CFG->scgr_course_groups_activation_choice));

if ( in_array($courseid, $courses_with_groups) ) {
    $user_groups = groups_get_user_groups($courseid, $USER->id)[0];
    $user_groups_clean = '(groups: ' . implode(",", $user_groups) . ')';
} else {
    $user_groups = NULL;
    $user_groups_clean = '';
}

// Print title
echo html_writer::tag('h2', get_string('plugintitle', 'gradereport_scgr') . ' : ' . $role );

// Print navigation
printCustomNav( $courseid, $role, $view );

if ( $view == 'default' ) {

    include_once('modules/custom_graph.php');

} else {

    echo 'view error';

}
