<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Edit block page
 *
 * @package    block_unitec_teacher_team
 * @copyright  2021 TRL Education Limited {@link https://www.trleducation.co.nz}
 * @copyright  based on work by 2014 GetSmarter {@link http://www.getsmarter.co.za}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * This class adds custom form fields
 */
class block_unitec_teacher_team_edit_form extends block_edit_form {

    /**
     * Add form fields specific to this block
     * @param object $mform the form being built
     */
    protected function specific_definition($mform) {

        $config = get_config('block_unitec_teacher_team');

        // Heading.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));
        
        // Note to users 1.
        $mform->addElement('static', 'config_display_user_note',
            get_string('display_user_note', 'block_unitec_teacher_team'),
            get_string('display_user_note_desc', 'block_unitec_teacher_team'));

        // Title.
        $mform->addElement('text', 'config_title', '');
        $mform->setType('config_title', PARAM_TEXT);
        $mform->setDefault('config_title', get_string('pluginname', 'block_unitec_teacher_team'));
        
        // Note to users 2.
        $mform->addElement('static', 'config_display_settings_all_users',
            get_string('display_settings_all_users', 'block_unitec_teacher_team'),
            get_string('display_settings_all_users_desc', 'block_unitec_teacher_team'));

        // Profile picture.
        $mform->addElement('advcheckbox', 'config_display_profile_picture',
            get_string('display_profile_picture', 'block_unitec_teacher_team'),'','', array(0, 1));
        
        // Phone 1.
        $mform->addElement('advcheckbox', 'config_display_phone1',
            get_string('display_phone1', 'block_unitec_teacher_team'),'','', array(0, 1));
        
        // Phone 2.
        $mform->addElement('advcheckbox', 'config_display_phone2',
            get_string('display_phone2', 'block_unitec_teacher_team'),'','', array(0, 1));

        // Email.
        $mform->addElement('advcheckbox', 'config_display_email',
            get_string('display_email', 'block_unitec_teacher_team'),'','', array(0, 1));        
        
        // Get users
        $users = $this->get_course_users();
        
        // Custom role reminder
        $mform->addElement('static', 'config_display_custom_role_reminder', 
                               get_string('display_custom_role_reminder', 'block_unitec_teacher_team'),
                                get_string('display_custom_role_reminder_desc', 'block_unitec_teacher_team'));

        // User 1.
        $mform->addElement('select', 'config_user_1', get_string('user_1', 'block_unitec_teacher_team'), $users);        
        
        // Custom profile User 1
       $mform->addElement('text', 'config_display_custom_profile_field_user_1',
            get_string('display_custom_profile_field_user_1', 'block_unitec_teacher_team'));
        $mform->setType('config_display_custom_profile_field_user_1', PARAM_TEXT);
        $mform->setDefault('default_custom_profile_field_user_1', 'block_unitec_teacher_team');
        
        // User 2.
        $mform->addElement('select', 'config_user_2', get_string('user_2', 'block_unitec_teacher_team'), $users);        
        
        // Custom profile User 2
       $mform->addElement('text', 'config_display_custom_profile_field_user_2',
            get_string('display_custom_profile_field_user_2', 'block_unitec_teacher_team'));
        $mform->setType('config_display_custom_profile_field_user_2', PARAM_TEXT);
        $mform->setDefault('default_custom_profile_field_user_2', 'block_unitec_teacher_team');        
        
        // User 3.
        $mform->addElement('select', 'config_user_3', get_string('user_3', 'block_unitec_teacher_team'), $users);        
        
        // Custom profile User 3
       $mform->addElement('text', 'config_display_custom_profile_field_user_3',
            get_string('display_custom_profile_field_user_3', 'block_unitec_teacher_team'));
        $mform->setType('config_display_custom_profile_field_user_3', PARAM_TEXT);
        $mform->setDefault('default_custom_profile_field_user_3', 'block_unitec_teacher_team');
        
        // User 4.
        $mform->addElement('select', 'config_user_4', get_string('user_4', 'block_unitec_teacher_team'), $users);        
        
        // Custom profile User 4
       $mform->addElement('text', 'config_display_custom_profile_field_user_4',
            get_string('display_custom_profile_field_user_4', 'block_unitec_teacher_team'));
        $mform->setType('config_display_custom_profile_field_user_4', PARAM_TEXT);
        $mform->setDefault('default_custom_profile_field_user_4', 'block_unitec_teacher_team');
        
        // User 5.
        $mform->addElement('select', 'config_user_5', get_string('user_5', 'block_unitec_teacher_team'), $users);        
        
        // Custom profile User 5
       $mform->addElement('text', 'config_display_custom_profile_field_user_5',
            get_string('display_custom_profile_field_user_5', 'block_unitec_teacher_team'));
        $mform->setType('config_display_custom_profile_field_user_5', PARAM_TEXT);
        $mform->setDefault('default_custom_profile_field_user_5', 'block_unitec_teacher_team');
        
        // User 6.
        $mform->addElement('select', 'config_user_6', get_string('user_6', 'block_unitec_teacher_team'), $users);        
        
        // Custom profile User 6
       $mform->addElement('text', 'config_display_custom_profile_field_user_6',
            get_string('display_custom_profile_field_user_6', 'block_unitec_teacher_team'));
        $mform->setType('config_display_custom_profile_field_user_6', PARAM_TEXT);
        $mform->setDefault('default_custom_profile_field_user_6', 'block_unitec_teacher_team');
        
    }

    /**
     * Returns an array of users in the course formatted for a select box.
     */
    private function get_course_users() {
        global $PAGE;

        $courseid = $PAGE->course->id;
        $context = context_course::instance($courseid);
        $users = get_enrolled_users($context, '', 0, 'u.id, u.firstname, u.lastname', null, 0, 0, true);

        foreach ($users as $key => &$value) {
            $value = $value->firstname . ' ' . $value->lastname;
        }

        $users = array('0' => 'None') + $users;

        return $users;
    }
}
