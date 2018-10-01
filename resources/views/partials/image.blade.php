@php
$id    = $id ?? get_post_thumbnail_id();
$size  = $size ?? 'medium';
$ratio = $ratio ?? '1by1';
$img   = !empty($id) ? App::get_img_object($id, $size) : null;
@endphp

@if ($img)
<figure class="ratio">
  <div class="ratio__fill--{{$ratio}}"></div>
  <img src="{{$img->placeholder}}" class="ratio__content  lazyload" data-srcset="{{$img->srcset}}" data-src="{{$img->src}}" data-sizes="auto" alt="{{$img->alt}}">
</figure>
@endif
