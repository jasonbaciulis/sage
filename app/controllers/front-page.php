<?php

namespace App;

use Sober\Controller\Controller;

class FrontPage extends Controller
{
    // Set up to pull in ACF plugin fields as variables
    public function product_intro_heading() {
        return get_field('product_intro_heading');
    }

    public function product_intro_description() {
        return get_field('product_intro_description');
    }

    public function product_intro_image() {
        return get_field('product_intro_image');
    }

    public function product_price() {
        return get_field('product_price');
    }
}
