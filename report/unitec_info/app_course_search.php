<?php
// unitec_info - A plugin for Moodle to show staff, students and courses information at Unitec.
// It calls external database, peoplesoft, to get all information about Unitec staff info, 
// student enrolment info and course info.
//
// @package    report
// @subpackage unitec_info

// File		   app_course_search.php
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

<form action="app_course_info.php" method="post" > 
  <div align="center">
    <p><br />
      <span class="page_title">Unitec Course Info Search  </span><br />
      <br />
    </p>
  </div>
  <table border="2" align="center" cellpadding="5" cellspacing="5" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px" >

  <tr>
    <td width="110">Subject</td>
    <td width="115">
        <div align="center">
          <select name="sele_subject" id="sele_subject" style="text-align:center">
            <option value="LIKE">is</option>
            <option value="Contain">contains</option>
          </select>
        </div></td>
    <td width="164"><input name="subject" type="text" id="subject" size="20" /></td>
  </tr>
  <tr>
    <td>Category</td>
    <td><div align="center">
      <select name="sele_category" id="sele_category" style="text-align:center">
        <option value="LIKE">is</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="category" type="text" id="category" size="20" /></td>
  </tr>
  <tr>
    <td>Class number</td>
    <td><div align="center">
      <select name="sele_class_number" id="sele_class_number" style="text-align:center">
        <option value="LIKE">is</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="class_number" type="text" id="class_number" size="20" /></td>
  </tr>
  <tr>
    <td>Name</td>
    <td><div align="center">
      <select name="sele_name" id="sele_name" style="text-align:center">
        <option value="LIKE">is</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="name" type="text" id="name" size="20" /></td>
  </tr>
  <tr>
    <td>Description</td>
    <td><div align="center">
      <select name="sele_description" id="sele_description" style="text-align:center">
        <option value="LIKE">is</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="description" type="text" id="description" size="20" /></td>
  </tr>
  <tr>
    <td>Faculty code</td>
    <td><div align="center">
      <select name="sele_faculty_code" id="sele_faculty_code" style="text-align:center">
        <option value="LIKE">is</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="faculty_code" type="text" id="faculty_code" size="20" /></td>
  </tr>
  <tr>
    <td>Department code</td>
    <td><div align="center">
      <select name="sele_department_code" id="sele_department_code" style="text-align:center">
        <option value="LIKE">is</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="department_code" type="text" id="department_code" size="20" /></td>
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
add_to_log(SITEID, "course", "report unitec_info", "report/unitec_info/app_course_search.php", "Unitec courses info search");

// Footer.
echo $OUTPUT->footer();
?>
