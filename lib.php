<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * printCustomNav
 * prints the navigation tabs
 *
 * @param $courseid
 * @param $role
 * @param $view
 * @param $course_has_groups
 */
function printCustomNav( $courseid, $role, $view, $course_has_groups ) {

    switch ($role) {
        case 'student':
            echo '<ul class="nav nav-tabs m-b-1">';
            echo '<li class="nav-item">';

            if ( $view == 'default' || $view == 'intra' ) {
                $intermode = '';
                $intramode = 'active';
            } elseif ( $view == 'inter' || $view == 'comparison' ) {
                $intermode = 'active';
                $intramode = '';
            }

            echo '<li class="nav-item"><a class="nav-link ' . $intramode . '" href="index.php?id=' . $courseid . '&view=intra"
                          title="' . get_string('nav_student_intra', 'gradereport_scgr') . '">' . get_string('nav_student_intra', 'gradereport_scgr') . '</a></li>';

            if ( $course_has_groups != false ) {

                echo '<li class="nav-item"><a class="nav-link ' . $intermode . '" href="index.php?id=' . $courseid . '&view=inter"
                          title="' . get_string('nav_student_inter', 'gradereport_scgr') . '">' . get_string('nav_student_inter', 'gradereport_scgr') . '</a></li>';

            }

            echo '</ul>';
            break;

        case 'editingteacher':

            if ( $view == 'default' || $view == 'custom' ) {
                $custom = 'active';
                $help = '';
            } elseif ( $view == 'help' ) {
                $custom = '';
                $help = 'active';
            }

            echo '<ul class="nav nav-tabs m-b-1">';
            echo '<li class="nav-item"><a class="nav-link ' . $custom . '" title="' . get_string('nav_custom', 'gradereport_scgr') . '"
                                          href="index.php?id=' . $courseid . '&view=custom">' . get_string('nav_custom', 'gradereport_scgr') . '</a></li>';
            echo '<li class="nav-item"><a class="nav-link ' . $help . '" title="' . get_string('nav_help', 'gradereport_scgr') . '"
                                          href="index.php?id=' . $courseid . '&view=help">' . get_string('nav_help', 'gradereport_scgr') . '</a></li>';
            echo '</ul>';
            break;

        case 'teacher':

            if ( $view == 'default' || $view == 'progression' ) {
                $comparison = '';
                $progression = 'active';
                $custom = '';
            } elseif ( $view == 'comparison' ) {
                $comparison = 'active';
                $progression = '';
                $custom = '';
            } elseif ( $view = 'custom' ) {
                $comparison = '';
                $progression = '';
                $custom = 'active';
            }

            echo '<ul class="nav nav-tabs m-b-1">';

            echo '<li class="nav-item"><a class="nav-link ' . $progression . '" href="index.php?id=' . $courseid . '&view=progression"
                          title="' . get_string('nav_teacher_progression', 'gradereport_scgr') . '">' . get_string('nav_teacher_progression', 'gradereport_scgr') . '</a></li>';

            echo '<li class="nav-item"><a class="nav-link ' . $comparison . '" href="index.php?id=' . $courseid . '&view=comparison"
                          title="' . get_string('nav_teacher_comparison', 'gradereport_scgr') . '">' . get_string('nav_teacher_comparison', 'gradereport_scgr') . '</a></li>';

            echo '<li class="nav-item"><a class="nav-link ' . $custom . '" title="' . get_string('nav_custom', 'gradereport_scgr') . '" href="index.php?id=' . $courseid . '&view=custom">' . get_string('nav_custom', 'gradereport_scgr') . '</a></li>';
            echo '</ul>';
            break;
    }

}

/**
 * printOptions
 * prints the options used for chart geneneration (for debug purpose)
 *
 * @param $courseid
 * @param $modality
 * @param null $groupid
 * @param $activities
 * @param $average
 * @param $custom_title
 * @param $viewtype
 * @param bool $gradesinpercentage
 */
