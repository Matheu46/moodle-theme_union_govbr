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
 * Theme config for Union Gov.br.
 *
 * @package    theme_union_govbr
 * @copyright  2024 Matheus Mathias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Inherit the whole theme config from Boost Union (layouts, regions, etc.).
require_once($CFG->dirroot . '/theme/boost_union/config.php');

// Require own locallib.php.
require_once($CFG->dirroot . '/theme/union_govbr/locallib.php');

// Overwrite only the settings which differ for Union Gov.br.
$THEME->name = 'union_govbr';
$THEME->scss = function ($theme) {
    return theme_union_govbr_get_main_scss_content($theme);
};
$THEME->parents = ['boost_union', 'boost'];
$THEME->extrascsscallback = 'theme_union_govbr_get_extra_scss';
$THEME->prescsscallback = 'theme_union_govbr_get_pre_scss';

$THEME->rendererfactory = 'theme_overridden_renderer_factory';

// Replicate essential settings from Boost Union at runtime.
$unaddableblocks = get_config('theme_boost_union', 'unaddableblocks');
if (!empty($unaddableblocks)) {
    $THEME->settings->unaddableblocks = $unaddableblocks;
}
unset($unaddableblocks);

$scss = get_config('theme_boost_union', 'scss');
if (!empty($scss)) {
    $THEME->settings->scss = $scss;
}
unset($scss);

$scsspre = get_config('theme_boost_union', 'scsspre');
if (!empty($scsspre)) {
    $THEME->settings->scsspre = $scsspre;
}
unset($scsspre);
