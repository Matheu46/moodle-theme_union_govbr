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
 * @copyright  2026 Matheus Mathias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

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

    // Append modals.scss if it exists.
    $modalsfile = __DIR__ . '/scss/modals.scss';
    if (file_exists($modalsfile)) {
        $scss .= "\n" . file_get_contents($modalsfile);
    }

    // Append inputs.scss if it exists.
    $inputsfile = __DIR__ . '/scss/inputs.scss';
    if (file_exists($inputsfile)) {
        $scss .= "\n" . file_get_contents($inputsfile);
    }

    // Append selects.scss if it exists.
    $selectsfile = __DIR__ . '/scss/selects.scss';
    if (file_exists($selectsfile)) {
        $scss .= "\n" . file_get_contents($selectsfile);
    }

    // Append checkboxes.scss if it exists.
    $checkboxesfile = __DIR__ . '/scss/checkboxes.scss';
    if (file_exists($checkboxesfile)) {
        $scss .= "\n" . file_get_contents($checkboxesfile);
    }

    // Append header.scss if it exists.
    $headerfile = __DIR__ . '/scss/header.scss';
    if (file_exists($headerfile)) {
        $scss .= "\n" . file_get_contents($headerfile);
    }

    // Append messages.scss if it exists.
    $messagesfile = __DIR__ . '/scss/messages.scss';
    if (file_exists($messagesfile)) {
        $scss .= "\n" . file_get_contents($messagesfile);
    }

    // Append uploads.scss if it exists.
    $uploadsfile = __DIR__ . '/scss/uploads.scss';
    if (file_exists($uploadsfile)) {
        $scss .= "\n" . file_get_contents($uploadsfile);
    }

    // Append tooltips.scss if it exists.
    $tooltipsfile = __DIR__ . '/scss/tooltips.scss';
    if (file_exists($tooltipsfile)) {
        $scss .= "\n" . file_get_contents($tooltipsfile);
    }

    // Append tags.scss if it exists.
    $tagsfile = __DIR__ . '/scss/tags.scss';
    if (file_exists($tagsfile)) {
        $scss .= "\n" . file_get_contents($tagsfile);
    }

    // Append menu.scss if it exists.
    $menufile = __DIR__ . '/scss/menu.scss';
    if (file_exists($menufile)) {
        $scss .= "\n" . file_get_contents($menufile);
    }

    // Append switches.scss if it exists.
    $switchesfile = __DIR__ . '/scss/switches.scss';
    if (file_exists($switchesfile)) {
        $scss .= "\n" . file_get_contents($switchesfile);
    }

    // Append avatar.scss if it exists.
    $avatarfile = __DIR__ . '/scss/avatar.scss';
    if (file_exists($avatarfile)) {
        $scss .= "\n" . file_get_contents($avatarfile);
    }

    // Append signin.scss if it exists.
    $signinfile = __DIR__ . '/scss/signin.scss';
    if (file_exists($signinfile)) {
        $scss .= "\n" . file_get_contents($signinfile);
    }

    // Append empty_states.scss if it exists.
    $emptystatesfile = __DIR__ . '/scss/empty_states.scss';
    if (file_exists($emptystatesfile)) {
        $scss .= "\n" . file_get_contents($emptystatesfile);
    }

    // Append error_pages.scss if it exists.
    $errorpagesfile = __DIR__ . '/scss/error_pages.scss';
    if (file_exists($errorpagesfile)) {
        $scss .= "\n" . file_get_contents($errorpagesfile);
    }

    // Append barragovbr.scss if it exists.
    $barragovbrfile = __DIR__ . '/scss/barragovbr.scss';
    if (file_exists($barragovbrfile)) {
        $enabled = get_config('theme_union_govbr', 'enablebarragovbr');
        if ($enabled === false || !empty($enabled)) {
            $scss .= "\n" . file_get_contents($barragovbrfile);
        }
    }

    // Append footer.scss if it exists.
    $footerfile = __DIR__ . '/scss/footer.scss';
    if (file_exists($footerfile)) {
        $scss .= "\n" . file_get_contents($footerfile);
    }

    return $scss;
}

/**
 * Serves theme files (e.g. custom signature logo).
 *
 * @param stdClass $course Course object
 * @param stdClass $cm Course module object
 * @param context $context Context object
 * @param string $filearea File area
 * @param array $args Extra arguments
 * @param bool $forcedownload Whether or not to force download
 * @param array $options Additional options affecting the file serving
 * @return bool False if file not found, does not return if found - just exits
 */
function theme_union_govbr_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        send_file_not_found();
    }

    if ($filearea === 'footer_custom_signature_logo' || $filearea === 'footer_logo') {
        $theme = theme_config::load('union_govbr');
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    }

    send_file_not_found();
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