function printOptions( $courseid, $modality, $groupid = NULL, $activities, $average, $custom_title, $viewtype, $gradesinpercentage = false ) {

    $groupname = groups_get_group_name($groupid);

    // Options
    echo html_writer::tag('h5', 'Options');

    echo '<ul>';

    if ( $groupname ) {
        echo html_writer::tag('li', 'Group name : ' . $groupname . ' (#' . $groupid . ')');
    } else {
    }

    if ( $modality ) {
        echo html_writer::tag('li', 'Modality : ' . $modality);
    } else {
        echo html_writer::tag('li', 'Modality : ignored');
    }

    if ( $gradesinpercentage == true ) {
        echo html_writer::tag('li', 'Grades in % : yes');
    } else {
        echo html_writer::tag('li', 'Grades in % : no');
    }

    if ( $average ) {
        echo html_writer::tag('li', 'Average : ' . $average);
    } else {
        echo html_writer::tag('li', 'Average : no');
    }

    if ( $custom_title ) {
        echo html_writer::tag('li', '$custom_title : ' . $custom_title);
    } else {
        echo html_writer::tag('li', '$custom_title : no');
    }

    if ( $viewtype ) {
        echo html_writer::tag('li', '$viewtype : ' . $viewtype);
    } else {
        echo html_writer::tag('li', '$viewtype : error');
    }

    echo '</ul>';

    if ( $activities ) {
        echo html_writer::tag('h6', 'Activities');
        echo '<ul>';
        foreach ( $activities as $activity ) {
            echo html_writer::tag('li', 'Activity : ' . getActivityName($activity, $courseid) . ' (#' . $activity . ')');
        }
        echo '</ul>';
    } else {
        echo html_writer::tag('li', 'Activity : ignored');
    }

    echo '<hr>';

}

/**
 * printGraph
 * prints the chart based on parameters given in form
 *
 * @param $courseid
 * @param $modality
 * @param null $groupid
 * @param null $activities
 * @param $average
 * @param $custom_title
 * @param null $custom_weight_array
 * @param $averageonly
 * @param $viewtype
 * @param $course_has_groups
 * @param $context
 * @param $gradesinpercentage
 */
