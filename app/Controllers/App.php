<?php

namespace App\Controllers;

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
    public static function get_file_contents($asset)
    {
        // Get asset built for production. This way we can include SVGs that are already optimized.
        $asset_url = asset_path($asset);
        // Get asset PATH in order for file_exists() to work, because asset_path() actually returns url
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
    public static function get_img_src($id, $size)
    {
        $image_array = wp_get_attachment_image_src($id, $size);
        $image_src   = $image_array[0];

        return $image_src;
    }

    /**
     * Shorter function to get specific img size srcset
     */
    public static function get_img_srcset($id, $size)
    {
        return $image_srcset = wp_get_attachment_image_srcset($id, $size);
    }

    /**
     * Get image aspect ratio
     */
    public static function get_img_aspectratio($id, $size)
    {
        $imageArray = wp_get_attachment_image_src($id, $size);
        $width      = $imageArray[1];
        $height     = $imageArray[2];

        return $ratio = "$width/$height";
    }

    /**
     * Get image width
     */
    public static function get_img_width($id, $size)
    {
        $imageArray = wp_get_attachment_image_src($id, $size);
        $width      = $imageArray[1];

        return $width;
    }

    /**
     * Get image height
     */
    public static function get_img_height($id, $size)
    {
        $imageArray = wp_get_attachment_image_src($id, $size);
        $height     = $imageArray[2];

        return $height;
    }

    /**
     * Calculate a percentage of image ratio to dynamically set padding bottom for image aspect ratio containers
     */
    public static function get_ratio_percent($id, $size)
    {
        $imageArray = wp_get_attachment_image_src($id, $size);
        $width      = $imageArray[1];
        $height     = $imageArray[2];
        $percent    = round(($height / $width * 100), 2) . '%';

        return $percent;
    }

    public static function get_img_object($id, $size)
    {
        return (object) [
            'placeholder'   => 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==',
            'src'           => wp_get_attachment_image_src($id, $size)[0],
            'srcset'        => wp_get_attachment_image_srcset($id, $size),
            'alt'           => get_post_meta($id, '_wp_attachment_image_alt', true),
            'ratio_percent' => self::get_ratio_percent($id, $size),
        ];
    }

    /**
     * Retrieve menu items in an array
     * @link https://wordpress.stackexchange.com/questions/111060/retrieving-a-list-of-menu-items-in-an-array
     */
    public static function menu_items($menu)
    {
        $id    = get_nav_menu_locations($menu);
        $items = wp_get_nav_menu_items($id);

        if (is_array($items)) {
            return $items;
        } else {
            return [];
        }
    }
}
