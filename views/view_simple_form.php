<?php

/* ######################  SIMPLE GENERATION FORM  ###################### */

// Initialize sections query and activities arrays
$sections = getSectionsFromCourseID($courseid);                         // Sections
$activities = getActivitiesFromCourseID($courseid, $categoryid);        // Activites
$groups = getGroups($courseid);

echo '<div class="temp">';

    // Include title and subtitle
    echo html_writer::tag('h3', get_string('form_simple_title', 'gradereport_scgr') . ' <a href="?id=' . $courseid . '&graph=double" style="font-size:small;">go to double</a>' );

    echo html_writer::tag('p', get_string('form_simple_subtitle', 'gradereport_scgr') );
    echo html_writer::tag('p', get_string('form_simple_subtitle2', 'gradereport_scgr') );

    echo html_writer::tag('hr', '');

    // Include the form
    require_once('forms/form_simple_html.php');

    // Instantiate simplehtml_form
    $activated_on = explode(",", $CFG->scgr_course_groups_activation_choice);

    $forms_action_url = $CFG->wwwroot . '/grade/report/scgr/index.php?id=' . $courseid . '&graph=simple';
    if ( in_array( $courseid, $activated_on , false )  ) {
        $mform = new simplehtml_form( $forms_action_url, array( $sections, $activities, $groups ) );
    } else {
        $mform = new simplehtml_form( $forms_action_url, array( $sections, $activities, NULL ) );
    }

    // Form processing and displaying is done here
    if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form

    } else if ($fromform = $mform->get_data()) {

        /* ######################  CHART RESULT  ###################### */

        $data = $mform->get_data();

        // echo html_writer::tag('p', 'Whatever you choose up there, the form uses INTER + ACTIVITY.');
        // echo '<hr />';

        if ( isset($data->modality) && $data->modality == 'inter' ) {

            printOptions( $courseid, $data->modality, 'all', 0, NULL, $data->activity );

            printPluginConfig();

            printGraph( $courseid, $data->modality, 'all', 0, NULL, $data->activity );

        } elseif ( isset($data->modality) && $data->modality == 'intra' ) {

            printOptions( $courseid, $data->modality, 'all', 0,
                $data->group, $data->activity );

            printGraph( $courseid, $data->modality, 'all', 0,
                $data->group, $data->activity );

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
