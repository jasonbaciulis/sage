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

    // Set up to pull in ACF plugin fields as variables from options page
    public function url_social_media_facebook() {
        return get_field('url_social_media_facebook', 'option');
    }

    public function url_social_media_twitter() {
        return get_field('url_social_media_twitter', 'option');
    }

    public function url_social_media_instagram() {
        return get_field('url_social_media_instagram', 'option');
    }
}
