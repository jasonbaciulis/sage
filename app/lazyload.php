<?php

/**
 * Prepare content images for lazyloading using lazysizes.js.
 * One of the best things about lazysizes.js is that you don't have to worry about
 * calculating sizes as lazysizes takes care of that. All we need to do is add
 * "auto" to data-sizes attribute as we're doing bellow.
 *
 * @link https://github.com/aFarkas/lazysizes
 */

add_filter('the_content', function ($content) {
    if (empty($content)) {
        return $content;
    }

    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($content);
    libxml_clear_errors();

    foreach ($dom->getElementsByTagName('img') as $img) {
        if ($img->hasAttribute('srcset')) {
            $sizes = 'auto';
            $classes = $img->getAttribute('class');
            $src = $img->getAttribute('src');
            $srcset = $img->getAttribute('srcset');
            $width = $img->getAttribute('width');
            $height = $img->getAttribute('height');
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
}, 20, 1);
