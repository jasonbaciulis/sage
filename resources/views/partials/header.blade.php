<header class="banner">
  <div class="container">
    <nav class="navbar navbar-expand-md navbar-light">

      <a class="brand" href="{{ home_url('/') }}" rel="home" aria-label="Home link">
        <svg class="logo"></svg>
        <span class="sr-only">{{ get_bloginfo('name', 'display') }}</span>
      </a>

      <button class="c-hamburger  c-hamburger--slider  js-hamburger" type="button" aria-controls="bs4navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="c-hamburger__box">
          <span class="c-hamburger__inner"></span>
        </span>
      </button>

      @if (has_nav_menu('primary_navigation'))
        {!! App\bem_nav_menu( 'primary_navigation', 'c-primary-nav', 'c-primary-nav__list' ) !!}
      @endif

    </nav>
  </div>
</header>
