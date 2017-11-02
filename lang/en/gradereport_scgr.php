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

$string['pluginname'] = 'Social comparison grade report';

// Page

$string['page_plugin_not_active'] = 'SCGR plugin is not activated.';
$string['page_plugin_not_active_description'] = 'Before being able to use SCGR plugin you need to activate it
                                                         in settings page.';

$string['page_not_active_on_this_course'] = 'SCGR plugin is not activated for this course.';
$string['page_not_active_on_this_course_description'] = 'Before being able to use SCGR plugin you need to activate it
                                                         for this course in settings page.';

// Buttons

$string['form_simple_button_submit'] = 'Submit';

/* ################################################################################################################ */
/* #############################################      OPTIONS        ############################################## */
/* ################################################################################################################ */

// Options - PrintPluginConfig

$string['options_print_config_title'] = 'Plugin Config (global)';

$string['options_print_config_pluginenabled'] = 'Plugin enabled';
$string['options_print_config_courseactivedon'] = 'Plugin activated on these courses';
$string['options_print_config_groupactivedon'] = 'Group feature activated on these courses';
$string['options_print_config_excludeduserroles'] = 'User roles to be excluded from graphs';

// Options - PrintOptions

$string['options_print_title'] = 'Options';

$string['options_print_graphtype'] = 'Form type';
$string['options_print_modality'] = 'Modality';
$string['options_print_group'] = 'Group';
$string['options_print_activity'] = 'Activity';
$string['options_print_average'] = 'Average';
$string['options_print_customtitle'] = 'Custom title';
$string['options_print_viewtype'] = 'View type';


$string['options_print_word_weight'] = 'weight';


/* ################################################################################################################ */
/* ##############################################      GRAPH        ############################################### */
/* ################################################################################################################ */

/* ################################################################################################################ */
/* ##############################################      FORMS        ############################################### */
/* ################################################################################################################ */

// Forms - General

$string['form_simple_label_graph_custom_title'] = 'Custom title';

$string['form_label_viewtype'] = 'View type';

// Forms - Simple

$string['form_simple_title'] = 'Simple Graph';
$string['form_simple_subtitle'] = 'Generate a graph using one value (grade or average) for one entity (person or group)';
$string['form_simple_subtitle2'] = '';

$string['form_simple_label_modality'] = 'Modality';
$string['form_simple_label_temporality'] = 'Temporality';
$string['form_simple_label_section'] = 'Temporality';
$string['form_simple_label_activity'] = 'Temporality';
$string['form_simple_label_average'] = 'Average';
$string['form_simple_label_custom_weighting'] = 'Custom weighting';
$string['form_simple_label_custom_weighting_act_1'] = 'Weighting - Act. 1';
$string['form_simple_label_custom_weighting_act_2'] = 'Weighting - Act. 2';

$string['form_simple_value_viewtype_horizontalbars'] = 'Horizontal bars';
$string['form_simple_value_viewtype_verticalbars'] = 'Vertical bars';

$string['form_simple_value_mod_inter'] = 'Inter-group';
$string['form_simple_value_mod_intra'] = 'Intra-group';
$string['form_simple_value_tempo_all'] = 'Everything (until current section - not included)';
$string['form_simple_value_tempo_section'] = 'A particular section';
$string['form_simple_value_tempo_activity'] = 'A particular activity';
$string['form_simple_value_custom_weighting'] = '.....';

$string['form_simple_label_section'] = 'Choose a section';
$string['form_simple_label_activity'] = 'Choose an activity';
$string['form_simple_label_group'] = 'Choose a group';

$string['form_simple_label_no_groups'] = 'This course has no user groups. Field deactivated.';

// Forms - Double

$string['form_double_title'] = 'Double Graph';
$string['form_double_subtitle'] = 'Generate a graph using two values (grades from two activities) comparing users in a group, or groups in a course.';
$string['form_double_subtitle2'] = '';

$string['form_double_label_activity1'] = 'Activity 1';
$string['form_double_label_activity2'] = 'Activity 2';

$string['form_simple_label_averageony_desc'] = 'Check this if you want the activities to be hiden and show average only.';

// Form Result

$string['form_result_default_result'] = 'S-';
$string['form_result_default_phrase'] = 'You want to see an ';

$string['form_result_modality_all_result'] = '';
$string['form_result_modality_all_phrase'] = '';

// Form helpers

$string['helper_customtitle'] = 'Add a custom title?';
$string['helper_customtitle_help'] = 'If enabled, this will show a custom title in heading of graph.';

$string['helper_viewtype'] = 'Choose view type';
$string['helper_viewtype_help'] = 'Choose view type for the graph.';

$string['helper_modality'] = 'Choose modality';
$string['helper_modality_help'] = 'Intra-group will show you comparison of students of a group.<br />Inter-group will show you comparison of groups in course.';

$string['helper_average'] = 'Calculate average?';
$string['helper_average_help'] = 'If enabled, a series of data will be created with average of other activity grades.';

$string['helper_customweight'] = 'Custom average weight';
$string['helper_customweight_help'] = 'If enabled, you will be able to set a weight value to each activity for the average calc.';

$string['helper_chooseactivity'] = 'Choose an activity';
$string['helper_chooseactivity_help'] = 'Choose an activity that you want to be included in graph.';

$string['helper_group'] = 'Choose a group';
$string['helper_group_help'] = 'Choose the group you want the users to be included in graph.';

/* ################################################################################################################ */
/* #############################################      SETTINGS        ############################################# */
/* ################################################################################################################ */

// Settings Page

$string['settings_page_title'] = 'SCGR global settings';

// Course Settings Page

$string['pref_page_title'] = 'SCGR preferences';
$string['pref_explanation'] = 'This preferences determine features for SC grade report for this course only.';

$string['pref_changereportdefaults'] = 'Change global SCGR settings';
$string['pref_gotoreportpage'] = 'Go to report page';

$string['pref_general_activate_scgr'] = 'Activate SCGR on this course';
$string['pref_general_activate_groups'] = 'Activate groups feature on this course';


// Warnings

$string['settings_page_title'] = 'SCGR Settings';