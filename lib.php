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
 * Theme Union Gov.br - Library functions.
 *
 * @package    theme_union_govbr
 * @copyright  2024 Matheus Mathias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Returns the main SCSS content.
 *
 * @param \core\output\theme_config $theme The theme config object.
 * @return string
 */
function theme_union_govbr_get_main_scss_content($theme) {
    global $CFG;

    // Require Boost Union's library.
    require_once($CFG->dirroot . '/theme/boost_union/lib.php');

    // Get the full compiled main SCSS from Boost Union (includes Boost, Bootstrap, FontAwesome, etc.).
    $scss = theme_boost_union_get_main_scss_content(\core\output\theme_config::load('boost_union'));

    // Append post.scss if it exists.
    $postfile = __DIR__ . '/scss/post.scss';
    if (file_exists($postfile)) {
        $scss .= "\n" . file_get_contents($postfile);
    }

    // Append tokens.scss if it exists.
    $tokensfile = __DIR__ . '/scss/tokens.scss';
    if (file_exists($tokensfile)) {
        $scss .= "\n" . file_get_contents($tokensfile);
    }

    // Append main.scss if it exists.
    $mainfile = __DIR__ . '/scss/main.scss';
    if (file_exists($mainfile)) {
        $scss .= "\n" . file_get_contents($mainfile);
    }

    // Append lists.scss if it exists.
    $listsfile = __DIR__ . '/scss/lists.scss';
    if (file_exists($listsfile)) {
        $scss .= "\n" . file_get_contents($listsfile);
    }

    // Append breadcrumb.scss if it exists.
    $breadcrumbfile = __DIR__ . '/scss/breadcrumb.scss';
    if (file_exists($breadcrumbfile)) {
        $scss .= "\n" . file_get_contents($breadcrumbfile);
    }

    // Append buttons.scss if it exists.
    $buttonsfile = __DIR__ . '/scss/buttons.scss';
    if (file_exists($buttonsfile)) {
        $scss .= "\n" . file_get_contents($buttonsfile);
    }

    // Append cards.scss if it exists.
    $cardsfile = __DIR__ . '/scss/cards.scss';
    if (file_exists($cardsfile)) {
        $scss .= "\n" . file_get_contents($cardsfile);
    }

    // Append tables.scss if it exists.
    $tablesfile = __DIR__ . '/scss/tables.scss';
    if (file_exists($tablesfile)) {
        $scss .= "\n" . file_get_contents($tablesfile);
    }

    // Append pagination.scss if it exists.
    $paginationfile = __DIR__ . '/scss/pagination.scss';
    if (file_exists($paginationfile)) {
        $scss .= "\n" . file_get_contents($paginationfile);
    }

    return $scss;
}

/**
 * Get SCSS to prepend (variables and font definitions).
 *
 * @param \core\output\theme_config $theme The theme config object.
 * @return string
 */
function theme_union_govbr_get_pre_scss($theme) {
    global $CFG;

    require_once($CFG->dirroot . '/theme/boost_union/lib.php');

    $scss = '';
    $prefile = __DIR__ . '/scss/pre.scss';
    if (file_exists($prefile)) {
        $scss .= file_get_contents($prefile);
    }
    return $scss;
}

/**
 * Inject additional SCSS after main styles.
 *
 * @param \core\output\theme_config $theme The theme config object.
 * @return string
 */
function theme_union_govbr_get_extra_scss($theme) {
    global $CFG;

    require_once($CFG->dirroot . '/theme/boost_union/lib.php');

    $scss = '';
    return $scss;
}

/**
 * Alter CSS URLs callback for Boost Union compatibility (e.g. flavours).
 *
 * @param mixed $urls The CSS URLs.
 */
function theme_union_govbr_alter_css_urls(&$urls) {
    global $CFG;
    require_once($CFG->dirroot . '/theme/boost_union/lib.php');
    theme_boost_union_alter_css_urls($urls);
}
