<?php

namespace App;

/**
 * Performance optimizations and removals of unnecessary WP features
 */

/**
 * DNS prefetching
 */
add_action('wp_head', function () {
    $prefetch = 'on';
    echo '<meta http-equiv="x-dns-prefetch-control" content="' . $prefetch . '">' . "\n";

    if ($prefetch != 'on') {
        $dns_domains = [
            '//ajax.googleapis.com',
            '//fonts.googleapis.com',
            '//s0.wp.com',
            '//s.gravatar.com',
            '//stats.wordpress.com',
            '//www.google-analytics.com',
        ];
        foreach ($dns_domains as $domain) {
            if (!empty($domain)) {
                echo '<link rel="dns-prefetch" href="' . $domain . '" />' . "\n";
            }
        }
        unset($domain);
    }
}, 0);

/**
 * Preconnect for Font CDNs
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
add_filter('wp_resource_hints', function ($urls, $relation_type) {
    $font_services = [
        [
            'handle' => 'google-fonts',
            'url'    => 'https://fonts.gstatic.com',
        ],
        [
            'handle' => 'fonts.net-fonts',
            'url'    => 'https://fast.fonts.net',
        ],
    ];

    foreach ($font_services as $font) {
        if (wp_style_is($font['handle'], 'queue') && 'preconnect' === $relation_type) {
            $urls[] = [
                'href' => $font['url'],
                'crossorigin',
            ];
        }
    }

    return $urls;
}, 10, 2);

/**
 * This disables XML-RPC API, which is enabled by default
 * Helps to prevent brute force attacks
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Remove jQuery Migrate script from the jQuery bundle only in front end
 * @param WP_Scripts $scripts WP_Scripts object.
 */
add_action('wp_default_scripts', function ($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];

        if ($script->deps) { // Check whether the script has any dependencies
            $script->deps = array_diff($script->deps, ['jquery-migrate']);
        }
    }
});

/**
 * Disable the emoji's
 */
add_action('init', function () {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    /**
    * Filter function used to remove the tinymce emoji plugin.
    *
    * @param    array  $plugins
    * @return   array             Difference betwen the two arrays
    */
    add_filter('tiny_mce_plugins', function ($plugins) {
        if (is_array($plugins)) {
            return array_diff($plugins, ['wpemoji']);
        }

        return [];
    });

    /**
     * Remove emoji CDN hostname from DNS prefetching hints.
     *
     * @param  array  $urls          URLs to print for resource hints.
     * @param  string $relation_type The relation type the URLs are printed for.
     * @return array                 Difference betwen the two arrays.
     */
    add_filter('wp_resource_hints', function ($urls, $relation_type) {
        if ('dns-prefetch' == $relation_type) {
            // Strip out any URLs referencing the WordPress.org emoji location
            $emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
            foreach ($urls as $key => $url) {
                if (strpos($url, $emoji_svg_url_bit) !== false) {
                    unset($urls[$key]);
                }
            }
        }

        return $urls;
    }, 10, 2);
});

/**
* Remove WordPress version number
*/
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', function () {
    return '';
});

/**
 * Remove really simple discovery (RSD) link
 */
remove_action('wp_head', 'rsd_link');

/**
 * Remove wlwmanifest.xml (needed to support windows live writer)
 */
remove_action('wp_head', 'wlwmanifest_link');

/**
 * Remove RSS feed links
 */
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

/**
 * Remove link to index page
 */
remove_action('wp_head', 'index_rel_link');

/**
 * Remove random post link
 */
remove_action('wp_head', 'start_post_rel_link', 10, 0);

/**
 * Remove parent post link
 */
remove_action('wp_head', 'parent_post_rel_link', 10, 0);

/**
 * Remove the next and previous post links
 */
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

/**
 * Remove shortlink
*/
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('template_redirect', 'wp_shortlink_header', 11, 0);

/**
 * Remove REST API Links
 */
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('template_redirect', 'rest_output_link_header', 11, 0);

/**
 * Gravity forms
 * Force Gravity Forms to init scripts in the footer and ensure that the DOM is loaded before scripts are executed
 * @link https://gist.github.com/eriteric/5d6ca5969a662339c4b3
 */
if (class_exists('GFAPI')) {
    add_filter('gform_init_scripts_footer', '__return_true');
    add_filter('gform_cdata_open', function ($content = '') {
        if ((defined('DOING_AJAX') && DOING_AJAX) || isset($_POST['gform_ajax'])) {
            return $content;
        }
        $content = 'document.addEventListener( "DOMContentLoaded", function() { ';

        return $content;
    }, 1);

    add_filter('gform_cdata_close', function ($content = '') {
        if ((defined('DOING_AJAX') && DOING_AJAX) || isset($_POST['gform_ajax'])) {
            return $content;
        }
        $content = ' }, false );';

        return $content;
    }, 99);
}
