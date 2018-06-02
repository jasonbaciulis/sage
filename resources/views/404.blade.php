@extends('layouts.app')

@section('content')

<section class="o-section  o-section--404">
  <div class="container">
    <div class="row  justify-content-center">
      <div class="col-12  col-lg-7  u-text-center">
        <h1>404</h1>
        <p class="c-lead">{{ __('Sorry, but the page you were trying to view does not exist.', 'sage') }}</p>
        <p class="c-lead">{{ __('Why don\'t you try the homepage?', 'sage') }}</p>
        <a href="{{ home_url('/') }}" class="c-btn  c-btn--primary">{{ __('Go to homepage', 'sage')}}</a>
      </div>
    </div>
  </div>
</section>

@endsection
