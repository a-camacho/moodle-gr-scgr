<?php

global $USER, $CFG, $DB;

// Check if this course has groups
$courses_with_groups = array_map('intval', explode(',', $CFG->scgr_course_groups_activation_choice));

// Set view or use default one
if ( isset($_GET['view']) ) {
    $view = $_GET['view'];
} else {
    $view = 'comparison';
}

if ( in_array($courseid, $courses_with_groups) ) {
    $user_groups = groups_get_user_groups($courseid, $USER->id)[0];
    $user_groups = stripTutorsGroupFromGroupIDS($user_groups);
    $user_groups_names = array();
    foreach ( $user_groups as $group ) {
        array_push($user_groups_names, groups_get_group_name($group));
    }
    $user_groups_clean = implode(", ", $user_groups);
    $user_groups_names_clean = implode(", ", $user_groups_names);
    $course_has_groups = true;
} else {
    $user_groups = NULL;
    $user_groups_clean = '';
    $user_groups_names_clean = '';
    $course_has_groups = false;
}

if ( $course_has_groups == false ) {
    echo html_writer::tag('p', get_string('nav_invalid_mode', 'gradereport_scgr') );
} else {
    // Include the form
    require_once($CFG->dirroot.'/grade/report/scgr/forms/choose_activities_form.php');
    if ( $view == 'progression' ) {

        $title = get_string('teacher_progression_title', 'gradereport_scgr');
        $switchview_url = $CFG->wwwroot . '/grade/report/scgr/index.php?id=' . $courseid . '&section=teacher&view=comparison';
        $switchview_text = '<a href="' . $switchview_url . '"><small class="h2-small-link">' . get_string('switch_to_comparison', 'gradereport_scgr') . '</small></a>';

        echo html_writer::tag('h2', $title . ' ' . $switchview_text );
        echo html_writer::tag('p', get_string('teacher_progression_description', 'gradereport_scgr') );

        $activities = getActivitiesFromCourseID($courseid, $categoryid, false);

        $forms_action_url = $CFG->wwwroot . '/grade/report/scgr/index.php?id=' . $courseid . '&section=teacher&view=progression';
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

            if ( $user_groups ) {
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
                        $series = new core\chart_series($username, getActivitiesGradeFromUserID($user, $courseid, $activities, true));
                        $series->set_type(\core\chart_series::TYPE_LINE);
                        $chart->add_series($series);
                    }

                    $chart->set_labels(getActivitiesNames($activities, $courseid));
                    echo $OUTPUT->render($chart);
                }
            } else {
                echo html_writer::tag('p', get_string('error', 'gradereport_scgr') . ' : ' . get_string('no_group_for_comparison', 'gradereport_scgr'), array('class' => 'scgr-error') );
            }

        } else {
            //Set default data (if any)
            $toform = '';
            $mform->set_data($toform);
            //displays the form
            $mform->display();
        }

    } elseif( $view == 'comparison' ) {

        $title = get_string('teacher_comparison_title', 'gradereport_scgr');
        $switchview_url = $CFG->wwwroot . '/grade/report/scgr/index.php?id=' . $courseid . '&section=teacher&view=progression';
        $switchview_text = '<a href="' . $switchview_url . '"><small class="h2-small-link">' . get_string('switch_to_progression', 'gradereport_scgr') . '</small></a>';

        echo html_writer::tag('h2', $title . ' ' . $switchview_text );
        echo html_writer::tag('p', get_string('teacher_comparison_description', 'gradereport_scgr') );

        $activities = getActivitiesFromCourseID($courseid, $categoryid);

        $forms_action_url = $CFG->wwwroot . '/grade/report/scgr/index.php?id=' . $courseid . '&section=teacher&view=comparison';
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

            if ( $user_groups ) {

                foreach ( $user_groups as $group ) {

                    $users = getUsersFromGroup($group);
                    // Strip tutors from users
                    $users = stripTutorsFromUsers($users, $context);
                    $usernames = getUsernamesFromUsers($users);

                    // Create chart
                    $chart = new core\chart_bar();

                    $CFG->chart_colorset = ['#001f3f', '#d2d2d2', '#c2c2c2', '#b2b2b2', '#a2a2a2', '#929292', '#828282', '#727272'];

                    foreach ( $activities as $activity ) {
                        $series = new core\chart_series(getActivityName($activity, $courseid), getActivityGradeFromUsers($users, $courseid, $activity, true));
                        $chart->add_series($series);
                    }

                    $chart->set_labels($usernames);

                    echo $OUTPUT->render($chart);

                }

            } else {
                echo html_writer::tag('p', get_string('error', 'gradereport_scgr') . ' : ' . get_string('no_group_for_comparison', 'gradereport_scgr'), array('class' => 'scgr-error') );
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
}