<?php

namespace App;

/**
 * Advanced Custom Fields drop-in functionality for Sage 9
 */

/**
 * Set local json save path
 */
add_filter('acf/settings/save_json', function ($path) {
    // Set Sage9 friendly path at /theme-directory/resources/assets/acf-json
    $path = get_stylesheet_directory() . '/assets/acf-json';
    // If the directory doesn't exist, create it.
    if (!is_dir($path)) {
        mkdir($path);
    }
    // Always return
    return $path;
});

/**
 * Set local json load path
 */
add_filter('acf/settings/load_json', function ($paths) {
    // append path
    $paths[] = get_stylesheet_directory() . '/assets/acf-json';
    // return
    return $paths;
});

/**
 * This filter is applied to the $value after it is loaded from the db and
 * before it is returned to the template via functions such as get_field()
 * @link https://www.advancedcustomfields.com/resources/acf-format_value/
 * For security reason we sanitize all text fields to prevent running javascript
 * in case of malicious code input inside ACF text field
 */
add_filter('acf/format_value/type=text', function ($value, $post_id, $field) {
    $value = sanitize_text_field($value);

    return $value;
}, 10, 3);

/**
 * Add ACF options page
 * @link https://www.advancedcustomfields.com/add-ons/options-page/
 * @link https://support.advancedcustomfields.com/forums/topic/options-page-polylang/
 */
add_action('init', function () {
    if (function_exists('acf_add_options_page')) {
        // If using Polylang create language specific option pages
        if (function_exists('pll_languages_list')) {
            // Main Theme Settings Page
            $parent = acf_add_options_page([
                'page_title'  => 'Theme General Settings',
                'menu_title'  => 'Theme Settings',
                'menu_slug'   => 'theme-general-settings',
                'capability'  => 'edit_posts',
                'parent_slug' => '',
                'position'    => 2, // Below 'Dashboard' menu item
                'icon_url'    => 'dashicons-admin-generic',
            ]);

            /**
             * Global Options
             * Same options on all languages. e.g., social profiles links
             */
            acf_add_options_sub_page([
                'page_title' => 'Global Options',
                'menu_title' => __('Global Options', 'sage'),
                'menu_slug'  => 'acf-options',
                'parent'     => $parent['menu_slug'],
            ]);

            /**
             * Language Specific Options
             * Get a list of languages set in polylang
             */
            $languages = pll_languages_list();

            foreach ($languages as $lang) {
                acf_add_options_sub_page([
                    'page_title' => 'Options (' . strtoupper($lang) . ')',
                    'menu_title' => __('Options (' . strtoupper($lang) . ')', 'sage'),
                    'menu_slug'  => "options-${lang}",
                    'post_id'    => $lang,
                    'parent'     => $parent['menu_slug'],
                ]);
            }
        } else {
            acf_add_options_page([
                'page_title'  => 'Theme General Settings',
                'menu_title'  => 'Theme Settings',
                'menu_slug'   => 'theme-general-settings',
                'capability'  => 'edit_posts',
                'parent_slug' => '',
                'position'    => 2, // Below 'Dashboard' menu item
                'icon_url'    => 'dashicons-admin-generic',
            ]);
        }
    }
});
