<header class="c-navbar">
  <div class="container">
    <div class="d-flex  align-items-center  justify-content-lg-between">

      <a href="{{home_url('/')}}" class="c-navbar__brand" rel="home" aria-label="Home link">
        {{-- <svg class="logo"></svg> --}}
        <span class="sr-only">{{get_bloginfo('name', 'display')}}</span>
      </a>

      <button class="c-hamburger  c-hamburger--slider  js-hamburger" type="button" aria-controls="nav-primary" aria-expanded="false" aria-label="Toggle navigation">
        <span class="c-hamburger__box">
          <span class="c-hamburger__inner"></span>
        </span>
      </button>

      <nav id="nav-primary" class="c-nav-primary">
        @if (has_nav_menu('primary_navigation'))
          {!! App\bem_nav_menu( 'primary_navigation', 'c-primary-nav', 'c-primary-nav__list' ) !!}
        @endif
      </nav>

    </div>
  </div>
</header>
