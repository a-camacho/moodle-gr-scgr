<?php

/* ######################  GENERATION FORM  ###################### */

// Initialize sections query and activities arrays
$sections = getSectionsFromCourseID($courseid);                         // Sections
$activities = getActivitiesFromCourseID($courseid, $categoryid);        // Activites

// Start container
echo '<div class="temp">';

$mode = 'custom';

// Print title, links and subtitles
echo html_writer::tag('h3', get_string('form_' . $mode . '_title', 'gradereport_scgr') );

echo html_writer::tag('p', get_string('form_' . $mode . '_subtitle', 'gradereport_scgr') );
echo html_writer::tag('p', get_string('form_' . $mode . '_subtitle2', 'gradereport_scgr') );

echo html_writer::tag('hr', '');

// Include the form
require_once('custom_graph_form.php');

// Check if group feature is activated on this course
$groupsactivated = explode(",", $CFG->scgr_course_groups_activation_choice);
$aregroupsactivated = false;

if ( in_array( $courseid, $groupsactivated , false ) ) {
    // Set parameter at true
    $aregroupsactivated = true;
    // Get groups
    $groups = getGroups($courseid);
} else {
    // Set groups at NULL
    $groups = NULL;
}

// Create form action url
$forms_action_url = $CFG->wwwroot . '/grade/report/scgr/index.php?id=' . $courseid . '&graph=' . $mode;

$mform = new customhtml_form( $forms_action_url, array( $sections, $activities, $groups, $aregroupsactivated ) );

// Handle form cancel operation, if cancel button is present on form
if ($mform->is_cancelled()) {

    // Do nothing

    // If data has been passed trough form
} else if ($fromform = $mform->get_data()) {

    $data = $mform->get_data();

    // Set group_id variable
    if ( property_exists($data, "group") ) {
        $group_id = $data->group;
    } else {
        $group_id = NULL;
    }

    // Set viewtype variable
    if ( property_exists($data, "viewtype") ) {
        $viewtype = $data->viewtype;
    } else {
        $viewtype = NULL;
    }

    // Set modality variable
    if ( property_exists($data, "modality") ) {
        $modality = $data->modality;
    } else {
        $modality = NULL;
    }

    // Set modality variable
    if ( property_exists($data, "average") && $data->average == '1' ) {
        $average = true;
    } else {
        $average = false;
    }

    // Set custom title
    if ( property_exists($data, "graph_custom_title") ) {
        $custom_title = $data->graph_custom_title;
    } else {
        $custom_title = NULL;
    }

    // Set custom average

    // INFO :   intval() function converts user input to int. If user enters text it will show 1, if user enters
    //          nothing it should fix it at 0.

    if ( property_exists($data, "custom_weighting") && $data->custom_weighting == '1' ) {
        $custom_weight_array = array();
        array_push($custom_weight_array, intval($data->custom_weighting_activity1));
        array_push($custom_weight_array, intval($data->custom_weighting_activity2));
    } else {
        $custom_weight_array = NULL;
    }

    // Print options and plugin config

    if ( $mode == 'double' ) {

        // Check and set if user wants all activities or only average
        $averageonly = ( intval($data->averageonly) == 1 ) ? true : false;

        printPluginConfig();
        printTheOptions(    $mode, $courseid, $modality, NULL, NULL, $group_id, $data->activity1,
            $data->activity2, $average, $custom_title, $custom_weight_array, $viewtype );
        printGraph( $courseid, $modality, NULL, NULL, $group_id, $data->activity1,
            $data->activity2, $aregroupsactivated, $average, $custom_title, $custom_weight_array,
            $averageonly, $viewtype );

    } else {

        printPluginConfig();
        printTheOptions( $mode, $courseid, $modality, NULL, NULL, $group_id, $data->activity1,
            NULL, $average, $custom_title, $custom_weight_array, $viewtype );
        printGraph( $courseid, $modality, NULL, NULL, $group_id, $data->activity1,
            NULL, $aregroupsactivated, $average, $custom_title, $custom_weight_array = NULL,
            $averageonly = NULL, $viewtype );

    }

    // If the data doesn't validate or first display
} else {

    //Set default data (if any)
    $toform = '';
    $mform->set_data($toform);
    //displays the form
    $mform->display();

}

echo '</div>';