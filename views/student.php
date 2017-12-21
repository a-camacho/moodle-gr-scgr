<?php

global $USER;

// Check if this course has groups
$courses_with_groups = array_map('intval', explode(',', $CFG->scgr_course_groups_activation_choice));

if ( in_array($courseid, $courses_with_groups) ) {
    $user_groups = array_keys($USER->groupmember[2]);      // Function that extracts groups id's from $USER global variable
    $user_groups_clean = implode(",", $user_groups);
    $user_first_group = $user_groups[0];
} else {
    $user_groups_clean = '';
}

// Print title
echo html_writer::tag(  'h2', get_string('plugintitle', 'gradereport_scgr') . ' : ' . $role . ' - ' . $USER->firstname .
                        ' ' . $USER->lastname . ' (groups:' . $user_groups_clean . ')');

// Print navigation
printCustomNav( $courseid, $role, $view );

// printPluginConfig();

// Include the form
require_once('modules/choose_activities_form.php');

if ($view != 'inter') {

    echo html_writer::tag('p', get_string('student_intra_description', 'gradereport_scgr') );

    $activities = getActivitiesFromCourseID($courseid, $categoryid);

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

        // Print options and plugin config and graph

        if ( in_array($courseid, $courses_with_groups) ) {

            $users = getUsersFromGroup($user_first_group);

            $group_average = new \core\chart_series('Moyenne de mon groupe', getActivitiesGradeFromUsers($users, $courseid, $activities));
            $group_average->set_type(\core\chart_series::TYPE_LINE);
            $group_average->set_smooth(true);

        } else {

            $users = getEnrolledUsersFromContext($context);

            $group_average = new \core\chart_series('Moyenne de la classe', getActivitiesGradeFromUsers($users, $courseid, $activities));
            $group_average->set_type(\core\chart_series::TYPE_LINE);
            $group_average->set_smooth(true);

        }

        $chart = new core\chart_bar();
        $user_grades = new core\chart_series('Mes résultats', getActivitiesGradeFromUserID($userid, $courseid, $activities) );

        $chart->set_labels(getActivitiesNames($activities));
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

        /*
        echo 'First activity <select>
        <option value="act1">act1</option>
        <option value="act2">act2</option>
        <option value="act3">act3</option>
        <option value="act4">act4</option>
    </select>
    Last activity <select>
        <option value="act1">act1</option>
        <option value="act2">act2</option>
        <option value="act3">act3</option>
        <option value="act4">act4</option>
    </select><br /><br />';

        */

    /* $series1 = new core\chart_series('Mes résultats', [98, 76, 68, 90, 80, 74, 86, 0, 0, 0]);
    $series2 = new \core\chart_series('Moyenne de mon groupe', [96, 79, 85, 75, 78, 74, 84, 0, 0, 0]);
    $series2->set_type(\core\chart_series::TYPE_LINE); // Set the series type to line chart.
    $series2->set_smooth(true); // Calling set_smooth() passing true as parameter, will display smooth lines.
    $chart = new core\chart_bar();
    $chart->set_title('Graph #1 : STU - Me vs My group');
    $chart->set_labels(['act1', 'act2', 'act3', 'act4', 'act5', 'act6', 'act7', 'act8', 'act9', 'act10']);
    $chart->add_series($series2);
    $chart->add_series($series1);

    echo $OUTPUT->render($chart); */

} else {

    echo '<p>(example) L\'étudiant peut voir une visualisation comparant les résultats des différents groupes à travers
    différentes activités.</p>';
    $chart2 = new \core\chart_line();
    $chart2->set_title('Graph #2 : STU - Us vs Them');
    $chart2->set_smooth(true); // Calling set_smooth() passing true as parameter, will display smooth lines.
    $CFG->chart_colorset = ['#001f3f', '#11ad55', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6'];
    $seriesA = new core\chart_series('Groupe A', [98, 76, 69, 85, 80, 74, 86, 0, 0, 0]);
    $seriesB = new core\chart_series('Groupe B', [90, 79, 69, 80, 83, 70, 88, 0, 0, 0]);
    $seriesC = new core\chart_series('Groupe C', [62, 87, 68, 90, 87, 73, 81, 0, 0, 0]);
    $seriesD = new core\chart_series('Mon groupe', [73, 62, 63, 92, 78, 79, 82, 0, 0, 0]);

    $chart2->add_series($seriesD);
    $chart2->add_series($seriesA);
    $chart2->add_series($seriesB);
    $chart2->add_series($seriesC);
    $chart2->set_labels(['act1', 'act2', 'act3', 'act4', 'act5', 'act6', 'act7', 'act8', 'act9', 'act10']);
    echo $OUTPUT->render($chart2);

}