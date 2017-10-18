<?php

/* ######################  GENERATION FORM  ###################### */

// Initialize sections query and activities arrays
$sections = getSectionsFromCourseID($courseid);                         // Sections
$activities = getActivitiesFromCourseID($courseid, $categoryid);        // Activites

// Start container
echo '<div class="temp">';

    // Set graph parameters
    if ( !isset($_GET['graph']) || $_GET['graph'] == 'simple' ) {
        $mode = 'simple';
        $url = 'double';
    } elseif ( $_GET['graph'] == 'double' ) {
        $mode = 'double';
        $url = 'simple';
    }

    // Print title, links and subtitles
    echo html_writer::tag('h3', get_string('form_' . $mode . '_title', 'gradereport_scgr') . ' <a href="?id=' . $courseid . '&graph=' . $url . '" style="font-size:small;">go to ' . $url . '</a>' );

    echo html_writer::tag('p', get_string('form_' . $mode . '_subtitle', 'gradereport_scgr') );
    echo html_writer::tag('p', get_string('form_' . $mode . '_subtitle2', 'gradereport_scgr') );

    echo html_writer::tag('hr', '');

    // Include the form
    require_once('forms/form_' . $mode . '_html.php');

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

    // If mode is 'double' or 'simple'
    if ( $mode == 'double' ) {
        $mform = new doublehtml_form( $forms_action_url, array( $sections, $activities, $groups, $aregroupsactivated ) );
    } else {
        $mform = new simplehtml_form( $forms_action_url, array( $sections, $activities, $groups, $aregroupsactivated ) );
    }

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

        // Print options and plugin config

        if ( $mode == 'double' ) {

            printPluginConfig();
            printTheOptions( $mode, $courseid, $modality, NULL, NULL, $group_id, $data->activity1, $data->activity2, $average );
            printGraph( $courseid, $modality, NULL, NULL, $group_id, $data->activity1, $data->activity2, $aregroupsactivated, $average, $custom_title );

        } else {

            printPluginConfig();
            printTheOptions( $mode, $courseid, $modality, NULL, NULL, $group_id, $data->activity1, NULL, $average );
            printGraph( $courseid, $modality, NULL, NULL, $group_id, $data->activity1, NULL, $aregroupsactivated, $average, $custom_title );

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