function printGraph( $courseid, $modality, $groupid = NULL, $activities = NULL, $average, $custom_title,
                     $custom_weight_array = NULL, $averageonly, $viewtype, $course_has_groups, $context, $gradesinpercentage ) {

    global $OUTPUT, $CFG;

    if ( isset($modality) && $modality == 'intra' ) {

        if ( $course_has_groups == true ) {
            // Get users from choosen group
            $users = getUsersFromGroup($groupid);               // Get users from this group
            $users = stripTutorsFromUsers($users, $context);    // Strip tutors from users
            $usernames = getUsernamesFromUsers($users);         // Get usernames from users
        } else {
            // Get users from course
            $users = getUsersFromContext($context);
            $users = stripTutorsFromUsers($users, $context);            // Strip tutors from users
            $usernames = getUsernamesFromUsers($users);                 // Get usernames from users
        }

        if ( $custom_title ) {
            echo html_writer::tag('h1', $custom_title );
        }

        echo html_writer::tag('h4', groups_get_group_name($groupid) );

        // Get grades for each activity
        $grades_array = array();
        $activities_names = array();

        // Get grades from user array and item_id
        foreach ( $activities as $activity ) {

            // Push user grades for the activity
            $activity_grades = getGrades($users, $courseid, $activity, $gradesinpercentage);
            array_push($grades_array, $activity_grades);

            // Push the name of activity in array
            array_push($activities_names, getActivityName($activity, $courseid));

        }

        // Generate the chart
        if ( $grades_array && $usernames ) {

            // Create chart and set some settings
            $chart = new \core\chart_bar(); // Create a bar chart instance.
            // Axes
            $yaxis = $chart->get_yaxis(0, true);

            if ($gradesinpercentage) {
                $yaxis->set_label("Grade in %");
                $yaxis->set_min(0);
                $yaxis->set_max(100);
            } else {
                $yaxis->set_label("Grade in points");
            }

            // Iterate over the activities final grades
            $i = 0;
            foreach ( $grades_array as $activity_grades) {
                $series = new \core\chart_series($activities_names[$i], $activity_grades);

                if ( $averageonly == NULL ) {
                    $chart->add_series($series);
                }

                $i++;
            }

            // Create a series with averages
            if ( $average ) {

                $average_array = array();

                foreach ( $users as $user ) {
                    $user_grades = getActivitiesGradeFromUserID($user, $courseid, $activities, $gradesinpercentage);
                    array_push($average_array, getAverage($user_grades, $custom_weight_array));
                }

                $average_series = new \core\chart_series('Average', $average_array);
                $chart->add_series($average_series);

            }

            // More settings
            $chart->set_labels($usernames);
            if ($custom_title) {
                $chart->set_title($custom_title);
            }
            if ($viewtype == 'horizontal-bars') {
                $chart->set_horizontal(true);
            }

            // Chart colors
            $colors_array = array('#001f3f', '#d2d2d2', '#c2c2c2', '#b2b2b2', '#a2a2a2', '#929292', '#828282', '#727272');
            if ( $average ) {
                $colors_array[count($activities)+1] = '#7fa4e0';
            }
            $CFG->chart_colorset = $colors_array;

            // Output chart
            echo $OUTPUT->render_chart($chart);

            echo '<hr />';

            echo '<a href="http://d1abo.i234.me/labs/moodle/grade/report/scgr/index.php?id=' . $courseid . '">Back</a>';

        } else {

            echo html_writer::tag('h3', 'Error');
            echo html_writer::tag('p', 'users or grades not avalaible.');
            echo '<a href="index.php?id=' . $courseid . '">Back</a>';

        }

    } elseif ( isset($modality) && $modality == 'inter' ) {

        $groupnames = getGroupNames($courseid);
        $groups = getGroupsIDS($courseid);

        // Output graph if $groupnames and $activities
        if ( $activities && $groupnames ) {

            $chart = new \core\chart_bar(); // Create a bar chart instance.

            // Axes
            $yaxis = $chart->get_yaxis(0, true);

            if ($gradesinpercentage) {
                $yaxis->set_label("Grade in %");
                $yaxis->set_min(0);
                $yaxis->set_max(100);
            } else {
                $yaxis->set_label("Grade in points");
            }

            foreach ( $activities as $activity ) {
                $grades = getGradesFromGroups($courseid, $activity, $gradesinpercentage, $context);
                $series = new \core\chart_series(getActivityName($activity, $courseid), $grades);
                $chart->add_series($series);
            }

            // Create a series with averages
            if ( $average ) {

                $averages = array();

                foreach ( $groups as $group ) {

                    $group_grades = getActivitiesGradeFromGroupID($group, $courseid, $activities, $gradesinpercentage, $context);
                    $group_average = getAverage($group_grades, $custom_weight_array);

                    array_push($averages, $group_average);
                }

                $average_series = new \core\chart_series('Average', $averages);
                $chart->add_series($average_series);
            }

            // Chart settings
            if ($custom_title) { $chart->set_title($custom_title); }
            if ($viewtype == 'horizontal-bars') { $chart->set_horizontal(true); }
            $chart->set_labels($groupnames);

            $colors_array = array('#001f3f', '#d2d2d2', '#c2c2c2', '#b2b2b2', '#a2a2a2', '#929292', '#828282', '#727272');
            if ( $average ) {
                $colors_array[count($activities)+1] = '#7fa4e0';
            }
            $CFG->chart_colorset = $colors_array;

            echo $OUTPUT->render_chart($chart);

            echo '<hr />';

            echo '<a href="http://d1abo.i234.me/labs/moodle/grade/report/scgr/index.php?id=' . $courseid . '">Back</a> - ';

        } else {

            echo html_writer::tag('h3', 'Error');
            echo html_writer::tag('p', 'users or grades not avalaible.');
            echo '<a href="http://d1abo.i234.me/labs/moodle/grade/report/scgr/index.php?id=' . $courseid . '">Revenir</a>';

        }

    }

}

/**
 * printPluginConfig
 * prints the plugin options (for debug purpose)
 */
function printPluginConfig() {
    global $CFG;

    // Options
    echo html_writer::tag('h5', 'Plugin Config');

    echo '<ul>';

    if ( $CFG->scgr_plugin_disable ) {
        echo html_writer::tag('li', 'scgr_plugin_disable : ' . $CFG->scgr_plugin_disable );
    }

    if ( $CFG->scgr_course_activation_choice ) {
        echo html_writer::tag('li', 'scgr_course_activation_choice : ' . $CFG->scgr_course_activation_choice );
    }

    if ( $CFG->scgr_course_groups_activation_choice ) {
        echo html_writer::tag('li', 'scgr_course_groups_activation_choice : ' . $CFG->scgr_course_groups_activation_choice );
    }

    echo '</ul>';

    echo '<hr>';

}

