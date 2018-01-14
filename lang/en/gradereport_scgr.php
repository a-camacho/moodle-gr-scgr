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
 * Strings for component 'gradereport_scgr', language 'en'
 *
 * @package   gradereport_scgr
 * @copyright 2017 onwards André Camacho http://www.camacho.pt
 * @author    André Camacho
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Social comparison report';
$string['plugintitle'] = 'SCGR';

// Page

$string['page_not_active_on_this_course'] = 'SCGR plugin is not activated for this course.';
$string['page_not_active_on_this_course_description'] = 'Before being able to use SCGR plugin you need to activate it
                                                         for this course in settings page.';

// Buttons

$string['form_button_submit'] = 'Submit';

/* ################################################################################################################ */
/* ###########################################      PREDEFINED        ############################################# */
/* ################################################################################################################ */

// Predefined graphs - Descriptions

$string['student_intra_description'] = 'Student can see a chart presenting his progress (success) over the chosen
activities and compare it with the group/classroom average.';

$string['student_inter_description'] = 'Student can see a chart comparing results of his group with results of other groups.';

$string['teacher_progression_description'] = 'Teacher can watch students progression (success) over chosen activities.';

$string['teacher_comparison_description'] = 'Teacher can see students comparison over chosen activities.';

$string['custom_group_restriction_desc'] = '<strong><u>Information</u></strong> : Teachers will only be able to generate
charts from students in groups that they belong in. <br />Groups are <strong>active</strong>. You belong to following group(s) : ';


// Predefined graphs - Customize

$string['predefined_customize_title'] = 'Customize graph';
$string['predefined_customize_label_activity'] = 'Activities';


/* ################################################################################################################ */
/* ##############################################      FORMS        ############################################### */
/* ################################################################################################################ */

// Forms - Custom

$string['form_custom_title'] = 'Custom chart';
$string['form_custom_subtitle'] = 'Generate a chart comparing students (or groups of students) over chosen activities.';
$string['form_custom_section_parameters'] = 'Chart settings';
$string['form_custom_section_activities'] = 'Activities';

// Forms - Custom - Labels

$string['form_custom_label_custom_title'] = 'Custom title';
$string['form_custom_label_viewtype'] = 'View type';
$string['form_custom_label_modality'] = 'Modality';
$string['form_custom_label_activity'] = 'Activity';
$string['form_custom_label_activity_coeff'] = 'Aggregation coeff.';
$string['form_custom_label_activities'] = 'Activities';
$string['form_custom_label_group'] = 'Group';
$string['form_custom_label_average'] = 'Calculate and show average';
$string['form_custom_label_averageonly'] = 'Show only average';
$string['form_custom_label_custom_weighting'] = 'Custom weighting';
$string['form_custom_label_gradesinpercentage'] = 'Grades in %';
$string['form_custom_label_gradesinpercentage_desc'] = 'Grades are calculated in percentage';

// Forms - Custom - Values

$string['form_custom_value_viewtype_horizontalbars'] = 'Horizontal bars';
$string['form_custom_value_viewtype_verticalbars'] = 'Vertical bars';
$string['form_custom_value_mod_intra'] = 'Intra-group';
$string['form_custom_value_mod_inter'] = 'Inter-group';

// Form helpers

$string['helper_customtitle'] = 'Add a custom title?';
$string['helper_customtitle_help'] = 'If enabled, this will show a custom title in heading of graph.';
$string['helper_viewtype'] = 'Choose view type';
$string['helper_viewtype_help'] = 'Choose view type for the graph.';
$string['helper_gradesinpercentage'] = 'Calculates grades in percentage';
$string['helper_gradesinpercentage_help'] = 'Important if your activities max grade does not match';
$string['helper_modality'] = 'Choose modality';
$string['helper_modality_help'] = 'Intra-group will show you comparison of students of a group.<br />
                                   Inter-group will show you comparison of groups in course.';
$string['helper_average'] = 'Calculate average?';
$string['helper_averageonly'] = 'Show average only';
$string['helper_averageonly_help'] = 'If enabled, the series used to calculate average will be hidden and only average will be showed.';
$string['helper_average_help'] = 'If enabled, a series of data will be created with average of other activity grades.';
$string['helper_customweight'] = 'Custom average weight';
$string['helper_customweight_help'] = 'If enabled, you will be able to set a weight value to each activity for the average calc.';
$string['helper_chooseactivity'] = 'Choose an activity';
$string['helper_chooseactivity_help'] = 'Choose an activity to include in chart. The aggregation coefficient set up
                                         in gradebook is showed in parentheses. If you want a custom aggregation
                                         coefficient, you need to set it up in the field on the right (replacing 1).';
$string['helper_group'] = 'Choose a group';
$string['helper_group_help'] = 'Choose the group you want the users to be included in graph.';


/* ################################################################################################################ */
/* #############################################      SETTINGS        ############################################# */
/* ################################################################################################################ */

// Settings Page

$string['settings_page_title'] = 'SCGR Settings';


/* ################################################################################################################ */
/* #############################################      FUNCTIONS        ############################################ */
/* ################################################################################################################ */

// Navigation

$string['nav_help'] = 'Help';
$string['nav_custom'] = 'Custom chart';
$string['nav_student_intra'] = 'Me vs others';
$string['nav_student_inter'] = 'My group vs other groups';
$string['nav_teacher_progression'] = 'Progression';
$string['nav_teacher_comparison'] = 'Comparison';

// Help page

$string['help_title'] = 'Help page';
$string['help_introduction'] = 'This page gives you some information about how this plugin work.';
$string['help_striptutors'] = 'The plugin "Social comparison grade report" ignores by default all users that have
"teacher" role when creating custom and predefined charts. <br />That way, when you generate charts with user groups grades or
users grades, only students will be considered. You can then have "teachers" in your user-groups without breaking the charts.';