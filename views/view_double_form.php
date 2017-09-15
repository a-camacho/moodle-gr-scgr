<?php

/* ######################  SIMPLE GENERATION FORM  ###################### */

// Initialize sections query and activities arrays
$sections = getSectionsFromCourseID($courseid);                         // Sections
$activities = getActivitiesFromCourseID($courseid, $categoryid);        // Activites
$groups = getGroups($courseid);

// Form that allows user to choose data to be included
echo '<div class="form-box double">';

    // Include title and subtitle
    echo html_writer::tag('h3', get_string('form_double_title', 'gradereport_scgr') );
    echo html_writer::tag('p', get_string('form_double_subtitle', 'gradereport_scgr') );
    echo html_writer::tag('hr', '');

echo '</div>';

/* ######################  END SIMPLE GENERATION FORM  ###################### */
