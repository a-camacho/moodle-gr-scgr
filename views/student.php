<?php

global $USER, $CFG;

// Check if this course has groups
$courses_with_groups = array_map('intval', explode(',', $CFG->scgr_course_groups_activation_choice));

if ( in_array($courseid, $courses_with_groups) ) {
    $user_groups = groups_get_user_groups($courseid, $USER->id)[0];
    $user_groups = stripTutorsGroupFromGroupIDS($user_groups);
    $user_groups_clean = '(groups: ' . implode(",", $user_groups) . ')';
    $course_has_groups = true;
    $user_first_group = $user_groups[0];
} else {
    $user_groups = NULL;
    $user_groups_clean = '';
    $course_has_groups = false;
}

// Include the form
require_once($CFG->dirroot.'/grade/report/scgr/forms/choose_activities_form.php');

if ($view != 'inter') {

    echo html_writer::tag('p', get_string('student_intra_description', 'gradereport_scgr') );

    $activities = getActivitiesFromCourseID($courseid, $categoryid, false);

    $forms_action_url = $CFG->wwwroot . '/grade/report/scgr/index.php?id=' . $courseid . '&view=intra';
    $mform = new chooseactivities_form( $forms_action_url, array( $activities ) );

    if ($mform->is_cancelled()) {

    } else if ($fromform = $mform->get_data()) {

        //Set default data and display form

        $toform = '';
        $mform->set_data($toform);
        $mform->display();

        $data = $mform->get_data();

        // Set group_id variable
        if ( property_exists($data, "activity") ) {
            $activities = $data->activity;
        } else {
            $activities = NULL;
        }

        if ( in_array($courseid, $courses_with_groups) ) {
            $users = getUsersFromGroup($user_first_group);
            $group_average = new \core\chart_series('Moyenne de mon groupe', getActivitiesGradeFromUsers($users, $courseid, $activities, true));
            $group_average->set_type(\core\chart_series::TYPE_LINE);
            $group_average->set_smooth(true);
        } else {
            $users = getEnrolledUsersFromContext($context);
            $group_average = new \core\chart_series('Moyenne de la classe', getActivitiesGradeFromUsers($users, $courseid, $activities, true));
            $group_average->set_type(\core\chart_series::TYPE_LINE);
            $group_average->set_smooth(true);
        }

        $chart = new core\chart_bar();
        $user_grades = new core\chart_series('Mes résultats', getActivitiesGradeFromUserID($userid, $courseid, $activities, true) );

        $chart->set_labels(getActivitiesNames($activities, $courseid));
        $chart->add_series($group_average);
        $chart->add_series($user_grades);

        // Set maximum Y Axis value
        $yaxis = $chart->get_yaxis(0, true);
        $yaxis->set_max(100);

        echo $OUTPUT->render($chart);

        } else {

            //Set default data (if any)
            $toform = '';
            $mform->set_data($toform);
            //displays the form
            $mform->display();

        }

} else {

    if ( $course_has_groups != false ) {

        echo html_writer::tag('p', get_string('student_inter_description', 'gradereport_scgr') );

        $activities = getActivitiesFromCourseID($courseid, $categoryid);

        $forms_action_url = $CFG->wwwroot . '/grade/report/scgr/index.php?id=' . $courseid . '&view=inter';
        $mform = new chooseactivities_form( $forms_action_url, array( $activities ) );

        if ($mform->is_cancelled()) {

        } else if ($fromform = $mform->get_data()) {

            //Set default data and display form
            $toform = '';
            $mform->set_data($toform);
            $mform->display();
            $data = $mform->get_data();

            // Start generating chart
            $chart = new \core\chart_line();
            $chart->set_smooth(true);

            // Axes
            $xaxis = $chart->get_xaxis(0, true);
            $yaxis = $chart->get_yaxis(0, true);

            $yaxis->set_label("Grade in %");
            $yaxis->set_min(1);
            $yaxis->set_max(100);

            // Try to set this color : 11ad55 to our user group
            $color_array = array(   '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6',
                '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6','#d6d6d6','#d6d6d6' );

            $groupnames = getGroupNames($courseid);
            $groups = getGroupsIDS($courseid);

            // Trouver la position de $user_first_group dans $groups
            // $pos = array_search($user_first_group, $groups);
            // Fixer la couleur en position POS+1 dans $color_array à 11ad55

            // Check the position of user groups in groups array
            $p = 0;
            $positions = array();
            foreach ( $groups as $groupid ) {
                if ( groups_is_member($groupid, $userid) ) {
                    array_push($positions, $p);
                }
                $p++;
            }

            // Fix green color on groups that user belongs too
            foreach ( $positions as $position ) {
                $color_array[$position+1] = '#11ad55';
            }

            $CFG->chart_colorset = $color_array;

            $activities = $data->activity;

            $i = 0;
            foreach ( $groups as $groupid ) {

                $users = getUsersFromGroup($groupid);
                $group_grades = getActivitiesGradeFromUsers($users, $courseid, $activities, true);
                $group_serie = new \core\chart_series($groupnames[$i], $group_grades);

                // $group_grades = getActivitiesGradeFromGroupID($groupid, $courseid, $activities);
                // $group_serie = new core\chart_series($groupnames[$i], $group_grades);
                $chart->add_series($group_serie);

                $i++;
            }

            $chart->set_labels(getActivitiesNames($activities, $courseid));

            echo $OUTPUT->render($chart);


        } else {

            //Set default data (if any)
            $toform = '';
            $mform->set_data($toform);
            //displays the form
            $mform->display();

        }

    } else {

        echo 'Error : this course has no groups in settings.';

    }

}