/**
 * stripTutorsGroupFromGroupIDS
 * removes users with "tutor" role from groups id array
 *
 * @param $groups
 * @return array
 */
function stripTutorsGroupFromGroupIDS($groups) {

    $groups_to_ignore = array(1);
    $new_groups = array();

    foreach ( $groups as $group ) {

        if ( !in_array($group, $groups_to_ignore) ) {
            array_push($new_groups, $group);
        }

    }

    return $new_groups;
}

/**
 * stripTutorsFromUsers
 * removes users with "tutor" role from users array
 *
 * @param $users
 * @param $context
 * @return array
 */
function stripTutorsFromUsers($users, $context) {
    $new_users = array();
    foreach ($users as $userid) {
        $user_roles = get_user_roles($context, $userid, false);
        $ignore_user = false;
        foreach ( $user_roles as $role ) {
            if ( $role->shortname == 'teacher' || $role->shortname == 'editingteacher' ) {
                $ignore_user = true;
            }
        }
        if ( $ignore_user == false ) {
            array_push($new_users, $userid);
        }
    }
    return $new_users;
}

/**
 * collapseHeaders
 * collapses header by default, so we can see the chart sooners
 */
function collapseHeaders() { ?>
    <script>
        var d = document.getElementById("id_scgr-general");
        d.className += " collapsed";
        var c = document.getElementById("id_scgr-general");
        c.className += " collapsed";
    </script>
<?php }

/**
 * getAverage
 * returns an array with simple averages (automatic weighting) from two arrays with float values inside.
 * @param $grades
 * @param null $weights
 * @return float|int
 */
function getAverage( $grades, $weights = NULL ) {

    if ( $grades ) {

        if ( $weights ) {

            $weights_sum = array_sum($weights);
            $total = 0;
            $i = 0;

            foreach ($grades as $grade) {
                $user_grade_weighted = ( $grade * $weights[$i] );
                $total = $user_grade_weighted + $total;
                $i++;
            }

            $result = $total / $weights_sum;
            $result = round($result, 2);

        } else {
            $result = array_sum($grades) / count($grades);
            $result = round($result, 2);
        }
    }

    return $result;
}

/**
 * getGradesFromGroups
 * returns an array with X grades (average grade for each group) for a given activity.
 *
 * @param $courseid
 * @param $activity
 * @param bool $inpercentage
 * @param $context
 * @return array
 */
function getGradesFromGroups( $courseid, $activity, $inpercentage = false, $context ) {

    $groups = getGroupsIDS($courseid);
    $groups_grades = array();

    foreach ( $groups as $groupid ) {

        $users = getUsersFromGroup($groupid);
        $users = stripTutorsFromUsers($users, $context);    // Strip tutors from users

        $users_grades = array();
        $total = 0;

        foreach ($users as $user) {
            $user_grade = getGrade($user, $courseid, $activity, $inpercentage);
            $user_grade = round(floatval($user_grade), 2);
            array_push( $users_grades, $user_grade);
            $total = $total + floatval($user_grade);
        }

        $count = count( $users_grades );
        $average = $total / $count;
        $average = round($average, 2);

        // Push average grade of group in array
        array_push($groups_grades, $average);

    }

    return $groups_grades;

}

/**
 * getGroupsIDS
 * returns an array with ID's of groups found in a course
 *
 * @param $courseid
 * @return array
 */
function getGroupsIDS( $courseid ) {
    $groups = groups_get_all_groups($courseid);
    $groups_array = array();
    foreach ( $groups as $group ) {
        array_push( $groups_array, intval($group->id) );
    }
    return $groups_array;
}

/**
 * getActivityName
 * returns the name of an activity (based on it's instance)
 *
 * @param $instanceitem
 * @param $courseid
 * @return int|null|string
 */
function getActivityName($instanceitem, $courseid) {
    global $DB, $CFG;

    $sql = "SELECT itemname FROM " . $CFG->prefix . "grade_items WHERE iteminstance = $instanceitem AND courseid = $courseid";   // SQL Query
    $records = $DB->get_records_sql($sql);

    return key($records);
}

/**
 * getActivitiesNames
 * returns an array with activities names from an array with activities ids
 *
 * @param $activities
 * @param $courseid
 * @return array
 */
