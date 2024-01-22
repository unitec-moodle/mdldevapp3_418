<?php
// unitec_info - A plugin for Moodle to show staff, students and courses information at Unitec.
// It calls external database, peoplesoft, to get all information about Unitec staff info, 
// student enrolment info and course info.
//
// @package    report
// @subpackage unitec_info

// File		   index.php
// @author     Yong Liu (yliu@unitec.ac.nz)
//             Te Puna Ako
//             Unitec Institute of Technology, Auckland, New Zealand
// @version    2013070500

//
// For a given question type, list the number of
//
// @package    report
// @subpackage Unitec_info
// @copyright  2013 Unitec
// @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
//
 
 // Report all PHP errors
error_reporting(E_ALL);

// Same as error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);

require('../../config.php');
require_once($CFG->libdir.'/adminlib.php');



// Print the header & check permissions.
admin_externalpage_setup('reportunitec_info', '', null, '', array('pagelayout'=>'report'));
echo $OUTPUT->header();


// Log.
add_to_log(SITEID, "course", "report unitec_info", "report/unitec_info/index.php", "Unitec staff, students and courses info");

echo $OUTPUT->heading(get_string('unitec_info', 'report_unitec_info'));
echo '<p id="intro">', get_string('intro', 'report_unitec_info') , '</p>';
echo '<div>| <a title="Staff search" href="app_staff_search.php" >Staff search</a> | 
			 <a title="PeopleSoft student search" href="app_ps_student_search.php">PeopleSoft student search</a> | 
			 <a title="Student exception search" href="app_exception_search.php">Student exception search</a> | 
			 <a title="Class exception search" href="app_class_exception_search.php">Class exception search</a>  | 
			 <a href="app_course_search.php" title="Course search">Course search</a> |
	  </div>';
// Footer.
echo $OUTPUT->footer();
