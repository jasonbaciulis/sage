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
	wp_enqueue_style('google-fonts', google_fonts_url());
    // wp_enqueue_style( $handle, $src, $deps = [], $ver, $media = 'all')
    wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);
    // wp_enqueue_script( $handle, $src, $deps, $version, $in_footer(boolean))
    wp_enqueue_script('lazysizes', asset_path('scripts/lazysizes.js'), [], null, true);
    wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
    }
}, 100);


/**
 * Register custom fonts.
 * @link https://fonts.google.com/
 */
function google_fonts_url() {
	$fonts_url = '';
	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Rubik and Roboto Mono translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$rubik = _x( 'on', 'Rubik font: on or off', 'crave' );
	$roboto_mono = _x( 'on', 'Roboto Mono font: on or off', 'crave' );

	$font_families = [];

	if ( 'off' !== $rubik ) {
		$font_families[] = 'Rubik:300,300i,400,400i';
	}
	if ( 'off' !== $roboto_mono ) {
		$font_families[] = 'Roboto Mono:400,400i,700,700i';
	}
	if ( in_array( 'on', [$rubik, $roboto_mono] ) ) {
		$query_args = [
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin' ),
        ];
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}
	return esc_url_raw( $fonts_url );
}


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
    add_image_size( 'mobile', 480, 9999);
    add_image_size( 'laptop', 1366, 9999);
    add_image_size( 'fullhd', 1920, 9999);

    // Your blog posts featured image size
    add_image_size( 'featured-index', 800, 450, true);

    // Add tiny image size to use as a low quality image placeholder
    add_image_size( 'lqip', 25, 99);

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
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name'          => __('Footer', 'sage'),
        'id'            => 'sidebar-footer'
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

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });
});


/**
 * Add ACF options page
 * @link https://www.advancedcustomfields.com/add-ons/options-page/
 */
add_action('init', function () {
    if (!function_exists('acf_add_options_page')) {
        return;
    }
    acf_add_options_page([
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'parent_slug'   => '',
        'position'      => 2, // Below 'Dashboard' menu item
        'icon_url'      => 'dashicons-admin-generic',
    ]);
});


/**
 * Load posts with AJAX on tab click and on load more button click
 */
// function ajax_load_posts() {

//     $offset = (isset($_POST['offset'])) ? $_POST['offset'] : 0;
//     $ppp = (isset($_POST['posts_per_page'])) ? $_POST['posts_per_page'] : 9;
//     $category = $_POST['query_cat'];

//     $args = [
//         'post_type'      => 'post',
//         'orderby'        => 'date',
//         'order'          => 'DESC',
//         'post_status'    => 'publish',
//         'offset'         => $offset,
//         'posts_per_page' => $ppp,
//     ];

//     if ($category !== 'all') {
//         $args['category_name'] = $category;
//     }

//     // We need to step out of namespace when calling WP_Query
//     $query = new \WP_Query($args);

// 	if( $query->have_posts() ) :
// 		while( $query->have_posts() ): $query->the_post();
//             echo \App\template(locate_template('views/partials/content'));
//         endwhile;
//     endif;

//     die();
// }
// add_action('wp_ajax_loadposts', __NAMESPACE__ . '\\ajax_load_posts');
// add_action('wp_ajax_nopriv_loadposts', __NAMESPACE__ . '\\ajax_load_posts');
