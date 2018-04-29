@php
$id      = get_post_thumbnail_id();
$img_alt = is_singular() ? get_post_meta($id, '_wp_attachment_image_alt', true): 'Go to ' . get_the_title();
$lqip    = App::get_img_src($id, 'lqip');           // Low quality image placeholder
$mobile  = App::get_img_src($id, 'mobile');         // Custom
$tablet  = App::get_img_src($id, 'medium_large');   // WP default
$index   = App::get_img_src($id, 'featured-index'); // Custom
@endphp

<figure class="o-featured-media">
  <div class="o-aspect-ratio">
    <div class="o-aspect-ratio__fill--full-hd"></div>
    @if (!is_singular())
      <a href="{{ get_permalink() }}" rel="bookmark">
        <img src="{{$lqip}}" class="o-aspect-ratio__content  lazyload" alt="{{$img_alt}}"
        data-sizes="auto"
        data-srcset="
        {{$mobile}} 480w,
        {{$tablet}} 768w,
        {{$index}} 800w">
      </a>
    @else
      <img src="{{$lqip}}" class="o-aspect-ratio__content  lazyload" alt="{{$img_alt}}"
        data-sizes="auto"
        data-srcset="
        {{$mobile}} 480w,
        {{$tablet}} 768w,
        {{$index}} 800w">
    @endif
  </div>
</figure>