function getActivitiesNames($activities, $courseid) {
    global $DB, $CFG;

    $activities_names = array();

    foreach ( $activities as $activity) {
        $sql = "SELECT itemname FROM " . $CFG->prefix . "grade_items WHERE iteminstance = $activity AND courseid = $courseid";
        $records = $DB->get_records_sql($sql);
        array_push($activities_names, key($records));
    }

    return $activities_names;
}

/**
 * getGrades
 * returns the grade of users for a certain activity
 *
 * @param $users
 * @param $courseid
 * @param $activity
 * @param bool $inpercentage
 * @return array
 */
function getGrades($users, $courseid, $activity, $inpercentage = false) {
    global $DB, $CFG;

    $modulename = $DB->get_records_sql('SELECT itemmodule FROM ' . $CFG->prefix . 'grade_items WHERE courseid = ? AND iteminstance = ?', array($courseid, $activity));
    $modulename = key($modulename);

    $grading_info = grade_get_grades($courseid, 'mod', $modulename, $activity, $users);

    $max_grade = floatval($grading_info->items[0]->grademax);

    $grades = array();

    foreach ($users as $user) {
        if ( !empty($grading_info->items) ) {
            $grade = $grading_info->items[0]->grades[$user]->grade;

            if ($inpercentage == true) {
                $grade = $grade / $max_grade * 100;
                $grade = round($grade, 2);
            }

            array_push($grades, floatval($grade));
        }
    }
    return $grades;
}

/**
 * getGrade
 * returns the grade of an user for a certain activity
 *
 * @param $userid
 * @param $courseid
 * @param $activity
 * @param bool $inpercentage
 * @return float|int|null
 */
function getGrade($userid, $courseid, $activity, $inpercentage = false) {
    global $DB, $CFG;

    $modulename = $DB->get_records_sql('SELECT itemmodule FROM ' . $CFG->prefix . 'grade_items WHERE courseid = ? AND iteminstance = ?', array($courseid, $activity));
    $modulename = key($modulename);

    $grading_info = grade_get_grades($courseid, 'mod', $modulename, $activity, $userid);
    $grade = NULL;
    $max_grade = floatval($grading_info->items[0]->grademax);

    if ( !empty($grading_info->items) ) {
        $grade = $grading_info->items[0]->grades[$userid]->grade;

        if ($inpercentage == true) {
            $grade = $grade / $max_grade * 100;
            $grade = round($grade, 2);
        }

        return $grade;
    }
}

/**
 * getEnrolledUsersFromContext
 * returns an array of users enrolled in a given course
 *
 * @param $context
 * @return array
 */
function getEnrolledUsersFromContext($context) {

    $fields = 'u.id, u.username';              //return these fields
    $users = get_enrolled_users($context, '', 0, $fields);
    $users_array = array();

    foreach ( $users as $user ) {
        array_push($users_array, intval($user->id));
    }

    return $users_array;

}

/**
 * getActivityGradeFromGroupID
 * returns the average grade of a group of users, for a given activity
 *
 * @param $groupid
 * @param $courseid
 * @param $activity
 * @param bool $inpercentage
 * @param $context
 * @return float|int|null
 */
function getActivityGradeFromGroupID($groupid, $courseid, $activity, $inpercentage = false, $context) {
    global $DB, $CFG;

    $modulename = $DB->get_records_sql('SELECT itemmodule FROM ' . $CFG->prefix . 'grade_items WHERE courseid = ? AND iteminstance = ?', array($courseid, $activity));
    $modulename = key($modulename);

    $grading_info = grade_get_grades($courseid, 'mod', $modulename, $activity, 0);
    $users = getUsersFromGroup($groupid);
    $users = stripTutorsFromUsers($users, $context);

    $grades = array();
    $max_grade = floatval($grading_info->items[0]->grademax);

    foreach ($users as $userid) {

        $grading_info = grade_get_grades($courseid, 'mod', $modulename, $activity, $userid);
        $grade = NULL;

        if ( !empty($grading_info->items) ) {
            $grade = $grading_info->items[0]->grades[$userid]->grade;

            if ($inpercentage == true) {
                $grade = $grade / $max_grade * 100;
                $grade = round($grade, 2);
            }

            array_push($grades, $grade);
        }

    }

    if ( count($grades) != 0 ) {
        $grade = array_sum($grades) / count($grades);
    } else {
        $grade = 0;
    }

    return $grade;

}

