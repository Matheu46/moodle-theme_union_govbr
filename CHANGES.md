# Changes

All notable changes to this project will be documented in this file.

## v1.0.1 (2026-10-12)

* **Font Bundling**: Bundle Rawline webfonts locally (WOFF2 and WOFF formats) under SIL Open Font License 1.1 instead of loading from external CDN (`fonts.cdnfonts.com`), adhering to strict CSP and privacy standards, resolves #2.
* **Third-Party Libraries**: Add `thirdpartylibs.xml` documenting the Rawline font family, licensing, and upstream repository.
* **SCSS Callbacks Chaining**: Chain Boost Union's `theme_boost_union_get_pre_scss()` and `theme_boost_union_get_extra_scss()` callbacks in `lib.php` and use `require` for Boost Union `config.php`, ensuring full inheritance of Boost Union settings (custom SCSS, brand colors, flavours, login arrangements).
* **Localization**: Translate fatal error debug labels ('Debug info:', 'Stack trace:', and 'Output buffer:') using language strings and Mustache `{{#str}}` helpers in `templates/fatal_error.mustache`.
* **Settings**: Set default state of Barra Gov.br (`enablebarragovbr`) to disabled (`0`), updating documentation and conditional rendering accordingly.

## v1.0.0 (2026-09-17)

* Initial stable release for Moodle 5.0+.
* Gov.br Design System visual identity integration for Boost Union.
* Support for top Gov.br Bar (`Barra Gov.br`), institutional footer, custom error pages (403, 404, 500), and design tokens.

