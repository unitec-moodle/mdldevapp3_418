<?php
// unitec_info - A plugin for Moodle to show staff, students and courses information at Unitec.
// It calls external database, peoplesoft, to get all information about Unitec staff info, 
// student enrolment info and course info.
//
// @package    report
// @subpackage unitec_info

// File		   app_staff_search.php
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

?>
<link href="layout.css" rel="stylesheet" type="text/css" />

<form action="app_staff_info.php" method="post" > 
  <div align="center">
    <p><br />
      <span class="page_title">Unitec Staff Info Search  </span><br />
      <br />
    </p>
  </div>
  <table border="2" align="center" cellpadding="5" cellspacing="5" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px" >

  <tr>
    <td width="110">User name</td>
    <td width="115">
        <div align="center">
          <select name="sele_user_id" id="sele_user_id" >
            <option value="LIKE">likes</option>
            <option value="Contain">contains</option>
          </select>
        </div></td>
    <td width="164"><input name="user_id" type="text" id="user_id" size="20" /></td>
  </tr>
  <tr>
    <td>First name</td>
    <td><div align="center">
      <select name="sele_firstname" id="sele_firstname" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="firstname" type="text" id="firstname" size="20" /></td>
  </tr>
  <tr>
    <td>Middle name</td>
    <td><div align="center">
      <select name="sele_middlename" id="sele_middlename" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="middlename" type="text" id="middlename" size="20" /></td>
  </tr>
  <tr>
    <td>Last name</td>
    <td><div align="center">
      <select name="sele_lastname" id="sele_lastname" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="lastname" type="text" id="lastname" size="20" /></td>
  </tr>
  <tr>
    <td>Email</td>
    <td><div align="center">
      <select name="sele_email" id="sele_email" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="email" type="text" id="email" size="20" /></td>
  </tr>
  <tr>
    <td>Department</td>
    <td><div align="center">
      <select name="sele_department" id="sele_department" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="department" type="text" id="department" size="20" /></td>
  </tr>
  <tr>
    <td>Staff ID</td>
    <td><div align="center">
      <select name="sele_empl_id" id="sele_empl_id" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="empl_id" type="text" id="empl_id" size="20" /></td>
  </tr>
  <tr>
    <td>Profile</td>
    <td><div align="center">
      <select name="sele_profile" id="sele_profile" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="profile" type="text" id="profile" size="20" /></td>
  </tr>
    <tr>
    <td height="33" colspan="3" align="center">
   	  <input type="submit" value="Submit" name="submit" />
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      <input type="reset" name="Reset" value="Reset" />    </td>
    </tr>
</table>
</form>


<?php
// Log.
add_to_log(SITEID, "course", "report unitec_info", "report/unitec_info/app_staff_search.php", "Unitec staff search");

// Footer.
echo $OUTPUT->footer();
?>
