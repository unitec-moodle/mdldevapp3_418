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
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_classic_var_01
 * @copyright  2018 Bas Brands
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_classic_var_01\output;

use moodle_url;
use custom_menu_item;
use custom_menu;

defined('MOODLE_INTERNAL') || die;

/**
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * Note: This class is required to avoid inheriting Boost's core_renderer,
 *       which removes the edit button required by classic_var_01.
 *
 * @package    theme_classic_var_01
 * @copyright  2018 Bas Brands
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_renderer extends \core_renderer {
    
 /*##################################################################################### 
 ###  Custom renderers to add My Courses and Language Menu to the custom menu - MH  ###
 ######################################################################################*/
     
    protected function render_custom_menu(custom_menu $menu) {
        global $CFG;
        
 /*##################################################################################### 
 ############  Custom renderer to add My Courses to the custom menu - MH  ##############
 ######################################################################################*/   
        
        $mycourses = $this->page->navigation->get('mycourses');
 
        if (isloggedin() && $mycourses && $mycourses->has_children()) {
            $branchlabel = get_string('mycourses', 'theme_classic_var_01');
            $branchurl   = new moodle_url('/course/index.php');
            $branchtitle = $branchlabel;
            $branchsort  = 10000;
 
            $branch = $menu->add($branchlabel, $branchurl, $branchtitle, $branchsort);
 
            foreach ($mycourses->children as $coursenode) {
                $branch->add($coursenode->get_content(), $coursenode->action, $coursenode->get_title());
            }
        }       
 /*###################################################################################
 ############ End Custom renderer to add My Courses to the custom menu  ##############
 #####################################################################################*/ 
        
/*##################################################################################### 
 ##########  Custom renderer to add Language Menu to the custom menu - MH  ############
 ######################################################################################*/
        
        $langs = get_string_manager()->get_list_of_translations();
        $haslangmenu = $this->lang_menu() != '';

        if (!$menu->has_children() && !$haslangmenu) {
            return '';
        }

        if ($haslangmenu) {
            $strlang = get_string('language');
            $currentlang = current_language();
            if (isset($langs[$currentlang])) {
                $currentlang = $langs[$currentlang];
            } else {
                $currentlang = $strlang;
            }
            $this->language = $menu->add($currentlang, new moodle_url('#'), $strlang, 10000);
            foreach ($langs as $langtype => $langname) {
                $this->language->add($langname, new moodle_url($this->page->url, array('lang' => $langtype)), $langname);
            }
        }
        
/*###################################################################################
 ########## End Custom renderer to add Language Menu to the custom menu  ############
 #####################################################################################*/ 

        $content = '';
        foreach ($menu->get_children() as $item) {
            $context = $item->export_for_template($this);
            $content .= $this->render_from_template('core/custom_menu_item', $context);
        }

        return $content;
    }
    
/*###################################################################################
 ### End Custom renderer to add My Courses and Language Menu to the custom menu  ####
 #####################################################################################*/ 

}
