<ul class="c-list-icons">
  <li class="c-list-icons__item">
    <a href="{{$social->linkedin}}" class="c-list-icons__link" target="_blank" rel="noopener">
      @include('partials/icon', ['id' => 'icon-linkedin', 'class' => 'o-center c-list-icons__svg'])
      <span class="sr-only">Linkedin</span>
    </a>
  </li>

  <li class="c-list-icons__item">
    <a href="{{$social->twitter}}" class="c-list-icons__link" target="_blank" rel="noopener">
      @include('partials/icon', ['id' => 'icon-twitter', 'class' => 'o-center c-list-icons__svg'])
      <span class="sr-only">Twitter</span>
    </a>
  </li>

  <li class="c-list-icons__item">
    <a href="{{$social->facebook}}" class="c-list-icons__link" target="_blank" rel="noopener">
      @include('partials/icon', ['id' => 'icon-facebook', 'class' => 'o-center c-list-icons__svg'])
      <span class="sr-only">Facebook</span>
    </a>
  </li>

  <li class="c-list-icons__item">
    <a href="{{$social->google_plus}}" class="c-list-icons__link" target="_blank" rel="noopener">
      @include('partials/icon', ['id' => 'icon-google-plus', 'class' => 'o-center c-list-icons__svg'])
      <span class="sr-only">Google Plus</span>
    </a>
  </li>
</ul>
