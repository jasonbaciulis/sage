<?php

namespace App;

use Sober\Controller\Controller;

class Blog extends Controller
{
    public static function the_excerpt_max_charlength($charlength = 165) {
        $excerpt = get_the_excerpt();
        $excerptnew ='';
        $charlength++;

        if ( mb_strlen( $excerpt ) > $charlength ) {
        	$subex = mb_substr( $excerpt, 0, $charlength - 5 );
          	$exwords = explode( ' ', $subex );
          	$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
          	if ( $excut < 0 ) {
            	$excerptnew .= mb_substr( $subex, 0, $excut );
          	} else {
            	$excerptnew .= $subex;
        	}
         	$excerptnew .= '…';
        } else {
          	$excerptnew .= $excerpt;
        }
        // return strip_tags($excerptnew, '<a>');
        return $excerptnew;
    }
}
