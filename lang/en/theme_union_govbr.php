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
 * Strings for component 'theme_union_govbr', language 'en'
 *
 * @package    theme_union_govbr
 * @copyright  2026 Matheus Mathias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Union Gov.br';
$string['choosereadme'] = 'Theme based on Boost Union following the Brazilian Gov.br Design System guidelines.';
$string['region-side-pre'] = 'Right';

// Error pages (Gov.br DS).
$string['error_404_title'] = 'Page not found';
$string['error_404_badge'] = 'Error 404';
$string['error_404_description'] = 'The address you tried to access was not found, may have been removed or is temporarily unavailable.';

$string['error_403_title'] = 'Access denied';
$string['error_403_badge'] = 'Error 403';
$string['error_403_description'] = 'You do not have permission to access this resource. Please make sure you are signed in with the appropriate account.';

$string['error_general_title'] = 'Oops! Something went wrong';
$string['error_general_badge'] = 'System Error';
$string['error_general_description'] = 'An unexpected error occurred while processing your request. Please try again or return to the home page.';

$string['error_btn_home'] = 'Home';
$string['error_btn_back'] = 'Go back';
$string['error_btn_login'] = 'Sign in';
$string['error_debug_title'] = 'Technical information for administrators (Debug)';
$string['error_debug_code'] = 'Error code';
$string['error_debug_moreinfo'] = 'More information about this error';

// Theme and Footer Settings (Gov.br DS).
$string['footer_heading'] = 'Footer Settings';
$string['footer_heading_desc'] = 'Customize the footer following the Gov.br Design System (.br-footer) standard, including signature model, categories, and social media links.';

$string['footer_signature_type'] = 'Footer signature type';
$string['footer_signature_type_desc'] = 'Select the signature model displayed in the footer.<br><strong>Important:</strong> The Federal Government brand is restricted to Brazilian federal public administration entities (SECOM/PR regulations). For state/municipal entities, private/educational institutions, or international users using this design system under its open license, select "Custom Institutional Logo" or "None / Neutral Mode".';
$string['footer_signature_type_govbr'] = 'Federal Government (Gov.br) — Federal public entities only';
$string['footer_signature_type_custom'] = 'Custom Institutional Logo — States, municipalities, private/educational entities';
$string['footer_signature_type_none'] = 'None / Hide signature — Neutral Mode';

$string['footer_custom_signature_logo'] = 'Custom institutional signature logo';
$string['footer_custom_signature_logo_desc'] = 'Upload your institution\'s logo image (preferably SVG or transparent PNG) to be displayed in the footer signature area when "Custom Institutional Logo" is selected.';

$string['footer_title'] = 'Footer institutional title';
$string['footer_title_desc'] = 'Name of the institution or organization displayed alongside the logo in the footer header. If left blank, defaults to the site full name.';

$string['footer_show_categories'] = 'Show navigation categories';
$string['footer_show_categories_desc'] = 'Displays site map link columns in the footer (Access to Information, Services & Support, Navigation, etc.).';

$string['footer_show_social'] = 'Show social media networks';
$string['footer_show_social_desc'] = 'Displays the social media networks section in the footer header.';

$string['footer_social_title'] = 'Social Networks';
$string['footer_social_twitter'] = 'X (formerly Twitter) URL';
$string['footer_social_twitter_desc'] = 'Link to the institutional profile on X / Twitter.';
$string['footer_social_youtube'] = 'YouTube URL';
$string['footer_social_youtube_desc'] = 'Link to the institutional YouTube channel.';
$string['footer_social_facebook'] = 'Facebook URL';
$string['footer_social_facebook_desc'] = 'Link to the institutional Facebook page.';
$string['footer_social_instagram'] = 'Instagram URL';
$string['footer_social_instagram_desc'] = 'Link to the institutional Instagram profile.';
$string['footer_social_linkedin'] = 'LinkedIn URL';
$string['footer_social_linkedin_desc'] = 'Link to the institutional LinkedIn profile.';
$string['footer_social_tiktok'] = 'TikTok URL';
$string['footer_social_tiktok_desc'] = 'Link to the institutional TikTok profile.';
$string['footer_social_whatsapp'] = 'WhatsApp URL';
$string['footer_social_whatsapp_desc'] = 'Link to the institutional WhatsApp channel or customer support.';

$string['footer_show_license'] = 'Show license / copyright text';
$string['footer_show_license_desc'] = 'Displays the content license text in the bottom-left area of the footer.';
$string['footer_license_custom'] = 'Custom license text';
$string['footer_license_custom_desc'] = 'Enter a custom license or copyright statement. If left blank, the default Creative Commons 3.0 license text is used.';
$string['footer_license_default'] = 'All content on this site is published under the Creative Commons Attribution-NoDerivatives 3.0 Unported license.';

// Footer categories and links.
$string['footer_cat_info'] = 'Access to Information';
$string['footer_cat_services'] = 'Services and Support';
$string['footer_cat_navigation'] = 'Navigation & Accessibility';
$string['footer_cat_social'] = 'Official Channels';

$string['footer_link_institutional'] = 'Institutional';
$string['footer_link_programs'] = 'Actions and Programs';
$string['footer_link_social_participation'] = 'Social Participation';
$string['footer_link_faq'] = 'FAQ';
$string['footer_link_services'] = 'Service Center';
$string['footer_link_support'] = 'User Support';
$string['footer_link_documentation'] = 'Moodle Documentation';
$string['footer_link_terms'] = 'Terms of Use & Privacy';
$string['footer_link_home'] = 'Home';
$string['footer_link_mycourses'] = 'My Courses';
$string['footer_link_accessibility_statement'] = 'Accessibility Statement';

$string['footer_brasil_logo_alt'] = 'Federal Government of Brazil — Union and Reconstruction';
$string['footer_custom_logo_alt'] = 'Institutional signature';



$string['footer_col1_links'] = 'Column 1 Links (Access to Information)';
$string['footer_col1_links_desc'] = 'List of links to display in the first column. Enter one link per line, in the format: Title|URL. For example: Institutional|https://gov.br/';
$string['footer_col2_links'] = 'Column 2 Links (Services and Support)';
$string['footer_col2_links_desc'] = 'List of links to display in the second column. Enter one link per line, in the format: Title|URL.';
$string['footer_col3_links'] = 'Column 3 Links (Navigation and Accessibility)';
$string['footer_col3_links_desc'] = 'List of links to display in the third column. Enter one link per line, in the format: Title|URL.';
$string['footer_col4_links'] = 'Column 4 Links (Official Channels)';
$string['footer_col4_links_desc'] = 'List of links to display in the fourth column. Enter one link per line, in the format: Title|URL.';

$string['footer_col1_title'] = 'Column 1 Title';
$string['footer_col1_title_desc'] = 'Title for the first column. Example: Access to Information';
$string['footer_col2_title'] = 'Column 2 Title';
$string['footer_col2_title_desc'] = 'Title for the second column. Example: Services and Support';
$string['footer_col3_title'] = 'Column 3 Title';
$string['footer_col3_title_desc'] = 'Title for the third column. Example: Navigation and Accessibility';
$string['footer_col4_title'] = 'Column 4 Title';
$string['footer_col4_title_desc'] = 'Title for the fourth column. Example: Official Channels';
