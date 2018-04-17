<?php

namespace App;


/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});


/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});


/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\filter_templates');
});


/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory().'/index.php';
    }
    return $template;
}, PHP_INT_MAX);


/**
 * Tell WordPress how to find the compiled path of comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );
    return template_path(locate_template(["views/{$comments_template}", $comments_template]) ?: $comments_template);
});


/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
add_filter( 'wp_resource_hints', function( $urls, $relation_type ) {
	if ( wp_style_is( 'google-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = [
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
        ];
	}

	return $urls;
}, 10, 2 );


/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @origin Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
add_filter( 'wp_calculate_image_sizes', function ( $sizes, $size ) {
	if ( is_singular() ) {
		$width = $size[0];
		if ( 610 <= $width ) {
			$sizes = '(min-width: 990px) 720px, (min-width: 1300px) 610px, 95vw';
		}
		return $sizes;
	}
}, 10, 2 );


/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @origin Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
add_filter( 'wp_get_attachment_image_attributes', function ( $attr, $attachment, $size ) {
	if ( is_singular() ) {
		$attr['sizes'] = '(min-width: 990px) 720px, (min-width: 1300px) 820px, 95vw';
	} else {
		$attr['sizes'] = '(min-width: 990px) 955px, (min-width: 1300px) 966px, 95vw';
	}
	return $attr;
}, 10, 3 );


/**
 * Defer all scripts which are not excluded
 */
add_filter( 'script_loader_tag', function($tag) {
	if (is_admin()) {
        return $tag;
    }
	// Do not add defer or async attribute to these scripts
	$scripts_to_exclude = []; // add a string of js file e.g. script.js

	foreach($scripts_to_exclude as $exclude_script) {
		if (true == strpos($tag, $exclude_script ) )
			return $tag;
	}
	// Defer all remaining scripts not excluded above
	return str_replace( ' src', ' defer src', $tag );
}, 10, 1);


/**
 *  Defer only scripts which are included in here
 */
// add_filter('script_loader_tag', function($tag) {
// 	if (is_admin()) {
// 		return $tag;
// 	}
// 	// add a string of js file to defer e.g. script.js
// 	$scripts_to_include = [];

// 	foreach($scripts_to_include as $include_script) {
// 		// finds the position of the first occurence of include_script inside tag
// 		if (false == strpos($tag, $include_script ) )
// 			return($tag);
// 	}
// 	// Defer all scripts included above
// 	return str_replace(' src', ' defer src', $tag);
// }, 10, 1);


/**
 *  Async only scripts which are included in here
 */
add_filter('script_loader_tag', function($tag) {
	if (is_admin()) {
		return $tag;
	}
	// add a string of js file to async e.g. script.js
	$scripts_to_include = [];

	foreach($scripts_to_include as $include_script) {
		// finds the position of the first occurence of include_script inside tag
		if (false == strpos($tag, $include_script ) )
			return($tag);
	}
	// async all scripts included above
	return str_replace(' src', ' async src', $tag);
}, 10, 1);
