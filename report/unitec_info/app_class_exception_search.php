<?php
// unitec_info - A plugin for Moodle to show staff, students and courses information at Unitec.
// It calls external database, peoplesoft, to get all information about Unitec staff info, 
// student enrolment info and course info.
//
// @package    report
// @subpackage unitec_info

// File		   app_class_exception_search.php
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

<form action="app_class_exception_info.php" method="post" > 
  <div align="center">
    <p><br />
      <span class="page_title">Class Exception Search</span><br />
      <br />
    </p>
  </div>
  <table border="2" align="center" cellpadding="5" cellspacing="5" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px" >

  <tr>
    <td width="110">PeopleSoft ID</td>
    <td width="115">
        <div align="center">
          <select name="sele_course_id" id="sele_course_id" >
            <option value="LIKE">likes</option>
            <option value="Contain">contains</option>
          </select>
        </div>
    </td>
    <td width="164"><input name="course_id" type="text" id="course_id" size="20" /></td>
  </tr>
   <tr>
     <td>Class ID</td>
     <td><div align="center">
       <select name="sele_ps_class" id="sele_ps_class" >
         <option value="LIKE">likes</option>
         <option value="Contain">contains</option>
         </select>
      </div></td>
     <td><input name="ps_class" type="text" id="ps_class" size="20" /></td>
   </tr>
   <tr>
     <td>Semester code</td>
     <td><div align="center">
       <select name="sele_ps_strm" id="sele_ps_strm" >
         <option value="LIKE">likes</option>
         <option value="Contain">contains</option>
         </select>
      </div></td>
     <td><input name="ps_strm" type="text" id="ps_strm" size="20" /></td>
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
     <td>Moodle course ID</td>
     <td><div align="center">
       <select name="sele_new_course_id" id="sele_new_course_id" >
         <option value="LIKE">likes</option>
         <option value="Contain">contains</option>
       </select>
     </div></td>
     <td><input name="new_course_id" type="text" id="new_course_id" size="20" /></td>
   </tr>
   <tr>
    <td height="33" colspan="3" align="center">
   	  <input type="submit" value="Submit" name="submit" />
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      <input type="reset" name="Reset" value="Reset" />    </td>
    </tr>
</table>
  <p align="center">&nbsp;</p>
</form>


<?php
// Log.
add_to_log(SITEID, "course", "report unitec_info", "report/unitec_info/app_class_exception_search.php", "Unitec class enrolment exception search");

// Footer.
echo $OUTPUT->footer();
?>
