<?php

global $USER, $CFG, $DB;

// Check if this course has groups
$courses_with_groups = array_map('intval', explode(',', $CFG->scgr_course_groups_activation_choice));

if ( in_array($courseid, $courses_with_groups) ) {
    $user_groups = groups_get_user_groups($courseid, $USER->id)[0];
    $user_groups = stripTutorsGroupFromGroupIDS($user_groups);
    $user_groups_clean = '(groups: ' . implode(",", $user_groups) . ')';
    $course_has_groups = true;
} else {
    $user_groups = NULL;
    $user_groups_clean = '';
    $course_has_groups = false;
}

// Print title
echo html_writer::tag(  'h2', get_string('plugintitle', 'gradereport_scgr') . ' : ' . $role . ' - ' . $USER->firstname .
    ' ' . $USER->lastname . ' ' . $user_groups_clean);

// Print navigation
printCustomNav( $courseid, $role, $view, $course_has_groups);

// Include the form
require_once('modules/choose_activities_form.php');

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

            $color_array = array(   '#d6d6d6', '#8c8c8c', '#d6d6d6', '#8c8c8c', '#d6d6d6', '#8c8c8c', '#d6d6d6', '#8c8c8c',
                '#d6d6d6', '#8c8c8c', '#d6d6d6', '#8c8c8c', '#d6d6d6','#8c8c8c','#d6d6d6' );

            $CFG->chart_colorset = $color_array;

            foreach ($users as $user) {
                $user_object = $DB->get_record('user', array('id'=>$user));
                $username = $user_object->firstname . $user_object->lastname;
                $series = new core\chart_series($username, getActivitiesGradeFromUserID($user, $courseid, $activities));
                $series->set_type(\core\chart_series::TYPE_LINE);
                $chart->add_series($series);
            }

            $chart->set_labels(getActivitiesNames($activities));
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

    echo '<p>Le tuteur peut comparer la réussite sur différentes activités (au choix) pour chaque apprenant de son groupe</p>';
    $chart4 = new core\chart_bar();
    $chart4->set_title('Graph #4 : TUT - Comparison');
    $CFG->chart_colorset = ['#001f3f', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#11ad55'];
    $series1 = new core\chart_series('Act1', [98, 76, 69, 85, 80, 74, 86, 0, 0, 0]);
    $series2 = new core\chart_series('Act2', [90, 79, 69, 80, 83, 70, 88, 0, 0, 0]);
    $series3 = new core\chart_series('Act3', [62, 87, 68, 90, 87, 73, 81, 0, 0, 0]);
    $series4 = new core\chart_series('Act4', [73, 62, 63, 92, 78, 79, 82, 0, 0, 0]);
    $series5 = new core\chart_series('Act5', [98, 76, 69, 85, 80, 74, 86, 0, 0, 0]);
    $series6 = new core\chart_series('Act6', [90, 79, 69, 80, 83, 70, 88, 0, 0, 0]);
    $series7 = new core\chart_series('Moyenne', [85, 79, 67, 83, 73, 80, 68, 0, 0, 0]);
    $chart4->add_series($series1);
    $chart4->add_series($series2);
    $chart4->add_series($series3);
    $chart4->add_series($series4);
    $chart4->add_series($series5);
    $chart4->add_series($series6);
    $chart4->add_series($series7);
    $chart4->set_labels(['user1', 'user2', 'user3', 'user4', 'user5', 'user6', 'user7', 'user8', 'user9', 'user10']);
    echo $OUTPUT->render($chart4);

} elseif( $view == 'custom' ) {

   include_once('modules/custom_graph.php');

}