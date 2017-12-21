<?php

global $USER, $CFG;

// Check if this course has groups
$courses_with_groups = array_map('intval', explode(',', $CFG->scgr_course_groups_activation_choice));

if ( in_array($courseid, $courses_with_groups) ) {
    $user_groups = array_keys($USER->groupmember[2]);
    $user_groups_clean = implode(",", $user_groups);
    $user_first_group = $user_groups[0];
} else {
    $user_groups_clean = '';
    $user_first_group = NULL;
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
