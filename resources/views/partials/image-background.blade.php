@php
/**
 * You can reuse this partial by passing an array of data when calling @include
 * @param string $img_id
 * @param string $bg_image_class - modifier class for background image div
 * Example bellow passes img id from ACF plugin
 *
 * @example @include('partials/image-background', ['img_id' => get_field('bg_image_masthead'), 'bg_image_class' => 'c-resp-bg-image--masthead'])
 */

$lqip         = App::get_img_src($img_id, 'lqip');          // Low quality image placeholder
$mobile       = App::get_img_src($img_id, 'mobile');        // Custom
$tablet       = App::get_img_src($img_id, 'medium_large');  // WP default
$tablet_large = App::get_img_src($img_id, 'large');         // WP default
$laptop       = App::get_img_src($img_id, 'laptop');        // Custom
$fullhd       = App::get_img_src($img_id, 'fullhd');        // Custom
@endphp

<div class="u-overflow-hidden">
  <div class="o-resp-bg-image  <?= $bg_image_class ?>  js-resp-bg-image" style="background-image: url({{ $lqip }})">
    <img src="{{ $fullhd }}" style="display:none"
      sizes="100vw"
      srcset="
        {{$mobile}} 480w,
        {{$tablet}} 768w,
        {{$tablet_large}} 1024w,
        {{$laptop}} 1366w,
        {{$fullhd}} 1920w">
  </div>
</div>
