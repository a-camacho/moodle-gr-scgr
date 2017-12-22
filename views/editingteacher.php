<?php

global $USER, $CFG;

// Check if this course has groups
$courses_with_groups = array_map('intval', explode(',', $CFG->scgr_course_groups_activation_choice));

if ( in_array($courseid, $courses_with_groups) ) {
    $user_groups = groups_get_user_groups($courseid, $USER->id)[0];
    $user_groups_clean = '(groups: ' . implode(",", $user_groups) . ')';
    $course_has_groups = true;
} else {
    $user_groups = NULL;
    $user_groups_clean = '';
    $course_has_groups = false;
}

// Print title
echo html_writer::tag('h2', get_string('plugintitle', 'gradereport_scgr') . ' : ' . $role );

// Print navigation
printCustomNav( $courseid, $role, $view, $course_has_groups );

if ( $view == 'default' || $view == 'custom' ) {
    include_once('modules/custom_graph.php');
} elseif ( $view == 'help' ) {
    include_once('modules/help.php');
} else {
    echo 'view error';
}
