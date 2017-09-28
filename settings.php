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

    /// Choose in which courses the plugin should be active

    $settings->add(new admin_setting_configcheckbox(  'scgr_plugin_disable', 'Disable the plugin totally',
        'Selecting this option will disable the plugin completely.', 0 ));

    $options = array();
    $courses = getCoursesIDandNames();
    $settings->add(new admin_setting_configmultiselect(  'scgr_course_activation_choice', 'Activate report on these courses',
                                                    'Choose in which courses you want the SCGR report to be avalaible.', $options, $courses ));


    // Choose in which courses the "groups" feature should be activated

    $options2 = array();
    $courses2 = getCoursesIDandNames();
    $settings->add(new admin_setting_configmultiselect(  'scgr_course_groups_activation_choice', 'Activate group feature on these courses.',
        'Choose in which courses you want the SCGR groups feature to be enabled.', $options2, $courses2 ));


}