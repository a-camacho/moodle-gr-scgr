<?php

global $USER, $CFG, $DB;

// Check if this course has groups
$courses_with_groups = array_map('intval', explode(',', $CFG->scgr_course_groups_activation_choice));

if ( in_array($courseid, $courses_with_groups) ) {
    $user_groups = groups_get_user_groups($courseid, $USER->id)[0];
    $user_groups = stripTutorsGroupFromGroupIDS($user_groups);
    $user_groups_clean = implode(", ", $user_groups);
    $course_has_groups = true;
} else {
    $user_groups = NULL;
    $user_groups_clean = '';
    $course_has_groups = false;
}

// Print title
/* echo html_writer::tag(  'h2', get_string('plugintitle', 'gradereport_scgr') . ' : ' . $USER->firstname .
    ' ' . $USER->lastname); */

// Print navigation
printCustomNav( $courseid, $role, $view, $course_has_groups);

// Include the form
require_once($CFG->dirroot.'/grade/report/scgr/forms/choose_activities_form.php');

if ( $view == 'progression' || $view == 'default' ) {

    echo html_writer::tag('p', get_string('teacher_progression_description', 'gradereport_scgr') );

    $activities = getActivitiesFromCourseID($courseid, $categoryid);

    $forms_action_url = $CFG->wwwroot . '/grade/report/scgr/index.php?id=' . $courseid . '&view=progression';
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

        foreach ( $user_groups as $group ) {

            $users = getUsersFromGroup($group);
            // Strip tutors from users
            $users = stripTutorsFromUsers($users, $context);

            // Create chart
            $chart = new \core\chart_line();
            $chart->set_smooth(true);

            $color_array = array(   'd6d6d6', '#92ff80', '#ecff80', '#80ffc2', '#ffcb80', '#80cbff', '#8086ff',
                                    '#a480ff', '#fb80ff', '#ff80bf', '#ff8080' );

            $CFG->chart_colorset = $color_array;

            foreach ($users as $user) {
                $user_object = $DB->get_record('user', array('id'=>$user));
                $username = $user_object->firstname . $user_object->lastname;
                $series = new core\chart_series($username, getActivitiesGradeFromUserID($user, $courseid, $activities));
                $series->set_type(\core\chart_series::TYPE_LINE);
                $chart->add_series($series);
            }

            $chart->set_labels(getActivitiesNames($activities, $courseid));
            echo $OUTPUT->render($chart);
        }

    } else {
        //Set default data (if any)
        $toform = '';
        $mform->set_data($toform);
        //displays the form
        $mform->display();
    }

} elseif( $view == 'comparison' ) {

    echo html_writer::tag('p', get_string('teacher_comparison_description', 'gradereport_scgr') );

    $activities = getActivitiesFromCourseID($courseid, $categoryid);

    $forms_action_url = $CFG->wwwroot . '/grade/report/scgr/index.php?id=' . $courseid . '&view=comparison';
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

        foreach ( $user_groups as $group ) {

            $users = getUsersFromGroup($group);
            // Strip tutors from users
            $users = stripTutorsFromUsers($users, $context);
            $usernames = getUsernamesFromUsers($users);

            // Create chart
            $chart = new core\chart_bar();

            $CFG->chart_colorset = ['#001f3f', '#d2d2d2', '#c2c2c2', '#b2b2b2', '#a2a2a2', '#929292', '#828282', '#727272'];

            foreach ( $activities as $activity ) {
                $series = new core\chart_series(getActivityName($activity, $courseid), getActivityGradeFromUsers($users, $courseid, $activity));
                $chart->add_series($series);
            }

            $chart->set_labels($usernames);

            echo $OUTPUT->render($chart);

        }

    } else {

        //Set default data (if any)
        $toform = '';
        $mform->set_data($toform);
        //displays the form
        $mform->display();

    }

} elseif( $view == 'custom' ) {

    include_once('modules/custom_graph.php');

}