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
 * Defines site settings for the social comparison grade report (scgr)
 *
 * @package   gradereport_scgr
 * @copyright 2017 onwards André Camacho http://www.camacho.pt
 * @author    André Camacho
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once $CFG->dirroot.'/grade/report/scgr/lib.php';

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // Test setting
    $optionstest = array('a', 'b', 'c');
    $settings->add(new admin_setting_configmultiselect(  'scgr_test', 'test',
        'test bla bla bla.', $optionstest, $optionstest ));


    /// Choose in which courses the plugin should be active

    $settings->add(new admin_setting_configcheckbox(  'scgr_plugin_enabled', 'Enable the plugin',
        'Selecting this option will activate the plugin.', 0 ));

    $options = array();
    $courses = getCoursesIDandNames();
    $settings->add(new admin_setting_configmultiselect(  'scgr_course_activation_choice', 'Activate report on these courses',
                                                    'Choose in which courses you want the SCGR report to be avalaible.', $options, $courses ));


    // Choose in which courses the "groups" feature should be activated

    $options2 = array();
    $courses2 = getCoursesIDandNames();
    $settings->add(new admin_setting_configmultiselect(  'scgr_course_groups_activation_choice', 'Activate group feature on these courses.',
        'Choose in which courses you want the SCGR groups feature to be enabled.', $options2, $courses2 ));


    // Choose what user roles to ignore
    // 1 = manager, 2 = course creator, 3 = teacher, 4 = non-editing teacher, 5 = student, 6 = guest

    $options3 = array();
    $user_roles_to_include = getUserRoles();

    $settings->add(new admin_setting_configmultiselect(  'scgr_course_include_user_roles', 'Include user roles.',
        'Choosing user roles here will only include grades for these user roles in graphs.', $options3, $user_roles_to_include ));


}