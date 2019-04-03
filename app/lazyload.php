<?php

/**
 * Prepare content images for lazyloading using lazysizes.js.
 * One of the best things about lazysizes.js is that you don't have to worry about
 * calculating sizes as lazysizes takes care of that. All we need to do is add
 * "auto" to data-sizes attribute as we're doing bellow.
 *
 * @link https://github.com/aFarkas/lazysizes
 */

function lazyload_content_images($content)
{
    if (empty($content)) {
        return $content;
    }

    // converts all special characters to utf-8
    $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');

    $dom = new \DOMDocument('1.0', 'utf-8');
    libxml_use_internal_errors(true);
    // it loads the content without adding enclosing html/body tags and also the doctype declaration
    $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();

    foreach ($dom->getElementsByTagName('img') as $img) {
        if ($img->hasAttribute('srcset')) {
            $sizes   = 'auto';
            $classes = $img->getAttribute('class');
            $src     = $img->getAttribute('src');
            $srcset  = $img->getAttribute('srcset');
            $width   = $img->getAttribute('width');
            $height  = $img->getAttribute('height');
            // Calculate aspect ratio for lazysizes plugin to size image correctly
            $aspectratio = "$width/$height";
            $classes .= ' lazyload';

            $img->setAttribute('src', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');
            $img->setAttribute('data-src', $src);
            $img->setAttribute('data-srcset', $srcset);
            $img->setAttribute('data-sizes', $sizes);
            $img->setAttribute('data-aspectratio', $aspectratio);
            $img->setAttribute('class', $classes);

            $img->removeAttribute('sizes');
            $img->removeAttribute('srcset');

            $content = $dom->saveHTML();
        }
    }

    return $content;
}

add_filter('the_content', __NAMESPACE__ . '\\lazyload_content_images', 20, 1);
add_filter('acf_the_content', __NAMESPACE__ . '\\lazyload_content_images', 20, 1);
