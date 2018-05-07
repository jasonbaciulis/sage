<?php

namespace App;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }

    /**
     * Primary Nav Menu arguments
     * @return array
     */
    public function primary_menu() {
        $args = [
            'theme_location'    => 'primary_navigation',
            'menu'            => 'top',
            'container'       => 'div',
            'container_id'    => 'bs4navbar',
            'container_class' => 'collapse navbar-collapse',
            'menu_id'         => false,
            'menu_class'      => 'navbar-nav mr-auto',
            'depth'           => 2,
            'fallback_cb'     => 'bs4navwalker::fallback',
            'walker'            => new wp_bootstrap4_navwalker()
        ];
        return $args;
    }

    /**
     * Pull in ACF plugin fields as variables from options page
     */
    // public function url_social_facebook() {
    //     return get_field('url_social_facebook', 'option');
    // }

    // public function url_social_twitter() {
    //     return get_field('url_social_twitter', 'option');
    // }

    public static function get_img_src($id, $size) {
        $image_array = wp_get_attachment_image_src($id, $size);
        $image_src = $image_array[0];
        return $image_src;
    }

    public static function get_img_srcset($img_id) {
        $mobile       = App::get_img_src($img_id, 'mobile');        // Custom
        $tablet       = App::get_img_src($img_id, 'medium_large');  // WP default
        $tablet_large = App::get_img_src($img_id, 'large');         // WP default
        $laptop       = App::get_img_src($img_id, 'laptop');        // Custom
        $fullhd       = App::get_img_src($img_id, 'fullhd');        // Custom

        return $srcset = "$mobile 480w, $tablet 768w, $tablet_large 1024w, $laptop 1366w, $fullhd 1920w";
    }

    public static function lqip($img_id) {
        return $lqip = App::get_img_src($img_id, 'lqip'); // Low quality image placeholder
    }

    // public function bg_image_masthead() {
    //     return get_field('bg_image_masthead');
    // }
}