/**
 * getActivitiesGradeFromGroupID
 * returns the average grades of a group of users, for an array of activities
 *
 * @param $groupid
 * @param $courseid
 * @param $activities
 * @param $gradeinpercentage
 * @param $context
 * @return array
 */
function getActivitiesGradeFromGroupID($groupid, $courseid, $activities, $gradeinpercentage, $context) {
    $grades = array();
    foreach ( $activities as $activity ) {
        $grade = getActivityGradeFromGroupID($groupid, $courseid, $activity, $gradeinpercentage, $context);
        array_push($grades, $grade);
    }
    return $grades;
}

/**
 * getActivityGradeFromUsers
 * returns an array with users grade for a given activity
 *
 * @param $users
 * @param $courseid
 * @param $activity
 * @param bool $inpercentage
 * @return array
 */
function getActivityGradeFromUsers($users, $courseid, $activity, $inpercentage = false) {
    global $DB, $CFG;

    $modulename = $DB->get_records_sql('SELECT itemmodule FROM ' . $CFG->prefix . 'grade_items WHERE courseid = ? AND iteminstance = ?', array($courseid, $activity));
    $modulename = key($modulename);

    $grades_array = array();

    foreach ( $users as $userid ) {

        $grading_info = grade_get_grades($courseid, 'mod', $modulename, $activity, $userid);
        $max_grade = floatval($grading_info->items[0]->grademax);
        $grade = NULL;

        if ( !empty($grading_info->items) ) {
            $grade = $grading_info->items[0]->grades[$userid]->grade;
        }

        if ($inpercentage == true) {
            $grade = $grade / $max_grade * 100;
            $grade = round($grade, 2);
        }

        array_push($grades_array, $grade);

    }

    return $grades_array;

}

/**
 * getActivitiesGradeFromUserID
 * returns an array with an user grades for given activities
 *
 * @param $userid
 * @param $courseid
 * @param $activities
 * @param bool $inpercentage
 * @return array
 */
function getActivitiesGradeFromUserID($userid, $courseid, $activities, $inpercentage = false) {
    $grades = array();
    foreach ($activities as $activity) {
        $grade = getGrade($userid, $courseid, $activity, $inpercentage);
        array_push($grades, $grade);
    }
    return $grades;
}

/**
 * getActivitiesGradeFromUsers
 * returns an array with grades for given activities and for given users
 *
 * @param $users
 * @param $courseid
 * @param $activities
 * @param bool $inpercentage
 * @return array
 */
function getActivitiesGradeFromUsers($users, $courseid, $activities, $inpercentage = false) {
    global $DB, $CFG;
    $average_grades = array();
    foreach ($activities as $activity) {
        $modulename = $DB->get_records_sql('SELECT itemmodule FROM ' . $CFG->prefix . 'grade_items WHERE courseid = ? AND iteminstance = ?', array($courseid, $activity));
        $modulename = key($modulename);
        $grades = array();
        $grading_info = grade_get_grades($courseid, 'mod', $modulename, $activity, 0);
        foreach ( $users as $user ) {
            $grading_user_info = grade_get_grades($courseid, 'mod', $modulename, $activity, $user);
            if ( !empty($grading_user_info->items) ) {
                if ( !empty($grading_user_info->items[0]->grades[$user]->grade) ) {
                    $grade = $grading_user_info->items[0]->grades[$user]->grade;
                    array_push($grades, floatval($grade));
                }
            }
        }
        if ( count($grades) != 0 ) {
            $average_grade = array_sum($grades) / count($grades);
            if ($inpercentage == true) {
                $max_grade = floatval($grading_info->items[0]->grademax);
                $average_grade = $average_grade / $max_grade * 100;
                $average_grade = round($average_grade, 2);
            }
        } else {
            $average_grade = 0;
        }
        array_push($average_grades, number_format(floatval($average_grade), 2));
    }
    return $average_grades;
}

/**
 * getCoursesIDandNames
 * returns an array with courses ID's and names
 *
 * @return array
 */
function getCoursesIDandNames() {
    $courses = get_courses();
    $courses_array = array();
    foreach ( $courses as $course ) {
        if ( $course->format != 'site' ) {
            $courses_array[$course->id] = $course->fullname;
        }
    }
    return $courses_array;
}

