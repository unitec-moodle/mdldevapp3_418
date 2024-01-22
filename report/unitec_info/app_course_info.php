<?php
// unitec_info - A plugin for Moodle to show staff, students and courses information at Unitec.
// It calls external database, peoplesoft, to get all information about Unitec staff info, 
// student enrolment info and course info.
//
// @package    report
// @subpackage unitec_info

// File		   app_course_info.php
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
require('config_unitec.php');
require_once($CFG->libdir.'/adminlib.php');

// Print the header & check permissions.
admin_externalpage_setup('reportunitec_info', '', null, '', array('pagelayout'=>'report'));
echo $OUTPUT->header();

?>
<link href="layout.css" rel="stylesheet" type="text/css" />

    <p align="center"><br />
    <span class="page_title">Unitec Course Info</span><br /><br />
<?php

// Get the form inquiry

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {

  $subject = trim($_POST['subject']) ;
  $category = trim($_POST['category']) ;
  $class_number = trim($_POST['class_number']) ;
  $name = trim($_POST['name']) ;
  $description = trim($_POST['description']) ;
  $faculty_code = trim($_POST['faculty_code']) ;
  $department_code = trim($_POST['department_code']) ;
  
  $sele_subject = $_POST['sele_subject'] ;
  $sele_category = $_POST['sele_category'] ;
  $sele_class_number = $_POST['sele_class_number'] ;
  $sele_name = $_POST['sele_name'] ;
  $sele_description = $_POST['sele_description'] ;
  $sele_faculty_code = $_POST['sele_faculty_code'] ;
  $sele_department_code = $_POST['sele_department_code'] ;
}

// Initiallized the database.
$dbhost = $CFG->dbhost;
$dbname = $CFG_UNITEC->dbname;
$dbuser = $CFG_UNITEC->dbuser;
$dbpass = $CFG_UNITEC->dbpass;

$connect = new mysqli($dbhost,$dbuser,$dbpass, $dbname) or die ("Couldn't connect to server");

if ($connect->connect_errno) {
	print "***** Connect failed: %s ***** \n" . $connect->connect_error;
	exit();
}

//
// List PeopleSoft staff records 
//

// First initialize MySQL search criteria...

$where_phrase = (!strlen($subject) ? "" : ("subject LIKE '" . 
				(strcasecmp($sele_subject, "LIKE") == 0 ? $subject : '%' . $subject . '%') . "'")); // Search subject
$where_phrase .= (!strlen($category) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" category LIKE '" . 
				(strcasecmp($sele_category, "LIKE") == 0 ? $category : '%' . $category . '%') . "'")));	// Search category
$where_phrase .= (!strlen($class_number) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" class_number LIKE '" . 
				(strcasecmp($sele_class_number, "LIKE") == 0 ? $class_number : '%' . $class_number . '%') . "'")));	// Search class_number
$where_phrase .= (!strlen($name) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" name LIKE '" . 
				(strcasecmp($sele_name, "LIKE") == 0 ? $name : '%' . $name . '%') . "'")));	// Search course name
$where_phrase .= (!strlen($description) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" description LIKE '" . 
				(strcasecmp($sele_description, "LIKE") == 0 ? $description : '%' . $description . '%') . "'")));	// Search faculty_code
$where_phrase .= (!strlen($faculty_code) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" faculty_code LIKE '" . 
				(strcasecmp($sele_faculty_code, "LIKE") == 0 ? $faculty_code : '%' . $faculty_code . '%') . "'")));	// Search department_code
$where_phrase .= (!strlen($department_code) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" department_code LIKE '" . 
				(strcasecmp($sele_department_code, "LIKE") == 0 ? $department_code : '%' . $department_code . '%') . "'")));	// Search department_code.
				
				// If no search criterion has been selected, just show all records.
if(!strlen(trim($where_phrase)))  $where_phrase = "1";
				
$sql_course_list = "SELECT * FROM bb_courses WHERE " . $where_phrase;
			
// 	print "*** " . $sql . " ***";		
	
$result_course_list = $connect->query($sql_course_list);          

if (empty($result_course_list) || $result_course_list->num_rows < 1) {
	print "<p align='center'><b>No record matches your search criteria!</b></p><br><p align='center'><A HREF='javascript:javascript:history.go(-1)'>Search again...</A></p><br>";
} else {

	print ' <table width="80%"  border="1" align="center" cellpadding="5" cellspacing="5" 
		style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:center">
		<tr style=" font-weight:bold">
		<td>Subject</td>
		<td>Category</td>
		<td>Class</td>
		<td>Name</td>
		<td>Description</td>
		<td>Faculty</td>
		<td>Depart</td>
		</tr>';
	  
	while ($record = $result_course_list->fetch_assoc()) {
													// List the search results...
		print "<tr>  <td>" . $record['subject'] . "</td>" .
					"<td>" . $record['category'] . "</td>" .
					"<td>" . $record['class_number'] . "</td>" .
					"<td>" . $record['name'] . "</td>" .  
					"<td>" . $record['description'] . "</td>" .
					"<td>" . $record['faculty_code'] . "</td>" .
					"<td>" . $record['department_code'] . "</td></tr>";
	
	}  // End of while.
	
	$record_count = $result_course_list->num_rows;
	
	print "</table></p><br>";	 
	print "<p align='center'>" . $record_count . " record(s) found.</p>";	  
	print "<p align='center'><A HREF='javascript:javascript:history.go(-1)'>Search again...</A></p>";
	
}  // else

	// Clear the memory.
$result_course_list->free();
unset($record);
$connect->close();

// Log.
add_to_log(SITEID, "course", "report unitec_info", "report/unitec_info/app_course_info.php", "Unitec courses info");


// Footer.
echo $OUTPUT->footer();
?>
    