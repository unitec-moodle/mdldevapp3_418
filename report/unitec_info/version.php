<?php
// unitec_info - A plugin for Moodle to show staff, students and courses information at Unitec.
// It calls external database, peoplesoft, to get all information about Unitec staff info, 
// student enrolment info and course info.
//
// @package    report
// @subpackage unitec_info

// File		   version.php
// @author     Yong Liu (yliu@unitec.ac.nz)
//             Te Puna Ako
//             Unitec Institute of Technology, Auckland, New Zealand
// @version    2016012200

//
// For a given question type, list the number of
//
// @package    report
// @subpackage Unitec_info
// @copyright  2013 Unitec
// @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
//

defined('MOODLE_INTERNAL') || die;

$plugin->version   = 2016012200;                 // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2011070400;                 // Requires this Moodle version
$plugin->component = 'report_unitec_info'; // Full name of the plugin (used for diagnostics)