/**
 * getSectionsFromCourseID
 * returns the sections included in a course
 *
 * @param $courseid
 * @return array
 */
function getSectionsFromCourseID($courseid) {
    global $DB, $CFG;
    $sql = "SELECT * FROM " . $CFG->prefix . "course_sections WHERE course = $courseid";         // SQL Query
    $records = $DB->get_records_sql($sql);                  // Get records with Moodle function
    $sections_list = array();                               // Initialize sections array (empty)
    foreach ( $records as $record ) {                       // This loop populates sections array
        $sections_list[$record->id] = $record->name . ' (' . $record->id . ')';
    }
    return $sections_list;
}

/**
 * getActivitiesFromCourseID
 * returns the an array with all the activities included in a course
 *
 * @param $courseid
 * @param $categoryid
 * @param bool $extended
 * @return array
 */
function getActivitiesFromCourseID($courseid, $categoryid, $extended = false) {
    global $DB, $CFG;

    $sql = "SELECT iteminstance, itemname, aggregationcoef2 FROM " . $CFG->prefix . "grade_items WHERE
            courseid = " . $courseid . " AND hidden != 1 AND categoryid = " . $categoryid . " ORDER BY id";

    $records = $DB->get_records_sql($sql);                  // Get records with Moodle function
    $activities_list = array();

    foreach ( $records as $record ) {
        if ( $extended ) {
            $activities_list[$record->iteminstance] = $record->itemname . ' (coef: '. $record->aggregationcoef2 .')';
        } else {
            $activities_list[$record->iteminstance] = $record->itemname;
        }
    }

    return $activities_list;
}

/**
 * getUsersFromGroup
 * returns an array with users from a given group
 *
 * @param $groupid
 * @return array
 */
function getUsersFromGroup($groupid) {
    $fields = 'u.id, u.username';              //return these fields
    $users = groups_get_members($groupid, $fields, $sort='lastname ASC');
    $users_array = array();
    foreach ( $users as $user ) {
        array_push($users_array, intval($user->id));
    }
    return $users_array;
}

/**
 * getUsersFromContext
 * returns an array with users ids enrolled in the course
 *
 * @param $context
 * @return array
 */
function getUsersFromContext($context) {
    $fields = 'u.id, u.username';              //return these fields
    $users_array = array();
    $users = get_enrolled_users($context, '', NULL, $fields);    // Get users from course (context)
    foreach ( $users as $user ) {
        array_push($users_array, intval($user->id));
    }
    return $users_array;
}

/**
 * getUsernamesFromGroup
 * returns an array with the user's names from a group
 *
 * @param $groupid
 * @return array
 */
function getUsernamesFromGroup($groupid) {
    $fields = 'u.username';              //return these fields
    $users = groups_get_members($groupid, $fields, $sort='lastname ASC');
    $usernames = array();
    foreach ( $users as $user ) {
        array_push($usernames, $user->username);
    }
    return $usernames;
}

/**
 * getUsernamesFromUsers
 * returns an array of usernames from an array of user ids
 *
 * @param $users
 * @return array
 */
function getUsernamesFromUsers($users) {
    $usernames = array();
    foreach ($users as $user) {
        array_push($usernames, getUsernameFromUserID($user) );
    }
    return $usernames;
}

/**
 * getUsernameFromUserID
 * returns username for a given user id
 *
 * @param $userid
 * @return mixed
 */
function getUsernameFromUserID($userid) {
    global $DB;

    $user = $DB->get_record('user', array('id'=> $userid ));

    return $user->username;

}

/**
 * getGroups
 * returns an array with Groups id's and names
 *
 * @param $courseid
 * @return array
 */
function getGroups($courseid) {
    $groups = groups_get_all_groups($courseid);
    $groups_array = array();

    foreach ( $groups as $group ) {
        $groups_array[$group->id] = $group->name;
    }

    return $groups_array;
}

/**
 * getGroupNames
 * returns an array with Groups names
 *
 * @param $courseid
 * @return array
 */
function getGroupNames($courseid) {
    $groups = groups_get_all_groups($courseid);
    $groups_array = array();

    foreach ( $groups as $group ) {
        array_push($groups_array, $group->name);
    }

    return $groups_array;
}