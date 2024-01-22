<?php
// unitec_info - A plugin for Moodle to show staff, students and courses information at Unitec.
// It calls external database, peoplesoft, to get all information about Unitec staff info, 
// student enrolment info and course info.
//
// @package    report
// @subpackage unitec_info

// File		   app_staff_info.php
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
    <span class="page_title">Unitec Staff Info</span><br /><br />
<?php

// Get the form inquiry

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {

  $user_id = $_POST['user_id'] ;
  $firstname = $_POST['firstname'] ;
  $middlename = $_POST['middlename'] ;
  $lastname = $_POST['lastname'] ;
  $email = $_POST['email'] ;
  $department = $_POST['department'] ;
  $empl_id = $_POST['empl_id'] ;
  $profile = $_POST['profile'] ;
  
  $sele_user_id = $_POST['sele_user_id'] ;
  $sele_firstname = $_POST['sele_firstname'] ;
  $sele_middlename = $_POST['sele_middlename'] ;
  $sele_lastname = $_POST['sele_lastname'] ;
  $sele_email = $_POST['sele_email'] ;
  $sele_department = $_POST['sele_department'] ;
  $sele_empl_id = $_POST['sele_empl_id'] ;
  $sele_profile = $_POST['sele_profile'] ;  
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

$where_phrase = (!strlen(trim($user_id)) ? "" : ("user_id LIKE '" . 
				(strcasecmp($sele_user_id, "LIKE") == 0 ? $user_id : '%' . $user_id . '%') . "'")); // Search user_id
$where_phrase .= (!strlen(trim($firstname)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" firstname LIKE '" . 
				(strcasecmp($sele_firstname, "LIKE") == 0 ? $firstname : '%' . $firstname . '%') . "'")));	// Search firstname
$where_phrase .= (!strlen(trim($middlename)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" middlename LIKE '" . 
				(strcasecmp($sele_middlename, "LIKE") == 0 ? $middlename : '%' . $middlename . '%') . "'")));	// Search middlename
$where_phrase .= (!strlen(trim($lastname)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" lastname LIKE '" . 
				(strcasecmp($sele_lastname, "LIKE") == 0 ? $lastname : '%' . $lastname . '%') . "'")));	// Search lastname
$where_phrase .= (!strlen(trim($email)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" email LIKE '" . 
				(strcasecmp($sele_email, "LIKE") == 0 ? $email : '%' . $email . '%') . "'")));	// Search email
$where_phrase .= (!strlen(trim($department)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" department LIKE '" . 
				(strcasecmp($sele_department, "LIKE") == 0 ? $department : '%' . $department . '%') . "'")));	// Search department
$where_phrase .= (!strlen(trim($empl_id)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" empl_id LIKE '" . 
				(strcasecmp($sele_empl_id, "LIKE") == 0 ? $empl_id : '%' . $empl_id . '%') . "'")));	// Search empl_id
$where_phrase .= (!strlen(trim($profile)) ? "" : ((!strlen($where_phrase) ? "" : " AND") . (" profile LIKE '" . 
				(strcasecmp($sele_profile, "LIKE") == 0 ? $profile : '%' . $profile . '%') . "'")));	// Search profile
				
if(!strlen(trim($where_phrase))) {  // If no search criterion has been selected, just tell them nothing has been selected.

	print "</table></p><br><p align='center'><b>You haven't selected any search criterion.</b></p></td></tr>";
	
} else {  // else 1
	$sql_staff_info = "SELECT user_id, firstname, middlename, lastname, email, department, empl_id, profile 
				FROM bb_staff 
				WHERE " . $where_phrase;
				
	$result_staff_info = $connect->query($sql_staff_info);          
	
	if (empty($result_staff_info) || $result_staff_info->num_rows < 1) { // No result found.
		print "\n<p align='center'><b>No record matches your search criteria!</b></p><br>\n";
	} else {  // else 2
				// Has result. Then display it.
		print '<table width="80%"  border="1" align="center" cellpadding="5" cellspacing="5" 
					style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; text-align:center">
				<tr style=" font-weight:bold">
				  <td>User name</td>
				  <td>First name</td>
				  <td>Middle name</td>
				  <td>Last name</td>
				  <td>Email</td>
				  <td>Department</td>
				  <td>Staff ID</td>
				  <td>Profile</td>
				</tr>';
			  
		while ($record = $result_staff_info->fetch_assoc()) {
														// List the search results...
			print "<tr>  <td>" . $record['user_id'] . "</td>" .
						"<td>" . $record['firstname'] . "</td>" .
						"<td>" . $record['middlename'] . "</td>" .
						"<td>" . $record['lastname'] . "</td>" .  
						"<td>" . $record['email'] . "</td>" .
						"<td>" . $record['department'] . "</td>" .
						"<td>" . $record['empl_id'] . "</td>" .  
						"<td>" . $record['profile'] . "</td></tr>";
	
		}  // End of while.
		
		print "</table></p><br>";	  
		print "<p align='center'>" . $result_staff_info->num_rows. " record(s) found.</p>";	  

	}   // else 2
			// Clear the memory.
		$result_staff_info->free();
		unset($record);
}  // else 1

$connect->close();

print "<p align='center'><A HREF='javascript:javascript:history.go(-1)'>Search again...</A></p>";
	

// Log.
add_to_log(SITEID, "course", "report unitec_info", "report/unitec_info/app_staff_info.php", "Unitec staff info");

// Footer.
echo $OUTPUT->footer();
?>

    