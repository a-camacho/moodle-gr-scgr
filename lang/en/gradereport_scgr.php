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

$string['student_intra_description'] = 'L\'étudiant peut voir une visualisation de ses résultats au travers différentes
activités (à son choix) contrastées avec la moyenne de son propre groupe.';

$string['student_inter_description'] = 'L\'étudiant peut voir une visualisation comparant les résultats des différents
groupes à travers différentes activités.';

$string['teacher_progression_description'] = 'Le tuteur peut voir la progression de ses apprenants (leur réussite sur
différentes activités au choix)';



// Predefined graphs - Customize

$string['predefined_customize_title'] = 'Customize graph';
$string['predefined_customize_label_activity'] = 'Activities';


/* ################################################################################################################ */
/* ##############################################      FORMS        ############################################### */
/* ################################################################################################################ */

// Forms - Custom

$string['form_custom_title'] = 'Custom graph';
$string['form_custom_subtitle'] = 'Generate a graph using one value (grade or average) for one entity (person or group)';
$string['form_custom_subtitle2'] = '';

// Forms - Custom - Labels

$string['form_custom_label_custom_title'] = 'Custom title';
$string['form_custom_label_viewtype'] = 'View type';
$string['form_custom_label_modality'] = 'Modality';
$string['form_custom_label_activity'] = 'Choose activity';
$string['form_custom_label_activities'] = 'Activities';
$string['form_custom_label_group'] = 'Group';
$string['form_custom_label_average'] = 'Calculate average';
$string['form_custom_label_averageonly'] = 'Show only average';
$string['form_custom_label_custom_weighting'] = 'Custom weighting';

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
$string['helper_modality'] = 'Choose modality';
$string['helper_modality_help'] = 'Intra-group will show you comparison of students of a group.<br />Inter-group will show you comparison of groups in course.';
$string['helper_average'] = 'Calculate average?';
$string['helper_averageonly'] = 'Show average only';
$string['helper_averageonly_help'] = 'If enabled, the series used to calculate average will be hidden and only average will be showed.';
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

$string['settings_page_title'] = 'SCGR Settings';


/* ################################################################################################################ */
/* #############################################      FUNCTIONS        ############################################ */
/* ################################################################################################################ */

// Navigation

$string['nav_custom'] = 'Custom chart';
$string['nav_student_intra'] = 'Me vs others';
$string['nav_student_inter'] = 'My group vs other groups';
$string['nav_teacher_progression'] = 'Progression';
$string['nav_teacher_comparison'] = 'Comparison';