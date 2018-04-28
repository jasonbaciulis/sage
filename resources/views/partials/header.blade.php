<header class="banner">
  <div class="container">
    <nav class="navbar navbar-expand-md navbar-light">
      <a class="brand" href="{{ home_url('/') }}" rel="home" aria-label="Home link">
        <svg class="logo"></svg>
        <span class="sr-only">{{ get_bloginfo('name', 'display') }}</span>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs4navbar" aria-controls="bs4navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu($primary_menu) !!}
      @endif
    </nav>
  </div>
</header>
