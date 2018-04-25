<?php

/**
 * Prepare content images for lazyloading using lazysizes library.
 * One of the best things about lazysizes is that you don't have to worry about
 * calculating sizes as lazysizes takes care of that. All we need to do is add
 * "auto" to data-sizes attribute as we're doing bellow.
 *
 * More about lazysizes: https://github.com/aFarkas/lazysizes
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
            $srcset = $img->getAttribute( 'srcset' );
            $classes = $img->getAttribute( 'class' );
            // Extract id number which is added as class by WP
            $id = preg_replace('/[^0-9]/', '', $classes);
            // Select low quality image placeholder src
            $lqip = wp_get_attachment_image_src($id, 'lqip');
            $lqip = $lqip[0];
            $classes .= ' lazyload';

            $img->setAttribute( 'src', $lqip );
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
