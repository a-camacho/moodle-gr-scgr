<?php

/* ######################  CUSTOM GRAPH GENERATION FORM  ###################### */

// Initialize sections query and activities arrays
$sections = getSectionsFromCourseID($courseid);                         // Sections
$activities = getActivitiesFromCourseID($courseid, $categoryid);        // Activites
$groups = getGroups($courseid);

// Form that allows user to choose data to be included
echo '<div class="temp">';

// Include title and subtitle
echo html_writer::tag('h3', get_string('form_custom_title', 'gradereport_scgr') );
echo html_writer::tag('p', get_string('form_custom_subtitle', 'gradereport_scgr') );

echo html_writer::tag('hr', '');

// Include the form
require_once('forms/form_custom_html.php');

// Instantiate doublehtml_form
$activated_on = explode(",", $CFG->scgr_course_groups_activation_choice);

$forms_action_url = $CFG->wwwroot . '/grade/report/scgr/index.php?id=' . $courseid . '&graph=double';
if ( in_array( $courseid, $activated_on , false )  ) {
    $mform = new doublehtml_form( $forms_action_url, array( $sections, $activities, $groups ) );
} else {
    $mform = new doublehtml_form( $forms_action_url, array( $sections, $activities, NULL ) );
}

// Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form

} else if ($fromform = $mform->get_data()) {

    /* ######################  CHART RESULT  ###################### */

    $data = $mform->get_data();

    if ( isset($data->modality) && $data->modality == 'inter' ) {

        printOptionsDouble( $courseid, $data->modality, 'all', 0,
            NULL, $data->activity1, $data->activity2 );

        printGraphDouble( $courseid, $data->modality, 'all', 0, NULL,
            $data->activity1, $data->activity2);

    } elseif ( isset($data->modality) && $data->modality == 'intra' ) {

        printOptionsDouble( $courseid, $data->modality, 'all', 0,
            $data->group, $data->activity1, $data->activity2 );

        printGraphDouble( $courseid, $data->modality, 'all', 0, $data->group,
            $data->activity1, $data->activity2);

    } else {

        echo 'Error : modality not set';

    }

    /* ####################  END CHART RESULT  #################### */

} else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.

    /* ######################  FORM DISPLAY  ###################### */

    //Set default data (if any)
    $toform = '';
    $mform->set_data($toform);
    //displays the form
    $mform->display();
}

/* ####################  END FORM DISPLAY  #################### */

echo '</div>';

/* ######################  END SIMPLE GENERATION FORM  ###################### */
