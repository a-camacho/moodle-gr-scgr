<?php

/* ######################  SIMPLE GENERATION FORM  ###################### */

// Initialize sections query and activities arrays
$sections = getSectionsFromCourseID($courseid);                         // Sections
$activities = getActivitiesFromCourseID($courseid, $categoryid);        // Activites
$groups = getGroups($courseid);

// Form that allows user to choose data to be included
echo '<div class="form-box simple">';

    // Include title and subtitle
    echo html_writer::tag('h3', get_string('form_simple_title', 'gradereport_scgr') );
    echo html_writer::tag('p', get_string('form_simple_subtitle', 'gradereport_scgr') );
    echo html_writer::tag('p', get_string('form_simple_subtitle2', 'gradereport_scgr') );
    echo html_writer::tag('hr', '');

    // Include the form
    require_once('forms/form_simple_html.php');

    // Instantiate simplehtml_form
    $mform = new simplehtml_form( $forms_action_url, array( $sections, $activities, $groups ) );

    // Form processing and displaying is done here
    if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form


    /* ######################  CHART RESULT  ###################### */


    } else if ($fromform = $mform->get_data()) {

    $data = $mform->get_data();

    echo html_writer::tag('p', 'Whatever you choose up there, the form uses INTER + ACTIVITY.');

    echo '<hr />';

    printGraph( $courseid, 'inter', 'all', 0,
    $data->group, $data->activity );

    echo '<hr />';


    /* ######################  END RESULT  ###################### */


    } else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.

    //Set default data (if any)
    $toform = '';
    $mform->set_data($toform);
    //displays the form
    $mform->display();
    }

    echo '</div>';

/* ######################  END SIMPLE GENERATION FORM  ###################### */
