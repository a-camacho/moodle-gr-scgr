<?php
// This file is part of the Social Comparison Grade Report plugin for Moodle by André Camacho http://www.camacho.pt
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
 * Version details for the social comparison grade report
 *
 * @package   gradereport_scgr
 * @copyright 2017 onwards André Camacho http://www.camacho.pt
 * @author    André Camacho
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
defined('MOODLE_INTERNAL') || die();

$plugin->version = 2018082302;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires = 2016120500;        // Requires this Moodle version
$plugin->component = 'gradereport_scgr'; // Full name of the plugin (used for diagnostics)
$plugin->maturity  = MATURITY_RC;
$plugin->release   = '0.9.1';