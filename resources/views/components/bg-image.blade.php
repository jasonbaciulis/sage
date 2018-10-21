<section class="c-bg-image {{$class ?? ''}} js-bg-image">
  <img src="{{App::get_img_src($image, 'full')}}" style="display:none" sizes="100vw" srcset="{{App::get_img_srcset($image, 'full')}}">
  <div class="container">
    {!! $slot !!}
  </div>
</section>
