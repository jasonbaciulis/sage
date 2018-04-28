<?php

/**
 * Prepare content images for lazyloading using lazysizes.js.
 * One of the best things about lazysizes.js is that you don't have to worry about
 * calculating sizes as lazysizes takes care of that. All we need to do is add
 * "auto" to data-sizes attribute as we're doing bellow.
 *
 * More about lazysizes.js: https://github.com/aFarkas/lazysizes
 */

add_filter( 'the_content',  function ($content) {
    if ( empty( $content ) ) {
       return $content;
    }

    $dom = new DOMDocument();
    libxml_use_internal_errors( true );
    $dom->loadHTML( $content );
    libxml_clear_errors();

    foreach ( $dom->getElementsByTagName( 'img' ) as $img ) {
        if ( $img->hasAttribute( 'srcset' ) ) {

            $sizes = 'auto';
            $classes = $img->getAttribute( 'class' );
            // Extract id number which is added as class by WP to be able to retrieve attachment image src
            $id = preg_replace('/[^0-9]/', '', $classes);
            // Select low quality image placeholder src
            $lqip = App::get_img_src($id, 'lqip');
            $srcset = $img->getAttribute( 'srcset' );
            $width = $img->getAttribute( 'width' );
            $height = $img->getAttribute( 'height' );
            // Calculate aspect ratio for lazysizes plugin to size image correctly
            $aspectratio = "$width/$height";
            $classes .= ' lazyload';

            $img->setAttribute( 'src', $lqip );
            $img->setAttribute( 'data-aspectratio', $aspectratio );
            $img->setAttribute( 'data-sizes', $sizes );
            $img->setAttribute( 'data-srcset', $srcset );
            $img->setAttribute( 'class', $classes );

            $img->removeAttribute( 'sizes' );
            $img->removeAttribute( 'srcset' );

            $content = $dom->saveHTML();
       }
    }
    return $content;
}, 20, 1);
