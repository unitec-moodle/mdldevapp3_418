<?php
// unitec_info - A plugin for Moodle to show staff, students and courses information at Unitec.
// It calls external database, peoplesoft, to get all information about Unitec staff info, 
// student enrolment info and course info.
//
// @package    report
// @subpackage unitec_info

// File		   app_class_exception_info.php
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
    <span class="page_title">Class Exception Info</span><br /><br />
<?php

// Get the form inquiry

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {

  $course_id = $_POST['course_id'] ;
  $ps_class = $_POST['ps_class'] ;
  $ps_strm = $_POST['ps_strm'] ;
  $ps_class_start_dt = $_POST['ps_class_start_dt'] ;
  $ps_class_end_dt = $_POST['ps_class_end_dt'] ;
  $new_course_id = $_POST['new_course_id'] ;
 
  $sele_course_id = $_POST['sele_course_id'] ;
  $sele_ps_class = $_POST['sele_ps_class'] ;
  $sele_ps_strm = $_POST['sele_ps_strm'] ;
  $sele_ps_class_start_dt = $_POST['sele_ps_class_start_dt'] ;
  $sele_ps_class_end_dt = $_POST['sele_ps_class_end_dt'] ;
  $sele_new_course_id = $_POST['sele_new_course_id'] ;
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
	// List class exception records. 
	//

$where_phrase = (!strlen(trim($course_id)) ? "" : ("ps_course_id LIKE '" . 
				(strcasecmp($sele_course_id, "LIKE") == 0 ? trim($course_id) : '%' . trim($course_id) . '%') . "'")); // Search user_id.
$where_phrase .= (!strlen(trim($ps_class)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" ps_class LIKE '" . 
				(strcasecmp($sele_ps_class, "LIKE") == 0 ? trim($ps_class) : '%' . trim($ps_class) . '%') . "'")));	// Search ps_class.					
$where_phrase .= (!strlen(trim($ps_strm)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" ps_strm LIKE '" . 
				(strcasecmp($sele_ps_strm, "LIKE") == 0 ? trim($ps_strm) : '%' . trim($ps_strm) . '%') . "'")));	// Search ps_strm.			
$where_phrase .= (!strlen(trim($ps_class_start_dt)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" ps_class_start_dt LIKE '" . 
				(strcasecmp($sele_ps_class_start_dt, "LIKE") == 0 ? trim($ps_class_start_dt) : '%' . trim($ps_class_start_dt) . '%') . "'")));	// Search ps_class_start_dt.
$where_phrase .= (!strlen(trim($ps_class_end_dt)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" ps_class_end_dt LIKE '" . 
				(strcasecmp($sele_ps_class_end_dt, "LIKE") == 0 ? trim($ps_class_end_dt) : '%' . trim($ps_class_end_dt) . '%') . "'")));	// Search ps_class_end_dt.

$where_phrase .= (!strlen(trim($new_course_id)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" new_course_id LIKE '" . 
				(strcasecmp($sele_new_course_id, "LIKE") == 0 ? trim($new_course_id) : '%' . trim($new_course_id) . '%') . "'")));	// Search new course ID.

if(!strlen(trim($where_phrase))) {  // If no search criterion has been selected, just show all records.

	$where_phrase = "1";
}
					
  $sql_class_exception = "SELECT ps_course_id, ps_class, ps_strm, ps_class_start_dt, ps_class_end_dt, new_course_id
			FROM class_date_exception 
			WHERE $where_phrase ORDER BY ps_course_id ASC";
				
//	print "*** " . $sql . " ***";		// Debug only.
		
$result_class_exception = $connect->query($sql_class_exception);          

if (empty($result_class_exception) || $result_class_exception->num_rows < 1) {
	print "<p align='center'><b>No record matches your search criteria!</b></p><br>
			<p align='center'><A HREF='javascript:javascript:history.go(-1)'>Search again...</A></p><br>";
} else {

	print '<table width="80%"  border="1" align="center" cellpadding="5" cellspacing="5" 
				style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:center">
			<tr style=" font-weight:bold">
			  <td>Course ID</td>
			  <td>Class ID</td>
			  <td>Semester</td>
			  <td>Start date</td>
			  <td>End date</td>         
			  <td>New course ID</td>         
			</tr>';
	
	while ($record = $result_class_exception->fetch_assoc()) {
													// List the search results...
		print "<tr>  <td>" . $record['ps_course_id'] . "</td>" .
					"<td>" . $record['ps_class'] . "</td>" .
					"<td>" . $record['ps_strm'] . "</td>" .
					"<td>" . $record['ps_class_start_dt'] . "</td>" . 
					"<td>" . $record['ps_class_end_dt'] . "</td>" .
					"<td>" . $record['new_course_id'] . "</td>
					</tr>";
	
	}  // End of while.
	
	$record_count = $result_class_exception->num_rows;
	
	print "</table></p><br><p align='center'>" . $record_count . " record(s) found.</p>";	  
	
	print "<p align='center'><A HREF='javascript:javascript:history.go(-1)'>Search again...</A></p>";
	
	// Clear memory.
	$result_class_exception->free();
	unset($record);
} 		// else

$connect->close();

// Log.
add_to_log(SITEID, "course", "report unitec_info", "report/unitec_info/app_eclass_xception_info.php", "Unitec class enrolment exception info");
// Footer.
echo $OUTPUT->footer();
?>

    