<?php

namespace App;

use Roots\Sage\Container;

/**
 * Get the sage container.
 *
 * @param string $abstract
 * @param array  $parameters
 * @param Container $container
 * @return Container|mixed
 */
function sage($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }

    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }

    return sage('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return sage('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset)
{
    return sage('assets')->getUri($asset);
}

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('sage/filter_templates/paths', [
        'views',
        'resources/views',
    ]);
    $paths_pattern = '#^(' . implode('|', $paths) . ')/#';

    return collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                    ];
                })
                ->concat([
                    "{$template}.blade.php",
                    "{$template}.php",
                ]);
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($templates)
{
    return \locate_template(filter_templates($templates));
}

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_sidebar()
{
    static $display;
    isset($display) || $display = apply_filters('sage/display_sidebar', false);

    return $display;
}

/**
 * This little function will return the contents of already optimized assets
 * Very useful for inlining SVG files in templates but keeping them clean
 * @param string i.e: "images/icon.svg"
 */
function file_contents($asset)
{
    $asset_url = asset_path($asset);

    if (fopen($asset_url, 'r')) {
        return file_get_contents($asset_url);
    } else {
        return 'Could not locate the file. Make sure it exists! Or try running "yarn build" again';
    }
}

function img_src($id, $size)
{
    return wp_get_attachment_image_url($id, $size);
}

function img_srcset($id, $size)
{
    return wp_get_attachment_image_srcset($id, $size);
}

function img_aspectratio($id, $size)
{
    $imageArray = wp_get_attachment_image_src($id, $size);
    $width      = $imageArray[1];
    $height     = $imageArray[2];

    return $ratio = "$width/$height";
}

function img_width($id, $size)
{
    $imageArray = wp_get_attachment_image_src($id, $size);
    $width      = $imageArray[1];

    return $width;
}

function img_height($id, $size)
{
    $imageArray = wp_get_attachment_image_src($id, $size);
    $height     = $imageArray[2];

    return $height;
}

function img_placeholder()
{
    return 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
}

/**
 * Calculate a percentage of image ratio.
 * Used to dynamically set padding bottom for image aspect ratio containers.
 */
function img_ratio($id, $size)
{
    $imageArray = wp_get_attachment_image_src($id, $size);
    $width      = $imageArray[1];
    $height     = $imageArray[2];
    $percent    = round(($height / $width * 100), 2) . '%';

    return $percent;
}

function img_alt($id)
{
    return get_post_meta($id, '_wp_attachment_image_alt', true);
}

function img_object($id, $size)
{
    return (object) [
        'placeholder'   => img_placeholder(),
        'src'           => img_src($id, $size),
        'srcset'        => img_srcset($id, $size),
        'alt'           => img_alt($id),
        'ratio_percent' => img_ratio($id, $size),
    ];
}

/**
 * Retrieve menu items in an array
 * @link https://wordpress.stackexchange.com/questions/111060/retrieving-a-list-of-menu-items-in-an-array
 */
function menu_items($menu)
{
    $id    = get_nav_menu_locations()[$menu];
    $items = wp_get_nav_menu_items($id);

    if (is_array($items)) {
        return $items;
    } else {
        return [];
    }
}

function top_lvl_menu_items($menu)
{
    $menu_items         = menu_items($menu);
    $top_lvl_menu_items = [];

    // Get the top level menu items in an array
    if (is_array($menu_items)) {
        foreach ($menu_items as $item) {
            if ($item->menu_item_parent == 0) {
                array_push($top_lvl_menu_items, $item);
            }
        }
    }

    return $top_lvl_menu_items;
}

function show_whats_loaded()
{
    global $wp_scripts;
    global $wp_styles;

    $string = '<div class="container">';

    $string .= '<h2>Scripts:</h2>';

    foreach ($wp_scripts->queue as $script) {
        $string .= '<p>';
        $string .= '<span class="d-block"><strong>Handle: </strong>' . $wp_scripts->registered[$script]->handle . '</span>';
        $string .= '<span class="d-block"><strong>Source: </strong>' . $wp_scripts->registered[$script]->src . '</span>';
        $string .= '</p>';
    }

    $string .= '<h2>Styles:</h2>';

    foreach ($wp_styles->queue as $style) {
        $string .= '<p>';
        $string .= '<span class="d-block"><strong>Handle: </strong>' . $wp_styles->registered[$style]->handle . '</span>';
        $string .= '<span class="d-block"><strong>Source: </strong>' . $wp_styles->registered[$style]->src . '</span>';
        $string .= '</p>';
    }

    $string .= '</div>'; // container

    return $string;
}

/**
 * Convert a string to a slug-friendly string
 * e.g. "I'm just a string!" > "im-just-a-string"
 * @param $text
 * @return mixed|string
 */
function str_to_slug($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // trim
    $text = trim($text, '-');
    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // WP Sanitize HTML Class
    $text = sanitize_html_class($text);
    // lowercase
    $text = strtolower($text);
    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

/**
 * Max charlength
 */
function max_charlength($html, $charlength = 110)
{
    $excerpt    = strip_tags($html);
    $excerptnew = '';
    $charlength++;

    if (mb_strlen($excerpt) > $charlength) {
        $subex   = mb_substr($excerpt, 0, $charlength - 5);
        $exwords = explode(' ', $subex);
        $excut   = -(mb_strlen($exwords[count($exwords) - 1]));
        if ($excut < 0) {
            $excerptnew .= mb_substr($subex, 0, $excut);
        } else {
            $excerptnew .= $subex;
        }
        $excerptnew .= '…';
    } else {
        $excerptnew .= $excerpt;
    }

    return $excerptnew;
}
