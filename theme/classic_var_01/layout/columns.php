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
 * The columns layout for the classic_var_01 theme.
 *
 * @package   theme_classic_var_01
 * @copyright 2018 Bas Brands
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$bodyattributes = $OUTPUT->body_attributes();
$blockspre = $OUTPUT->blocks('side-pre');
$blockspost = $OUTPUT->blocks('side-post');

$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);

/*###################################################################################
########################      Custom block regions - MH      ########################
#####################################################################################*/

$topfullwidthtml = $OUTPUT->blocks('top-fullwidth');
$hastopfullwidth = $PAGE->blocks->region_has_content('top-fullwidth', $OUTPUT);
$upperfullwidthhtml = $OUTPUT->blocks('upper-fullwidth');
$hasupperfullwidth = $PAGE->blocks->region_has_content('upper-fullwidth', $OUTPUT);
$lowerfullwidthhtml = $OUTPUT->blocks('lower-fullwidth');
$haslowerfullwidth = $PAGE->blocks->region_has_content('lower-fullwidth', $OUTPUT);
$bottomfullwidthhtml = $OUTPUT->blocks('bottom-fullwidth');
$hasbottomfullwidth = $PAGE->blocks->region_has_content('bottom-fullwidth', $OUTPUT);
    
/*###################################################################################
########################      End Custom block regions     ########################
#####################################################################################*/

$PAGE->set_secondary_navigation(false);
$renderer = $PAGE->get_renderer('core');
$header = $PAGE->activityheader;
$headercontent = $header->export_for_template($renderer);

$templatecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'sidepreblocks' => $blockspre,
    'sidepostblocks' => $blockspost,
    'haspreblocks' => $hassidepre,
    'haspostblocks' => $hassidepost,

/*###################################################################################
########################      Custom block regions - MH      ########################
#####################################################################################*/
    
    'topfullwidthblocks' => $topfullwidthtml,
    'hastopfullwidth' => $hastopfullwidth,
    'upperfullwidthblocks' => $upperfullwidthhtml,
    'hasupperfullwidth' => $hasupperfullwidth,
    'lowerfullwidthblocks' => $lowerfullwidthhtml,
    'haslowerfullwidth' => $haslowerfullwidth,
    'bottomfullwidthblocks' => $bottomfullwidthhtml,
    'hasbottomfullwidth' => $hasbottomfullwidth,
    
/*###################################################################################
########################      End Custom block regions     ########################
#####################################################################################*/
    
    'bodyattributes' => $bodyattributes,
    'headercontent' => $headercontent,
];

echo $OUTPUT->render_from_template('theme_classic_var_01/columns', $templatecontext);

