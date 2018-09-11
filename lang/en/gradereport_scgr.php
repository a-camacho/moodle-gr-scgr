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

$string['no_permission_to_view_report'] = 'Permission error.';
$string['no_permission_to_view_report_description'] = 'SCGR is active but you do not have permission to view this report.';

// Buttons

$string['form_button_submit'] = 'Submit';

// Permissions and capabilities

$string['scgr:view'] = 'View SCGR report';
$string['scgr:viewstudentview'] = 'View the student\'s view';
$string['scgr:viewtutorview'] = 'View the tutor\'s view';
$string['scgr:viewcustomview'] = 'Generate a custom graph';

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

// graph axis labels
$string['yaxislabel_points'] = 'Grade in points';
$string['yaxislabel_percent'] = 'Grade in %';


/* ################################################################################################################ */
/* ##############################################      FORMS        ############################################### */
/* ################################################################################################################ */

// Forms - Custom

$string['form_custom_title'] = 'Custom chart';
$string['form_custom_subtitle'] = 'Generate a chart comparing students (or groups of students) success over chosen activities.';
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
$string['form_custom_label_averageonly'] = 'Hide activities grades (and show only average)';
$string['form_custom_label_custom_weighting'] = 'Custom weighting';
$string['form_custom_label_gradesinpercentage'] = 'Grades in %';
$string['form_custom_label_gradesinpercentage_desc'] = 'Calculate grades in percentage';

// Forms - Custom - Values

$string['form_custom_value_viewtype_horizontalbars'] = 'Horizontal bars';
$string['form_custom_value_viewtype_verticalbars'] = 'Vertical bars';
$string['form_custom_value_mod_intra'] = 'Intra-group';
$string['form_custom_value_mod_inter'] = 'Inter-group';

// Form helpers

$string['helper_customtitle'] = 'Add a custom title?';
$string['helper_customtitle_help'] = 'If filled, the value will be used as the title of the chart.';
$string['helper_viewtype'] = 'Choose view type';
$string['helper_viewtype_help'] = 'Choose a view type.';
$string['helper_gradesinpercentage'] = 'Calculates grades in percentage';
$string['helper_gradesinpercentage_help'] = 'Grades will be calculated in percentage. This is important if your
                                             activities max grade does not match';
$string['helper_modality'] = 'Choose modality';
$string['helper_modality_help'] = 'Choose a modality (more information in "Help" tab)';
$string['helper_average'] = 'Calculate average?';
$string['helper_averageonly'] = 'Show average only';
$string['helper_averageonly_help'] = 'If enabled, the series used to calculate average will be hidden and only average will be showed.';
$string['helper_average_help'] = 'Do you want to calculate and show the average grade of chosen activities ?';
$string['helper_customweight'] = 'Custom average weight';
$string['helper_customweight_help'] = 'Do you want to set a custom aggregation coefficient (weight) for each chosen
activity ? This will be used when calculating average grade.';
$string['helper_chooseactivity'] = 'Choose an activity';
$string['helper_chooseactivity_help'] = 'Choose an activity to include in chart. The aggregation coefficient set up
                                         in gradebook is showed in parentheses. If you want a custom aggregation
                                         coefficient, you need to set it up in the field on the right.';
$string['helper_group'] = 'Choose a group';
$string['helper_group_help'] = 'Choose the group of students you want to compare.';


/* ################################################################################################################ */
/* #############################################      SETTINGS        ############################################# */
/* ################################################################################################################ */

// Settings Page

$string['settings_page_title'] = 'SCGR Settings';


/* ################################################################################################################ */
/* #############################################      FUNCTIONS        ############################################ */
/* ################################################################################################################ */

// Navigation level 1

$string['nav_section_student'] = 'Student\'s view';
$string['nav_section_teacher'] = 'Tutor\'s view';
$string['nav_section_custom'] = 'Custom chart';

// Navigation

$string['nav_help'] = 'Help';
$string['nav_custom'] = 'Custom chart';
$string['nav_student_intra'] = 'Me vs others';
$string['nav_student_inter'] = 'My group vs other groups';
$string['nav_teacher_progression'] = 'Progression (my groups)';
$string['nav_teacher_comparison'] = 'Comparison (my groups)';

// Navigation errors / notices

$string['nav_info_choose_section'] = 'Please choose a view.';
$string['nav_unauthorized_section'] = 'You do not have the permission to view this section.';
$string['nav_invalid_mode'] = 'There seems to be a problem between your course configuration and the plugin\'s settings.';


/* ################################################################################################################ */
/* #############################################      HELP PAGE        ############################################ */
/* ################################################################################################################ */

// Help page

$string['help_title'] = 'Help page';
$string['help_introduction'] = 'This page gives you some information about how this plugin work.';

$string['help_section_plugin'] = 'Information and set up';
$string['help_section_usage'] = 'Usage';

$string['help_plugin_enablegroups_title'] = 'Groups of students';
$string['help_plugin_enablegroups'] = 'If you want to use the "group" functionnality of this plugin, you have to
                                       select this course in plugin settings. <strong>Location</strong> : Site
                                       administration > Grades > Report settings > Social comparison grade report';

$string['help_plugin_teachersignored_title'] = 'Teachers (tutors) in groups of students';
$string['help_plugin_teachersignored'] = 'We wanted to be able to have teacher in groups of students, for tutoring. As
                                          so, when requesting group users or group grades, users with "teacher" role will
                                          always be ignored.';

$string['help_plugin_nothingequalzero_title'] = 'No grade VS Zero (0)';
$string['help_plugin_nothingequalzero'] = 'For the moment, this plugin can\'t make the difference between an activity
                                           that has not been granted, and an activity with an user grade of 0. <br /><u>
                                           This functionnality will be added soon</u>.';

$string['help_usage_modality_title'] = 'Modality (intra vs inter)';
$string['help_usage_modality'] = 'Modalities are a way of saying if you want to watch what happens inside a group or
                                  outside (between the groups). If you choose <strong>inter-group</strong> modality you
                                  will be comparing groups of students and average grades. If you choose
                                  <strong>intra-group</strong> modality you will be comparing students grades of a
                                  specific group.';

$string['help_usage_aggregationcoef_title'] = 'Custom activity weighting (by aggregation coefficient)';
$string['help_usage_aggregationcoef'] = 'Custom aggregation coefficients are a way to tell that activities do not weight
                                         the same, when calculating average grade. If you need to set custom weights,
                                         just enter numeric values (eg: 2 or 0.25) for each category and they will be
                                         taken in account.';

$string['help_usage_savecharts_title'] = 'Save chart';
$string['help_usage_savecharts'] = 'You can save the chart for using it again. All you need is a right click on the chart
                                    with a modern web browser (tested with Chrome, Firefox and Safari).';

$string['help_usage_mouseonover_title'] = 'Chart interaction';
$string['help_usage_mouseonover'] = 'You can interact with the chart in a few ways. You can hide a series of data by
                                     clicking on the series name (or color) on top of the chart. You can also obtain
                                     informations about a node by putting your mouse on the point of intersection (node)
                                     for which you want information. Finally, you can also show the data used to create
                                     the chart by hitting the "Show chart data" link under the chart itself.';