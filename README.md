# Theme Union Gov.br (`theme_union_govbr`)

[![License](https://img.shields.io/badge/license-GPLv3-blue.svg)](http://www.gnu.org/licenses/gpl-3.0.html)

**Theme Union Gov.br** is a Moodle child theme based on the widely adopted [**Boost Union**](https://moodle.org/plugins/theme_boost_union) theme. It is specifically designed to adapt Moodle to the Brazilian Federal Government's official design standard: the **[GovBR Design System (GovBR DS)](https://gov.br/ds)**.

---

## ✨ Features Overview

### 1. 🏛️ Official Gov.br Identity Top Bar (`Barra Gov.br`)
- **Seamless Scroll Behavior**: Fixed to the top with a dynamic scroll offset script to prevent overlapping Moodle's fixed navbar.
- **Official Brand Assets**: Displays the official Federal Government logo with dynamic support for light and dark contrast modes.
- **Configurable Institutional Signature**: Optional text field to display the ministry, department, foundation, or university name alongside the logo.
- **Quick Links (Access to Information)**: Customizable list of government links (e.g., *Acesso à informação*, *Legislação*, *Participação Social*).
- **Fully Responsive**: In mobile and tablet viewports, the horizontal links automatically collapse into a compact, accessible 3-dots dropdown menu.
- **Color Schemes**: Supports both Light (*default*) and Dark (official Gov.br blue) backgrounds.

### 2. 📑 Standard Institutional Footer (`.br-footer`)
- **GovBR DS Structural Alignment**: Designed according to the GovBR DS footer specification with clear hierarchies (categories, links, social channels, and legal compliance).
- **Dedicated Footer Logo**: Supports uploading an optimized high-contrast logo for dark or light footer backgrounds, with an automatic fallback to the main site logo.
- **Customizable Multi-Column Links**: Category-based link management via an intuitive markdown-like syntax (`# Category Name` and `Link Title|URL`).
- **Official Social Network Channels**: Integrated vector icons and links for YouTube, Instagram, Facebook, X (Twitter), LinkedIn, TikTok, and WhatsApp.
- **Accessibility & License Statements**: Dedicated areas for eMAG/WCAG accessibility statements, terms of service, and customizable copyright/Creative Commons license declarations.
- **Background Variants**: Choose between Dark (*default*) and Inverted/Light themes.

### 3. 🎨 GovBR DS Component Styling
Some core Moodle and Boost Union components has been restyled according to the official GovBR Design System tokens:
- **Typography**: Uses the official *Rawline* font family and Gov.br modular typographic scale.
- **Color Tokens & Focus States**: High-contrast interactive states (focus ring with yellow/blue contrast meeting eMAG and WCAG 2.1 AA standards), hovers, active, and error states.
- **Form Controls**:
  - Primary, secondary, and tertiary Gov.br button styles (`.br-button`).
  - Inputs, textareas, and search groups.
  - Native animated switch toggles and customized Moodle "Edit Mode" toggle.
  - Gov.br checkboxes and radio buttons with custom SVG indicators.
  - Floating selects and dropdown menus.
- **Navigation & Layout**:
  - Standardized breadcrumbs, pagination controls, and tabs.
  - Offcanvas drawers and navigation headers.
  - Gov.br course cards with subtle borders and shadows.
  - Badges, status tags, and counter indicators.
- **System Feedback**:
  - Contextual alerts and notifications (Success, Info, Warning, Danger).
  - Modal dialogs and confirmation popups.
  - Accessible tooltips.
  - Standardized empty states and friendly error pages.
  - Custom Gov.br login and authentication layout.

---

## 📋 Requirements

- **Moodle**: Moodle 5.x.
- **PHP**: 8.2, or 8.3.
- **Theme Dependency**: [**theme_boost_union**](https://moodle.org/plugins/theme_boost_union) must be installed prior to activating this theme.

---

## ⚙️ Administration Settings

Theme settings can be managed at:  
**Site administration > Appearance > Themes > Union Gov.br** (`/admin/settings.php?section=themesettingunion_govbr`).

### Top Identity Bar (`Barra Gov.br`)
| Setting | Description | Default |
| :--- | :--- | :--- |
| **Enable Gov.br Bar** (`enablebarragovbr`) | Toggles the top Gov.br identity bar on or off. | Enabled (`1`) |
| **Header Signature Text** (`govbr_header_sign`) | Text displayed beside the logo (e.g. "Governo Federal", "Ministério da Educação"). | `Governo Federal` |
| **Gov.br Bar Links** (`govbr_header_links`) | Links displayed on the right side of the bar formatted as `Title\|URL` (one per line). | Standard Gov.br portal links |
| **Bar Background** (`govbr_header_background`) | Color scheme: Light (*default*) or Dark (*official Gov.br navy blue*). | `light` |

### Institutional Footer (`Rodapé Gov.br`)
| Setting | Description | Default |
| :--- | :--- | :--- |
| **Footer Background** (`footer_background`) | Color scheme: Dark (*default*) or Light (*inverted*). | `dark` |
| **Footer Specific Logo** (`footer_logo`) | Upload a logo file optimized for the footer contrast (falls back to main site logo). | *(Empty)* |
| **Custom Signature Logo** (`footer_custom_signature_logo`) | Supplementary logo image displayed in the bottom footer signature area. | *(Empty)* |
| **Footer Title** (`footer_title`) | Section title displayed above the footer links columns. | *(Empty)* |
| **Footer Columns & Links** (`footer_columns`) | Multi-column links defined using `# Category Title` and `Link Title\|URL`. | Standard Gov.br link sets |
| **Show Social Networks** (`footer_show_social`) | Toggles the display of institutional social media icons. | Enabled (`1`) |
| **Social Channels** (`footer_social_*`) | Direct profile URLs for Twitter/X, YouTube, Facebook, Instagram, LinkedIn, TikTok, and WhatsApp. | *(Empty)* |
| **Show License & Terms** (`footer_show_license`) | Toggles the display of license and copyright statements. | Enabled (`1`) |
| **Custom License Text** (`footer_license_custom`) | Custom HTML/text for the terms and copyright declaration. | *(Empty)* |

---

## 🛠️ Code Structure

```text
theme_union_govbr/
├── classes/
│   └── output/
│       └── core_renderer.php    # Injects Gov.br bar and footer data into Moodle templates
├── lang/
│   └── en/theme_union_govbr.php # English strings
├── pix/                         # Official Gov.br SVG logos and assets
├── scss/                        # Modular SCSS applying GovBR DS tokens and styles
│   ├── barragovbr.scss          # Top Gov.br bar styles
│   ├── footer.scss              # Institutional footer styles
│   ├── tokens.scss              # Official GovBR DS design tokens
│   ├── buttons.scss, inputs.scss, switches.scss, ... # Component styling
├── templates/
│   ├── barragovbr.mustache      # Top Gov.br bar template
│   └── theme_boost/
│       └── footer.mustache      # Overridden institutional footer template
├── config.php                   # Boost Union inheritance configuration
├── settings.php                 # Administrative configuration page
└── version.php                  # Plugin version and metadata
```

---

## 🤝 Contributing & Bug Reports

Contributions, issues, and feature requests are welcome!  
Feel free to open an issue or submit a pull request on the [GitHub repository](https://github.com/Matheu46/moodle-theme_union_govbr).

Please ensure all SCSS adheres to Moodle's `stylelint` rules and PHP code conforms to `moodle-cs`.

---

##  License

Licensed under the **GNU General Public License, Version 3.0 (GPLv3)**.  
See the [GNU General Public License](http://www.gnu.org/licenses/gpl-3.0.html) for full details.

---

**Author / Maintainer:** Matheus Mathias  
**Design System Reference:** [GovBR DS (Design System do Governo Federal)](https://gov.br/ds)
