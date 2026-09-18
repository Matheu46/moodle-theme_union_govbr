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
                    $debuginfoclean = s($debuginfo);
                    $debuginfoclean = str_replace("\n", '<br />', $debuginfoclean);
                    $label = get_string('debuginfo', 'debug') . $labelsep;
                    $output .= $this->notification("<strong>$label</strong> " . $debuginfoclean, 'notifytiny');
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
            if (
                str_contains($exceptionclass, 'access_denied') ||
                str_contains($exceptionclass, 'required_capability') ||
                str_contains($exceptionclass, 'require_login') ||
                str_contains($exceptionclass, 'restricted_context')
            ) {
                return '403';
            }

            // 404 Not Found / Missing Record classes.
            if (
                str_contains($exceptionclass, 'not_found') ||
                str_contains($exceptionclass, 'missing_record') ||
                str_contains($exceptionclass, 'file_serving') ||
                str_contains($exceptionclass, 'file_access')
            ) {
                return '404';
            }
        }

        // 2. 403 Forbidden / Unauthorized programmatic error codes.
        $forbiddencodes = [
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

        if (in_array($code, $forbiddencodes, true)) {
            return '403';
        }

        if (
            str_starts_with($code, 'nopermission') ||
            str_starts_with($code, 'cannot') ||
            str_starts_with($code, 'notallowed') ||
            str_contains($code, 'accessdenied')
        ) {
            return '403';
        }

        // 3. 404 Not Found / Missing Record programmatic error codes.
        $notfoundcodes = [
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

        if (in_array($code, $notfoundcodes, true)) {
            return '404';
        }

        if (
            str_contains($code, 'notfound') ||
            str_contains($code, 'missing') ||
            (str_starts_with($code, 'invalid') && (str_contains($code, 'id') || str_contains($code, 'record')))
        ) {
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

    /**
     * Get the URLs for the custom signature logos if uploaded.
     *
     * @return array
     */
    public function footer_signature_custom_urls(): array {
        $urls = [];
        $syscontext = \context_system::instance();
        $fs = get_file_storage();

        $files = $fs->get_area_files(
            $syscontext->id,
            'theme_union_govbr',
            'footer_custom_signature_logo',
            0,
            'sortorder, itemid, filepath, filename',
            false
        );

        foreach ($files as $file) {
            $url = \moodle_url::make_pluginfile_url(
                $syscontext->id,
                'theme_union_govbr',
                'footer_custom_signature_logo',
                0,
                $file->get_filepath(),
                $file->get_filename()
            );
            $urls[] = ['url' => $url->out()];
        }

        return $urls;
    }

    /**
     * Whether a custom institutional signature should be shown.
     *
     * @return bool
     */
    public function footer_has_signature(): bool {
        return !empty($this->footer_signature_custom_urls());
    }

    /**
     * Return the standard string that says whether you are logged in (etc).
     * We override this to inject the Barra Gov.br at the very top of the body.
     *
     * @return string HTML fragment.
     */
    public function standard_top_of_body_html() {
        $html = parent::standard_top_of_body_html();

        $enabled = get_config('theme_union_govbr', 'enablebarragovbr');
        if ($enabled === false || !empty($enabled)) {
            $headersign = get_config('theme_union_govbr', 'govbr_header_sign');
            if ($headersign === false) {
                $headersign = 'Governo Federal';
            }
            $headersign = trim((string)$headersign);

            $context = [
                'brasil_logo_url' => $this->image_url('brasil_logo', 'theme_union_govbr')->out(),
                'govbr_header_sign' => $headersign,
                'has_govbr_header_sign' => !empty($headersign),
            ];
            $html = $this->render_from_template('theme_union_govbr/barragovbr', $context) . $html;
        }

        return $html;
    }

    /**
     * Get institutional footer title.
     *
     * @return string
     */
    public function footer_title(): string {
        global $SITE;
        $title = get_config('theme_union_govbr', 'footer_title');
        return !empty($title) ? format_string($title) : format_string($SITE->fullname);
    }

    /**
     * Get the footer background class (e.g. inverted for light mode).
     *
     * @return string
     */
    public function footer_background_class(): string {
        $setting = get_config('theme_union_govbr', 'footer_background');
        return ($setting === 'light') ? 'inverted' : '';
    }

    public function footer_has_custom_logo(): bool {
        return !empty($this->get_logo_url());
    }

    /**
     * URL of the custom site logo if configured.
     *
     * @return string|null
     */
    public function footer_custom_logo_url(): ?string {
        $logo = $this->get_logo_url();
        return $logo ? $logo->out() : null;
    }

    /**
     * Whether footer navigation categories should be displayed.
     *
     * @return bool
     */
    public function footer_show_categories(): bool {
        $setting = get_config('theme_union_govbr', 'footer_show_categories');
        return ($setting === false) ? true : (bool)$setting;
    }

    /**
     * Whether social media icons section should be displayed.
     *
     * @return bool
     */
    public function footer_show_social(): bool {
        $setting = get_config('theme_union_govbr', 'footer_show_social');
        return ($setting === false) ? true : (bool)$setting;
    }

    /**
     * Whether social networks block should be shown (must be enabled AND have networks).
     *
     * @return bool
     */
    public function footer_has_social(): bool {
        return $this->footer_show_social() && !empty($this->footer_social_networks());
    }

    /**
     * Get active social media networks list for the footer.
     *
     * @return array
     */
    public function footer_social_networks(): array {
        $networks = [
            'twitter' => [
                'name' => 'X (Twitter)',
                'icon' => 'fa-brands fa-x-twitter',
                'default' => 'https://twitter.com/govbr',
            ],
            'youtube' => [
                'name' => 'YouTube',
                'icon' => 'fa-brands fa-youtube',
                'default' => 'https://youtube.com/governodobrasil',
            ],
            'facebook' => [
                'name' => 'Facebook',
                'icon' => 'fa-brands fa-facebook-f',
                'default' => 'https://facebook.com/governodobrasil',
            ],
            'instagram' => [
                'name' => 'Instagram',
                'icon' => 'fa-brands fa-instagram',
                'default' => 'https://instagram.com/governodobrasil',
            ],
            'linkedin' => ['name' => 'LinkedIn', 'icon' => 'fa-brands fa-linkedin-in', 'default' => ''],
            'tiktok' => ['name' => 'TikTok', 'icon' => 'fa-brands fa-tiktok', 'default' => ''],
            'whatsapp' => ['name' => 'WhatsApp', 'icon' => 'fa-brands fa-whatsapp', 'default' => ''],
        ];

        $results = [];

        foreach ($networks as $key => $net) {
            $url = get_config('theme_union_govbr', 'footer_social_' . $key);
            if (!empty($url)) {
                $results[] = [
                    'key' => $key,
                    'name' => $net['name'],
                    'icon' => $net['icon'],
                    'url' => s($url),
                ];
            }
        }

        return $results;
    }

    /**
     * Whether content license text should be displayed.
     *
     * @return bool
     */
    public function footer_show_license(): bool {
        $setting = get_config('theme_union_govbr', 'footer_show_license');
        return ($setting === false) ? true : (bool)$setting;
    }

    /**
     * Get content license text.
     *
     * @return string
     */
    public function footer_license_text(): string {
        $custom = get_config('theme_union_govbr', 'footer_license_custom');
        if (!empty($custom)) {
            return format_text($custom, FORMAT_HTML);
        }
        return get_string('footer_license_default', 'theme_union_govbr');
    }



    /**
     * Parse dynamic footer columns.
     *
     * @return array
     */
    public function footer_columns(): array {
        $raw = get_config('theme_union_govbr', 'footer_columns');
        if (empty($raw)) {
            return [];
        }

        $columns = [];
        $currentcol = null;
        $lines = explode("\n", $raw);

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            if (strpos($line, '#') === 0) {
                if ($currentcol !== null) {
                    $columns[] = $currentcol;
                }
                $currentcol = [
                    'title' => trim(substr($line, 1)),
                    'links' => [],
                ];
            } else {
                $parts = explode('|', $line, 2);
                $title = trim($parts[0]);
                $url = isset($parts[1]) ? trim($parts[1]) : '';

                if (!empty($title) && $currentcol !== null) {
                    $currentcol['links'][] = [
                        'title' => $title,
                        'url' => $url,
                    ];
                }
            }
        }

        if ($currentcol !== null) {
            $columns[] = $currentcol;
        }

        return $columns;
    }
}
