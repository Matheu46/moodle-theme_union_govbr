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
 * Theme Union Gov.br - Settings file.
 *
 * @package    theme_union_govbr
 * @copyright  2026 Matheus Mathias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$settings = new admin_settingpage('themesettingunion_govbr', get_string('pluginname', 'theme_union_govbr'));

if ($ADMIN->fulltree) {
    // Gov.br Bar setting.
    $name = 'theme_union_govbr/enablebarragovbr';
    $title = get_string('enablebarragovbr', 'theme_union_govbr');
    $description = get_string('enablebarragovbr_desc', 'theme_union_govbr');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Header sign text setting.
    $name = 'theme_union_govbr/govbr_header_sign';
    $title = get_string('govbr_header_sign', 'theme_union_govbr');
    $description = get_string('govbr_header_sign_desc', 'theme_union_govbr');
    $default = 'Governo Federal';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Setting: Barra Gov.br Links.
    $name = 'theme_union_govbr/govbr_header_links';
    $title = get_string('govbr_header_links', 'theme_union_govbr');
    $description = get_string('govbr_header_links_desc', 'theme_union_govbr');
    $default = "Acesso à informação|http://www.gov.br/acessoainformacao/\nParticipe|https://www.gov.br/pt-br/participacao-social/\nLegislação|http://www4.planalto.gov.br/legislacao/\nÓrgãos do Governo|http://www.gov.br/pt-br/orgaos-do-governo";
    $setting = new admin_setting_configtextarea($name, $title, $description, $default, PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Setting: Barra Gov.br Background Color.
    $name = 'theme_union_govbr/govbr_header_background';
    $title = get_string('govbr_header_background', 'theme_union_govbr');
    $description = get_string('govbr_header_background_desc', 'theme_union_govbr');
    $default = 'light';
    $choices = [
        'light' => get_string('govbr_header_background_light', 'theme_union_govbr'),
        'dark' => get_string('govbr_header_background_dark', 'theme_union_govbr'),
    ];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Heading: Footer Settings.
    $settings->add(new admin_setting_heading(
        'theme_union_govbr_footer_heading',
        get_string('footer_heading', 'theme_union_govbr'),
        get_string('footer_heading_desc', 'theme_union_govbr')
    ));

    // Setting: Footer Background Color.
    $name = 'theme_union_govbr/footer_background';
    $title = get_string('footer_background', 'theme_union_govbr');
    $description = get_string('footer_background_desc', 'theme_union_govbr');
    $default = 'dark';
    $choices = [
        'dark' => get_string('footer_background_dark', 'theme_union_govbr'),
        'light' => get_string('footer_background_light', 'theme_union_govbr'),
    ];
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Setting: Footer Specific Logo (stored file).
    $name = 'theme_union_govbr/footer_logo';
    $title = get_string('footer_logo', 'theme_union_govbr');
    $description = get_string('footer_logo_desc', 'theme_union_govbr');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'footer_logo', 0, ['maxfiles' => 1, 'accepted_types' => 'web_image']);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Setting: Custom Signature Logo (stored file).
    $name = 'theme_union_govbr/footer_custom_signature_logo';
    $title = get_string('footer_custom_signature_logo', 'theme_union_govbr');
    $description = get_string('footer_custom_signature_logo_desc', 'theme_union_govbr');
    $setting = new admin_setting_configstoredfile(
        $name,
        $title,
        $description,
        'footer_custom_signature_logo',
        0,
        ['maxfiles' => 2, 'accepted_types' => ['web_image', '.svg']]
    );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Setting: Footer Title.
    $name = 'theme_union_govbr/footer_title';
    $title = get_string('footer_title', 'theme_union_govbr');
    $description = get_string('footer_title_desc', 'theme_union_govbr');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    $name = 'theme_union_govbr/footer_columns';
    $title = get_string('footer_columns', 'theme_union_govbr');
    $description = get_string('footer_columns_desc', 'theme_union_govbr');
    $default = "# Acesso à Informação\nInstitucional|https://gov.br/\n" .
               "Programas e Ações|https://gov.br/\n" .
               "# Serviços e Suporte\nServiços|https://gov.br/pt-br/servicos\n" .
               "# Navegação e Acessibilidade\nDeclaração de Acessibilidade|https://gov.br/\n" .
               "# Canais Oficiais\nTermos de Uso|https://gov.br/";
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    $name = 'theme_union_govbr/footer_show_categories';
    $title = get_string('footer_show_categories', 'theme_union_govbr');
    $description = get_string('footer_show_categories_desc', 'theme_union_govbr');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Setting: Show Social Networks.
    $name = 'theme_union_govbr/footer_show_social';
    $title = get_string('footer_show_social', 'theme_union_govbr');
    $description = get_string('footer_show_social_desc', 'theme_union_govbr');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Social Media Links.
    $socials = [
        'twitter' => ['label' => 'footer_social_twitter', 'desc' => 'footer_social_twitter_desc'],
        'youtube' => ['label' => 'footer_social_youtube', 'desc' => 'footer_social_youtube_desc'],
        'facebook' => ['label' => 'footer_social_facebook', 'desc' => 'footer_social_facebook_desc'],
        'instagram' => ['label' => 'footer_social_instagram', 'desc' => 'footer_social_instagram_desc'],
        'linkedin' => ['label' => 'footer_social_linkedin', 'desc' => 'footer_social_linkedin_desc'],
        'tiktok' => ['label' => 'footer_social_tiktok', 'desc' => 'footer_social_tiktok_desc'],
        'whatsapp' => ['label' => 'footer_social_whatsapp', 'desc' => 'footer_social_whatsapp_desc'],
    ];
    foreach ($socials as $key => $info) {
        $name = 'theme_union_govbr/footer_social_' . $key;
        $title = get_string($info['label'], 'theme_union_govbr');
        $description = get_string($info['desc'], 'theme_union_govbr');
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    }

    // Setting: Show License.
    $name = 'theme_union_govbr/footer_show_license';
    $title = get_string('footer_show_license', 'theme_union_govbr');
    $description = get_string('footer_show_license_desc', 'theme_union_govbr');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Setting: Custom License Text.
    $name = 'theme_union_govbr/footer_license_custom';
    $title = get_string('footer_license_custom', 'theme_union_govbr');
    $description = get_string('footer_license_custom_desc', 'theme_union_govbr');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default, PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);
}
