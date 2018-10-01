<section class="bg-image {{ $class ?? '' }}" style="background-image:linear-gradient()">
  <img src="{{ App::get_img_src($image, 'fullhd') }}" style="display:none" sizes="100vw" srcset="{{ App::get_img_srcset($image) }}">
  <div class="container">
    {!! $slot !!}
  </div>
</section>
