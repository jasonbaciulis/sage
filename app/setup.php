<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=IBM+Plex+Serif:400,400i,500,500i|Open+Sans:400,600,700&amp;subset=latin', false, null);
    // wp_enqueue_style( $handle, $src, $deps = [], $ver, $media = 'all')
    wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);
    // wp_enqueue_script( $handle, $src, $deps, $version, $in_footer(boolean))
    wp_enqueue_script('lazysizes', asset_path('scripts/lazysizes.js'), [], null, true);
    wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage')
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Add additional image size.
     * @param Boolean is for cropping image from the center (default is false and scales an image)
     */
    // add_image_size('mobile', 480, 9999);

    // Add tiny image size to use as a low quality image placeholder
    add_image_size('lqip', 25, 99);

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ];
    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer'
    ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });
});

/**
 * Load posts with AJAX
 */
// function load_posts() {

//     $post_type = 'news';
//     $page      = $_POST['page'] ?? 1;
//     $ppp       = $_POST['ppp'] ?? 12;

//     $args = [
//         'post_type'              => $post_type,
//         'post_status'            => 'publish',
//         'orderby'                => 'date',
//         'order'                  => 'DESC',
//         'posts_per_page'         => $ppp,
//         'paged'                  => $page,
//         'update_post_meta_cache' => false,
//         'update_post_term_cache' => false,
//     ];

//     $query = new \WP_Query($args);

//     // Create an object where we'll store template content data as well any other data we want to pass to js
//     $return_data = (object)[
//         'content' => [],
//         'found_posts' => $query->found_posts,
//     ];

//     if ($query->have_posts()) :
//         while ($query->have_posts()): $query->the_post();
//             array_push($return_data->content, \App\template(locate_template('views/partials/content-'.$post_type)));
//         endwhile;
//     endif;

//     /**
//      * Encodes a variable (Array or Object) as JSON, then prints and runs die()
//      * @link https://developer.wordpress.org/reference/functions/wp_send_json/
//      */
//     wp_send_json($return_data);
// }
// add_action('wp_ajax_load_posts', __NAMESPACE__ . '\\load_posts');
// add_action('wp_ajax_nopriv_load_posts', __NAMESPACE__ . '\\load_posts');
