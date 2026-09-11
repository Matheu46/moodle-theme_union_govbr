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
 * Custom core renderer for theme_union_govbr.
 *
 * @package    theme_union_govbr
 * @copyright  2026 Matheus Mathias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_union_govbr\output;

use core_useragent;
use moodle_url;
use Throwable;

defined('MOODLE_INTERNAL') || die();

/**
 * Extending the core_renderer interface for Gov.br DS.
 *
 * @package    theme_union_govbr
 * @copyright  2026 Matheus Mathias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_renderer extends \theme_boost_union\output\core_renderer {

    /**
     * The method that displays fatal error messages following Gov.br DS visual standards.
     *
     * @param string $message The message to output
     * @param moodle_url|string $moreinfourl URL where one may find more info about the error
     * @param moodle_url|string $link A link to continue to
     * @param array $backtrace The stack trace of the error
     * @param string|null $debuginfo More debug information
     * @param string $errorcode The Moodle error code
     * @return string HTML output
     */
    public function fatal_error($message, $moreinfourl, $link, $backtrace, $debuginfo = null, $errorcode = "") {
        global $CFG;

        $output = '';
        $obbuffer = '';

        $errorcategory = $this->categorize_error((string)$errorcode, is_array($backtrace) ? $backtrace : []);

        if ($this->has_started()) {
            // We cannot always recover properly here, pop open containers.
            $output .= $this->opencontainers->pop_all_but_last();
        } else {
            // Clean output buffer before starting page output.
            error_reporting(0);
            while (ob_get_level() > 0) {
                $buff = ob_get_clean();
                if ($buff === false) {
                    break;
                }
                $obbuffer .= $buff;
            }
            error_reporting($CFG->debug);

            // Output HTTP status code headers.
            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
            if (!empty($_SERVER['HTTP_RANGE'])) {
                if (core_useragent::check_safari_ios_version(602) && !empty($_SERVER['HTTP_X_PLAYBACK_SESSION_ID'])) {
                    @header($protocol . ' 403 Forbidden');
                } else {
                    @header($protocol . ' 407 Proxy Authentication Required');
                }
            } else {
                if ($errorcategory === '403') {
                    @header($protocol . ' 403 Forbidden');
                } else if ($errorcategory === '404') {
                    @header($protocol . ' 404 Not Found');
                } else {
                    @header($protocol . ' 500 Internal Server Error');
                }
            }

            $this->page->set_context(null);
            $this->page->set_url('/');
            $this->page->set_title(get_string('error'));
            $this->page->set_heading($this->page->course->fullname);
            $this->page->activityheader->disable();
            $output .= $this->header();
        }

        try {
            $context = $this->export_fatal_error_context(
                $errorcategory,
                $message,
                $moreinfourl,
                $link,
                $backtrace,
                $debuginfo,
                $errorcode,
                $obbuffer
            );
            $output .= $this->render_from_template('theme_union_govbr/fatal_error', $context);
        } catch (Throwable $e) {
            // Fallback to core rendering if template fails, preventing infinite error loops.
            $fallbackmsg = '<p class="errormessage">' . s($message) . '</p>' .
                '<p class="errorcode"><a href="' . s($moreinfourl) . '">' .
                get_string('moreinformation') . '</a></p>';
            if (empty($CFG->rolesactive)) {
                $fallbackmsg .= '<p class="errormessage">' . get_string('installproblem', 'error') . '</p>';
            }
            $output .= $this->box($fallbackmsg, 'errorbox alert alert-danger', null, ['data-rel' => 'fatalerror']);

            if ($CFG->debugdeveloper) {
                $labelsep = get_string('labelsep', 'langconfig');
                if (!empty($debuginfo)) {
                    $debuginfo_clean = s($debuginfo);
                    $debuginfo_clean = str_replace("\n", '<br />', $debuginfo_clean);
                    $label = get_string('debuginfo', 'debug') . $labelsep;
                    $output .= $this->notification("<strong>$label</strong> " . $debuginfo_clean, 'notifytiny');
                }
                if (!empty($backtrace)) {
                    $label = get_string('stacktrace', 'debug') . $labelsep;
                    $output .= $this->notification("<strong>$label</strong> " . format_backtrace($backtrace), 'notifytiny');
                }
                if ($obbuffer !== '') {
                    $label = get_string('outputbuffer', 'debug') . $labelsep;
                    $output .= $this->notification("<strong>$label</strong> " . s($obbuffer), 'notifytiny');
                }
            }

            if (!empty($CFG->rolesactive) && !empty($link)) {
                $output .= $this->continue_button($link);
            }
        }

        $output .= $this->footer();

        // Padding to encourage browsers to display the custom error page.
        $output .= str_repeat(' ', 512);

        return $output;
    }

    /**
     * Categorize an error into '404', '403', or 'general'.
     *
     * Classification is strictly language-agnostic, using Moodle programmatic
     * error codes and PHP exception class names.
     *
     * @param string $errorcode The Moodle programmatic error code
     * @param array $backtrace The backtrace array containing exception details
     * @return string '404', '403', or 'general'
     */
    protected function categorize_error(string $errorcode, array $backtrace = []): string {
        $code = strtolower(trim($errorcode));

        // 1. Check the exception class from the top of the backtrace (language-agnostic).
        if (!empty($backtrace[0]['exception'])) {
            $exceptionclass = strtolower($backtrace[0]['exception']);

            // 403 Forbidden / Access Denied classes.
            if (str_contains($exceptionclass, 'access_denied') ||
                str_contains($exceptionclass, 'required_capability') ||
                str_contains($exceptionclass, 'require_login') ||
                str_contains($exceptionclass, 'restricted_context')) {
                return '403';
            }

            // 404 Not Found / Missing Record classes.
            if (str_contains($exceptionclass, 'not_found') ||
                str_contains($exceptionclass, 'missing_record') ||
                str_contains($exceptionclass, 'file_serving') ||
                str_contains($exceptionclass, 'file_access')) {
                return '404';
            }
        }

        // 2. 403 Forbidden / Unauthorized programmatic error codes.
        $forbidden_codes = [
            'nopermissions',
            'requireloginerror',
            'accessdenied',
            'notenrolled',
            'cannotviewprofile',
            'usernotfullysetup',
            'guestnoeditprofile',
            'guestsnotallowed',
            'loginalready',
            'noguest',
            'mustbeloggedin',
        ];

        if (in_array($code, $forbidden_codes, true)) {
            return '403';
        }

        if (str_starts_with($code, 'nopermission') ||
            str_starts_with($code, 'cannot') ||
            str_starts_with($code, 'notallowed') ||
            str_contains($code, 'accessdenied')) {
            return '403';
        }

        // 3. 404 Not Found / Missing Record programmatic error codes.
        $notfound_codes = [
            'coursenotfound',
            'invalidcourseid',
            'invalidcoursemodule',
            'invalidrecord',
            'invalidrecordunknown',
            'dmlmissingrecordexception',
            'filenotfound',
            'pagenotfound',
            'actionnotfound',
            'activitynotfound',
            'modulenotfound',
            'usernotfound',
            'sectionnotfound',
            'categorynotfound',
            'unknowncourse',
            'unknowncourseidnumber',
            'groupnotfound',
            'cannotfindgroup',
            'itemnotfound',
        ];

        if (in_array($code, $notfound_codes, true)) {
            return '404';
        }

        if (str_contains($code, 'notfound') ||
            str_contains($code, 'missing') ||
            (str_starts_with($code, 'invalid') && (str_contains($code, 'id') || str_contains($code, 'record')))) {
            return '404';
        }

        return 'general';
    }

    /**
     * Export template context for fatal error display.
     *
     * @param string $category '404', '403', or 'general'
     * @param string $message Error message
     * @param moodle_url|string $moreinfourl Link to docs
     * @param moodle_url|string $link Link for continuation
     * @param array $backtrace Stack trace
     * @param string|null $debuginfo Debug info
     * @param string $errorcode Moodle error code
     * @param string $obbuffer Cleaned output buffer
     * @return array
     */
    protected function export_fatal_error_context(
        string $category,
        $message,
        $moreinfourl,
        $link,
        $backtrace,
        $debuginfo,
        $errorcode,
        string $obbuffer
    ): array {
        global $CFG;

        $custommessage = s($message);
        if (empty($CFG->rolesactive)) {
            $custommessage .= ($custommessage !== '' ? ' ' : '') . get_string('installproblem', 'error');
        }

        $context = [
            'errormessage' => $custommessage,
            'homeurl' => (new moodle_url('/'))->out(),
            'homelabel' => get_string('error_btn_home', 'theme_union_govbr'),
            'backlabel' => get_string('error_btn_back', 'theme_union_govbr'),
            'continuelink' => (!empty($link) && !empty($CFG->rolesactive)) ? (string)$link : null,
            'hasdebug' => !empty($CFG->debugdeveloper),
        ];

        if ($category === '404') {
            $context['illustrationurl'] = $this->image_url('illustrations/error/404', 'theme')->out();
            $context['badgeclass'] = 'badge-govbr-404';
            $context['errorbadge'] = get_string('error_404_badge', 'theme_union_govbr');
            $context['errortitle'] = get_string('error_404_title', 'theme_union_govbr');
            $context['errordescription'] = get_string('error_404_description', 'theme_union_govbr');
        } else if ($category === '403') {
            $context['illustrationurl'] = $this->image_url('illustrations/error/403', 'theme')->out();
            $context['badgeclass'] = 'badge-govbr-403';
            $context['errorbadge'] = get_string('error_403_badge', 'theme_union_govbr');
            $context['errortitle'] = get_string('error_403_title', 'theme_union_govbr');
            $context['errordescription'] = get_string('error_403_description', 'theme_union_govbr');

            // If user is not logged in or is guest, offer login button.
            if (!isloggedin() || isguestuser()) {
                $context['loginurl'] = get_login_url();
                $context['loginlabel'] = get_string('error_btn_login', 'theme_union_govbr');
            }
        } else {
            $context['illustrationurl'] = $this->image_url('illustrations/error/general_error', 'theme')->out();
            $context['badgeclass'] = 'badge-govbr-error';
            $context['errorbadge'] = get_string('error_general_badge', 'theme_union_govbr');
            $context['errortitle'] = get_string('error_general_title', 'theme_union_govbr');
            $context['errordescription'] = get_string('error_general_description', 'theme_union_govbr');
        }

        if (!empty($CFG->debugdeveloper)) {
            $context['debugdata'] = [
                'errorcode' => !empty($errorcode) ? (string)$errorcode : null,
                'moreinfourl' => !empty($moreinfourl) ? (string)$moreinfourl : null,
                'debuginfo' => !empty($debuginfo) ? s($debuginfo) : null,
                'backtrace' => !empty($backtrace) ? format_backtrace($backtrace) : null,
                'obbuffer' => $obbuffer !== '' ? $obbuffer : null,
            ];
        }

        return $context;
    }
}

