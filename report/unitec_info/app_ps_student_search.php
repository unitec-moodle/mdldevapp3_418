<?php
// unitec_info - A plugin for Moodle to show staff, students and courses information at Unitec.
// It calls external database, peoplesoft, to get all information about Unitec staff info, 
// student enrolment info and course info.
//
// @package    report
// @subpackage unitec_info

// File		   app_ps_student_search.php
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

<form action="app_ps_student_info.php" method="post" > 
  <div align="center">
    <p><br />
      <span class="page_title">PeopleSoft Student Enrolment Search  </span><br />
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
    <td>Date of birth</td>
    <td><div align="center">
      <select name="sele_dob" id="sele_dob" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="dob" type="text" id="dob" size="20" /></td>
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
    <td>Studen ID</td>
    <td><div align="center">
      <select name="sele_student_id" id="sele_student_id" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="student_id" type="text" id="student_id" size="20" /></td>
  </tr>
  <tr>
    <td>PS subject</td>
    <td><div align="center">
      <select name="sele_ps_subject" id="sele_ps_subject" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="ps_subject" type="text" id="ps_subject" size="20" /></td>
  </tr>
  <tr>
    <td>PS category</td>
    <td><div align="center">
      <select name="sele_ps_category" id="sele_ps_category" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="ps_category" type="text" id="ps_category" size="20" /></td>
  </tr>
   <tr>
    <td>Final PS ID</td>
    <td><div align="center">
      <select name="sele_final_ps_id" id="sele_final_ps_id" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="final_ps_id" type="text" id="final_ps_id" size="20" /></td>
  </tr>
  <tr>
    <td>PS class</td>
    <td><div align="center">
      <select name="sele_ps_class" id="sele_ps_class" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="ps_class" type="text" id="ps_class" size="20" /></td>
  </tr>
   <tr>
    <td>Grade<span class="red_text">*</span></td>
    <td><div align="center">
      <select name="sele_crse_grade" id="sele_crse_grade" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="crse_grade" type="text" id="crse_grade" size="20" /></td>
  </tr>
  <tr>
    <td>PS programme</td>
    <td><div align="center">
      <select name="sele_ps_programme" id="sele_ps_programme" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="ps_programme" type="text" id="ps_programme" size="20" /></td>
  </tr>
  <tr>
    <td>Semester code</td>
    <td><div align="center">
      <select name="sele_ps_stream" id="sele_ps_stream" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="ps_stream" type="text" id="ps_stream" size="20" /></td>
  </tr>
  <tr>
    <td>Class start date</td>
    <td><div align="center">
      <select name="sele_ps_class_start_dt" id="sele_ps_class_start_dt" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="ps_class_start_dt" type="text" id="ps_class_start_dt" size="20" /></td>
  </tr>
  <tr>
    <td>Class end date</td>
    <td><div align="center">
      <select name="sele_ps_class_end_dt" id="sele_ps_class_end_dt" >
        <option value="LIKE">likes</option>
        <option value="Contain">contains</option>
      </select>
    </div></td>
    <td><input name="ps_class_end_dt" type="text" id="ps_class_end_dt" size="20" /></td>
  </tr>
    <tr>
     <td colspan="3"><span class="red_text">*</span><span class="comment"> Grade = 0: Normal enrolment; Grade = W: Withdrawn</span></td>
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
add_to_log(SITEID, "course", "report unitec_info", "report/unitec_info/app_ps_student_search.php", "Unitec student info search");

// Footer.
echo $OUTPUT->footer();
?>
