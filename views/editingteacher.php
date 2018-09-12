<?php

global $USER, $CFG;

// Check if this course has groups
$courses_with_groups = array_map('intval', explode(',', $CFG->scgr_course_groups_activation_choice));

if ( in_array($courseid, $courses_with_groups) ) {

    // Get groups for current user
    $user_groups = groups_get_user_groups($courseid, $USER->id)[0];

    // Check if user has any group, if not give error and show only user grades
    if ( !empty($user_groups) ) {
        // Set variables for group chart generation
        $user_groups_clean = '(groups: ' . implode(",", $user_groups) . ')';
        $course_has_groups = true;
    } else {
        // Set group status to NULL/empty/false
        $user_groups = NULL;
        $user_groups_clean = '';
    }

}

include_once('modules/custom_graph.php');