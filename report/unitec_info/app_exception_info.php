<?php
// unitec_info - A plugin for Moodle to show staff, students and courses information at Unitec.
// It calls external database, peoplesoft, to get all information about Unitec staff info, 
// student enrolment info and course info.
//
// @package    report
// @subpackage unitec_info

// File		   app_exception_info.php
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
    <span class="page_title">Student Exception Info</span><br /><br />
<?php

// Get the form inquiry

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {

  $user_id = $_POST['user_id'] ;
  $lastname = $_POST['lastname'] ;  
  $firstname = $_POST['firstname'] ;
  $email = $_POST['email'] ;  
  $dob = $_POST['dob'] ;


  $ps_subject = $_POST['ps_subject'] ;
  $ps_cat = $_POST['ps_cat'] ;
  $student_id = $_POST['student_id'] ;
  $ps_class = $_POST['ps_class'] ;
  $visa_nsi = $_POST['visa_nsi'] ;
  
  $ps_prog = $_POST['ps_prog'] ;
  $ps_strm = $_POST['ps_strm'] ;
  $ps_class_start_dt = $_POST['ps_class_start_dt'] ;
  $ps_class_end_dt = $_POST['ps_class_end_dt'] ;
 
  $sele_user_id = $_POST['sele_user_id'] ;
  $sele_lastname = $_POST['sele_lastname'] ;  
  $sele_firstname = $_POST['sele_firstname'] ;
  $sele_email = $_POST['sele_email'] ;  
  $sele_dob = $_POST['sele_dob'] ;


  $sele_ps_subject = $_POST['sele_ps_subject'] ;
  $sele_ps_cat = $_POST['sele_ps_cat'] ;
  $sele_student_id = $_POST['sele_student_id'] ;
  $sele_ps_class = $_POST['sele_ps_class'] ;
  $sele_visa_nsi = $_POST['sele_visa_nsi'] ;
  
  $sele_ps_prog = $_POST['sele_ps_prog'] ;
  $sele_ps_strm = $_POST['sele_ps_strm'] ;
  $sele_ps_class_start_dt = $_POST['sele_ps_class_start_dt'] ;
  $sele_ps_class_end_dt = $_POST['sele_ps_class_end_dt'] ;
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
// List student exception records 
//

$where_phrase = (!strlen(trim($user_id)) ? "" : ("user_id LIKE '" . 
				(strcasecmp($sele_user_id, "LIKE") == 0 ? trim($user_id) : '%' . trim($user_id) . '%') . "'")); // Search user_id
$where_phrase .= (!strlen(trim($lastname)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" lastname LIKE '" . 
				(strcasecmp($sele_lastname, "LIKE") == 0 ? trim($lastname) : '%' . trim($lastname) . '%') . "'")));	// Search lastname	
$where_phrase .= (!strlen(trim($firstname)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" firstname LIKE '" . 
				(strcasecmp($sele_firstname, "LIKE") == 0 ? trim($firstname) : '%' . trim($firstname) . '%') . "'")));	// Search firstname
$where_phrase .= (!strlen(trim($email)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" email LIKE '" . 
				(strcasecmp($sele_email, "LIKE") == 0 ? trim($email) : '%' . trim($email) . '%') . "'")));	// Search email
				
$where_phrase .= (!strlen(trim($dob)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" dob LIKE '" . 
				(strcasecmp($sele_dob, "LIKE") == 0 ? trim($dob) : '%' . trim($dob) . '%') . "'")));	// Search dob					
$where_phrase .= (!strlen(trim($ps_subject)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" ps_subject LIKE '" . 
				(strcasecmp($sele_ps_subject, "LIKE") == 0 ? trim($ps_subject) : '%' . trim($ps_subject) . '%') . "'")));	// Search ps_subject
$where_phrase .= (!strlen(trim($ps_cat)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" ps_cat LIKE '" . 
				(strcasecmp($sele_ps_cat, "LIKE") == 0 ? trim($ps_cat) : '%' . trim($ps_cat) . '%') . "'")));	// Search ps_cat
$where_phrase .= (!strlen(trim($student_id)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" student_id LIKE '" . 
				(strcasecmp($sele_student_id, "LIKE") == 0 ? trim($student_id) : '%' . trim($student_id) . '%') . "'")));	// Search student_id
				
$where_phrase .= (!strlen(trim($ps_class)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" ps_class LIKE '" . 
				(strcasecmp($sele_ps_class, "LIKE") == 0 ? trim($ps_class) : '%' . trim($ps_class) . '%') . "'")));	// Search ps_class					
