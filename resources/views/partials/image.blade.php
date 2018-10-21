@php
$id   = $id ?? get_post_thumbnail_id();
$size = $size ?? 'full';
$img  = App::get_img_object($id, $size) ?? null;
@endphp

@isset($img)
  <figure class="o-ratio">
    <div style="padding-bottom:{{$img->ratio_percent}}"></div>
    <img src="{{$img->placeholder}}" class="o-ratio__content  lazyload" data-srcset="{{$img->srcset}}" data-src="{{$img->src}}" data-sizes="auto" alt="{{$img->alt}}">
  </figure>
@endisset
