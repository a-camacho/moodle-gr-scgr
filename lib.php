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
 * Definition of the grade_report_scgr_overview class
 *
 * @package   gradereport_scgr
 * @copyright 2017 onwards André Camacho http://www.camacho.pt
 * @author    André Camacho
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
$var = 1;

/**
 * Class providing an API for the overview report building and displaying.
 * @uses grade_report
 * @package gradereport_scgr
 */
class grade_report_scgr_overview extends grade_report {

    /**
     * The user.
     * @var object $user
     */
    public $user;

    /**
     * The user's courses
     * @var array $courses
     */
    public $courses;

    /**
     * A flexitable to hold the data.
     * @var object $table
     */
    public $table;

    /**
     * Show student ranks within each course.
     * @var array $showrank
     */
    public $showrank;

    /**
     * show course/category totals if they contain hidden items
     */
    var $showtotalsifcontainhidden;

    /**
     * An array of course ids that the user is a student in.
     * @var array $studentcourseids
     */
    public $studentcourseids;

    /**
     * An array of courses that the user is a teacher in.
     * @var array $teachercourses
     */
    public $teachercourses;

    /**
     * Constructor. Sets local copies of user preferences and initialises grade_tree.
     * @param int $userid
     * @param object $gpr grade plugin return tracking object
     * @param string $context
     */
    public function __construct($userid, $gpr, $context) {
        global $CFG, $COURSE, $DB;
        parent::__construct($COURSE->id, $gpr, $context);
    
    }

}