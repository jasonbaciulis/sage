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
