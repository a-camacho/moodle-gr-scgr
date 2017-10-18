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
/* ##############################################      FORMS        ############################################### */
/* ################################################################################################################ */

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

// Form Result

$string['form_result_default_result'] = 'S-';
$string['form_result_default_phrase'] = 'You want to see an ';

$string['form_result_modality_all_result'] = '';
$string['form_result_modality_all_phrase'] = '';

/* ################################################################################################################ */
/* #############################################      SETTINGS        ############################################# */
/* ################################################################################################################ */

// Settings Page

$string['settings_page_title'] = 'SCGR Settings';

// Warnings

$string['settings_page_title'] = 'SCGR Settings';