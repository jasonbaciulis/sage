@php
/**
 * You can reuse this partial by passing an array of data when calling @include
 * @param string $img_id
 * @param string $bg_image_class - modifier class for background image div
 * Example bellow passes img id from ACF plugin
 *
 * @example @include('partials/image-background', ['img_id' => get_field('bg_image_masthead'), 'bg_image_class' => 'c-bg-image--masthead'])
 */

// $lqip         = App::get_img_src($img_id, 'lqip');          // Low quality image placeholder
// $mobile       = App::get_img_src($img_id, 'mobile');        // Custom
// $tablet       = App::get_img_src($img_id, 'medium_large');  // WP default
// $tablet_large = App::get_img_src($img_id, 'large');         // WP default
// $laptop       = App::get_img_src($img_id, 'laptop');        // Custom
// $fullhd       = App::get_img_src($img_id, 'fullhd');        // Custom
@endphp

<div class="container-fluid  u-overflow-hidden">
  <div class="c-bg-image  js-bg-image" style="background-image: url({{ App::lqip($bg_image_masthead) }})">
    <img src="{{ App::get_img_src($bg_image_masthead, 'fullhd') }}" style="display:none"
      sizes="100vw"
      srcset="{{ App::get_img_srcset($bg_image_masthead) }}">
  </div>
</div>
