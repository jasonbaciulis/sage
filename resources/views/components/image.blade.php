@php $image = App::getImage($image_id ?? get_post_thumbnail_id(), $size ?? 'full') @endphp

@unless(empty($image))
  <figure class="o-ratio @unless(empty($class)) {{ $class }} @endunless">
    <div style="padding-bottom:{{ $image->ratio_percent }}"></div>
    <img
      src="{{ $image->placeholder }}"
      class="o-ratio__content lazy"
      data-srcset="{{ $image->srcset }}"
      data-src="{{ $image->src }}"
      data-sizes="auto"
      alt="{{ $image->alt }}">
  </figure>
@endunless