$where_phrase .= (!strlen(trim($visa_nsi)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" visa_nsi LIKE '" . 
				(strcasecmp($sele_visa_nsi, "LIKE") == 0 ? trim($visa_nsi) : '%' . trim($visa_nsi) . '%') . "'")));	// Search visa_nsi					
$where_phrase .= (!strlen(trim($ps_prog)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" ps_prog LIKE '" . 
				(strcasecmp($sele_ps_prog, "LIKE") == 0 ? trim($ps_prog) : '%' . trim($ps_prog) . '%') . "'")));	// Search ps_prog					
$where_phrase .= (!strlen(trim($ps_strm)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" ps_strm LIKE '" . 
				(strcasecmp($sele_ps_strm, "LIKE") == 0 ? trim($ps_strm) : '%' . trim($ps_strm) . '%') . "'")));	// Search ps_strm					
$where_phrase .= (!strlen(trim($ps_class_start_dt)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" ps_class_start_dt LIKE '" . 
				(strcasecmp($sele_ps_class_start_dt, "LIKE") == 0 ? trim($ps_class_start_dt) : '%' . trim($ps_class_start_dt) . '%') . "'")));	// Search ps_class_start_dt
$where_phrase .= (!strlen(trim($ps_class_end_dt)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" ps_class_end_dt LIKE '" . 
				(strcasecmp($sele_ps_class_end_dt, "LIKE") == 0 ? trim($ps_class_end_dt) : '%' . trim($ps_class_end_dt) . '%') . "'")));	// Search ps_class_end_dt


if(!strlen(trim($where_phrase))) {  // If no search criterion has been selected, just show all records.
	$where_phrase = "1";
}
					
$sql_student_exception = "SELECT user_id, lastname, firstname, email, dob, ps_subject, ps_cat, student_id, ps_class, visa_nsi, ps_prog, ps_strm, ps_class_start_dt, ps_class_end_dt
			FROM exception_list 
			WHERE $where_phrase ORDER BY user_id ASC";
// echo 	$sql_student_exception; // degug obly.		
$result_student_exception = $connect->query($sql_student_exception);          

if (empty($result_student_exception) || $result_student_exception->num_rows < 1) {
	print "<p align='center'><b>No record matches your search criteria!</b></p><br>
			<p align='center'><A HREF='javascript:javascript:history.go(-1)'>Search again...</A></p><br>";
} else {

	print '<table width="80%"  border="1" align="center" cellpadding="5" cellspacing="5" 
			style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:center">
		<tr style=" font-weight:bold">
		  <td>User name</td>
		  <td>Last name</td>
		  <td>First name</td>
		  <td>Email</td>
		  <td>DOB</td>
		  <td>Subject</td>
		  <td>Category</td>
		  <td>Student ID</td>
		  <td>Class</td>
		  <td>NSI</td>
		  <td>Prog ID</td>
		  <td>Semester</td>
		  <td>start date</td>
		  <td>end date</td>         
		</tr>';	  
	while ($record = $result_student_exception->fetch_assoc()) {
														// List the search results...
			print "<tr>  <td>" . $record['user_id'] . "</td>" .
						"<td>" . $record['lastname'] . "</td>" .
						"<td>" . $record['firstname'] . "</td>" .			  
						"<td>" . $record['email'] . "</td>" .
						"<td>" . $record['dob'] . "</td>" .
						"<td>" . $record['ps_subject'] . "</td>" . 
						"<td>" . $record['ps_cat'] . "</td>" .
						"<td>" . $record['student_id'] . "</td>" .
						"<td>" . $record['ps_class'] . "</td>" .
						"<td>" . $record['visa_nsi'] . "</td>" .
						"<td>" . $record['ps_prog'] . "</td>" .
						"<td>" . $record['ps_strm'] . "</td>" .
						"<td>" . $record['ps_class_start_dt'] . "</td>" . 
						"<td>" . $record['ps_class_end_dt'] . "</td></tr>";
	
		}  // End of while.
		
	$record_count = $result_student_exception->num_rows;
		
		print "</table></p><br><p align='center'>" . $record_count . " record(s) found.</p>";	  
	  
	  if ($record_count == 0){ 
								// No result found.
		print '<tr><td colspan="2" class="tableCell"><p align="center"> <b>No record matches your search criteria.</b></p></td></tr></table>';
	  } 
	
	print "<p align='center'><A HREF='javascript:javascript:history.go(-1)'>Search again...</A></p>";
}
// Clear memory.
if (!empty($result_student_exception)) $result_student_exception->free();
unset($record);
$connect->close();

// Log.
add_to_log(SITEID, "course", "report unitec_info", "report/unitec_info/app_exception_info.php", "Unitec enrolment exception info");

// Footer.
echo $OUTPUT->footer();
?>

    