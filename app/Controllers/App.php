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
     * @param string $post_type
     * @param null|int|\WP_Post $post
     *
     * @return bool|int
     */
    public static function getPrimaryTermID(string $post_type, $post = null)
    {
        $tax_name = 'post' === $post_type ? 'category' : "{$post_type}_category";

        return yoast_get_primary_term_id($tax_name, $post);
    }

    /**
     * Returns the Post Type Category taxonomy of current query
     * @return string
     */
    public function postTypeCategoryTaxonomy(): string
    {
        $post_type = get_post_type();
        $taxonomy  = '';

        if (!empty($post_type)) {
            $taxonomy = 'post' === $post_type ? 'category' : "{$post_type}_category";
        }

        yoast_get_primary_term($taxonomy, get_the_ID());

        return $taxonomy;
    }

    public function currentUrl(): string
    {
        return $this->siteUrl() . add_query_arg(null, null) ?? $this->siteUrl();
    }

    public function currentUrlEncoded(): string
    {
        return urlencode($this->currentUrl());
    }

    public function currentPageTitle(): string
    {
        return self::title();
    }

    public static function currentPageMetaDescription($post_id): string
    {
        $post   = get_post($post_id);
        $ogdesc = \WPSEO_Meta::get_value('opengraph-description', $post_id);
        $ogdesc = wpseo_replace_vars($ogdesc, $post);

        if ('' === $ogdesc) {
            $ogdesc = \WPSEO_Frontend::get_instance()->metadesc(false);
        }

        if (!is_string($ogdesc) || (is_string($ogdesc) && '' === $ogdesc)) {
            $ogdesc = str_replace('[&hellip;]', '&hellip;', wp_strip_all_tags(get_the_excerpt($post_id)));
        }

        $ogdesc = strip_shortcodes($ogdesc);

        return trim(apply_filters('wpseo_opengraph_desc', $ogdesc));
    }
}
