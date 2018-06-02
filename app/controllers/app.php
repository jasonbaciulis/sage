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
     * Return content of a file
     */
    public static function get_file_contents($asset) {
        $asset_url = asset_path($asset);
        $asset_path = get_theme_file_path() . '/resources/assets/' . $asset ;

        if (file_exists($asset_path)) {
            return file_get_contents($asset_url);
        } else {
            return 'Could not locate the file. Make sure it exists! Or try refreshing the page.';
        }
    }

    /**
     * Shorter function to get specific img size src
     */
    public static function get_img_src($id, $size) {
        $image_array = wp_get_attachment_image_src($id, $size);
        $image_src = $image_array[0];
        return $image_src;
    }

    /**
     * Shorter function to get specific img size srcset
     */
    public static function get_img_srcset($id, $size) {
        return $image_srcset = wp_get_attachment_image_srcset($id, $size);
    }

    /**
     * Get full srcset attribute for bg images
     */
    public static function get_bg_img_srcset($img_id) {
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

    /**
     * Get image aspect ratio
     */
    public static function get_img_aspectratio($id, $size) {
        $imageArray = wp_get_attachment_image_src($id, $size);
        $width = $imageArray[1];
        $height = $imageArray[2];

        return $ratio = "$width/$height";
    }

    /**
     * Pull ACF fields as variables from options page and store in an object
     */
    public function social() {
        return (object) [
            'linkedin'    => get_field('social_linkedin', 'option'),
            'twitter'     => get_field('social_twitter', 'option'),
            'facebook'    => get_field('social_facebook', 'option'),
            'google_plus' => get_field('social_google_plus', 'option'),
            'youtube'     => get_field('social_youtube', 'option'),
        ];
    }

    public function custom_query() {
        $args = [
            'post_type'      => 'post',
            'orderby'        => 'date',
            'order'          => 'DESC',
            'posts_per_page' => 9,
        ];
        return $query = new \WP_Query($args);
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
}
