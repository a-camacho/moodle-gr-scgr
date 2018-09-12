<?php

/* ######################  GENERATION FORM  ###################### */

// Initialize activities
$activities = getActivitiesFromCourseID($courseid, $categoryid, true);        // Activities

// Start container
echo '<div class="temp">';

// Print title, links and subtitles

echo html_writer::tag('h2', get_string('form_custom_title', 'gradereport_scgr') );

echo html_writer::tag('p', get_string('form_custom_subtitle', 'gradereport_scgr') );

if ( $course_has_groups && $user_groups ) {
    echo html_writer::tag('p', get_string('custom_group_restriction_desc', 'gradereport_scgr') . $user_groups_names_clean );
}

echo html_writer::tag('hr', '');

// Include the form
require_once($CFG->dirroot.'/grade/report/scgr/forms/custom_graph_form.php');

// Get groups if course_has_groups
if ( $course_has_groups == true ) {
    $groups = getGroups($courseid);
} else {
    $groups = NULL;
}

/******************** CREATE FORM *********************/

$forms_action_url = $CFG->wwwroot . '/grade/report/scgr/index.php?id=' . $courseid . '&section=custom';
$mform = new customhtml_form( $forms_action_url, array( $courseid, $activities, $groups, $course_has_groups, $user_groups ) );

if ($mform->is_cancelled()) {                                               // If form is canceled

    //Set default data (if any)
    $toform = '';
    $mform->set_data($toform);
    //displays the form
    $mform->display();

} else if ($fromform = $mform->get_data()) {                                // If data has been passed trough form

    /******************** GET DATA FROM FORM *********************/

    $data = $mform->get_data();

    /*********************** SET VARIABLES ***********************/

    if ( property_exists($data, "group") ) { $group_id = $data->group;
    } else { $group_id = NULL; }

    if ( property_exists($data, "viewtype") ) { $viewtype = $data->viewtype;
    } else { $viewtype = NULL; }

    if ( property_exists($data, "modality") ) { $modality = $data->modality;
    } else { $modality = NULL; }

    if ( property_exists($data, "average") && $data->average == '1' ) {
        $average = true;

        if ( property_exists($data, "custom_weighting_activity") ) {
            $custom_weight_array = $data->custom_weighting_activity;
            $custom_weight_array = array_map('floatval', $custom_weight_array);
        } else {
            $custom_weight_array = array();
        }

    } else {
        $average = false;
        $custom_weight_array = array(); }

    if ( property_exists($data, "graph_custom_title") ) { $custom_title = $data->graph_custom_title;
    } else { $custom_title = NULL; }

    if ( property_exists($data, "gradesinpercentage") && $data->gradesinpercentage == '1' ) { $gradesinpercentage = true;
    } else { $gradesinpercentage = false; }

    $activities = array();
    if ( property_exists($data, "activity") ) {
        foreach ( $data->activity as $activity ) {
            array_push($activities, intval($activity));
        }
    } else {
        $activities = NULL;
    }

    $averageonly = ( intval($data->averageonly) == 1 ) ? true : false;

    /*********************** PRINT GRAPH ***********************/

    // printOptions( $courseid, $modality, $group_id, $activities, $average, $custom_title, $viewtype, $gradesinpercentage);

    $toform = '';
    $mform->set_data($toform);
    //displays the form
    $mform->display();

    collapseHeaders();

    printGraph( $courseid, $modality, $group_id, $activities, $average, $custom_title, $custom_weight_array,
        $averageonly, $viewtype, $course_has_groups, $context, $gradesinpercentage );

} else {

    //Set default data (if any)
    $toform = '';
    $mform->set_data($toform);
    //displays the form
    $mform->display();

}

echo '</div>';