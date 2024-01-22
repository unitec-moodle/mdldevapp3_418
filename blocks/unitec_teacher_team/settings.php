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
 * Default settings page
 *
 * @package    block_unitec_teacher_team
 * @copyright  2021 TRL Education Limited {@link https://www.trleducation.co.nz}
 * @copyright  based on work by 2014 GetSmarter {@link http://www.getsmarter.co.za}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

   // Default settings heading.
    $name = 'block_unitec_teacher_team/default_settings_heading';
    $title = get_string('default_settings_heading', 'block_unitec_teacher_team');
    $description = get_string('default_settings_heading_desc', 'block_unitec_teacher_team');
    $setting = new admin_setting_heading($name, $title, $description, FORMAT_MARKDOWN);
    $settings->add($setting);
    
}
