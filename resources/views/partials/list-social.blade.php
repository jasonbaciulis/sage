@php
/**
 * Pulls social links from functions setup in app/controllers/app.php
 */
@endphp

<ul class="c-social-list">
  <li class="c-social-list__item">
    <a href="{{ $url_social_facebook }}" target="_blank" rel="noopener">
      <i class="fas fa-facebook" aria-hidden="true"></i>
      <span class="sr-only">Facebook</span>
    </a>
  </li>

  <li class="c-social-list__item">
    <a href="{{ $url_social_twitter }}" target="_blank" rel="noopener">
      <i class="fas fa-twitter" aria-hidden="true"></i>
      <span class="sr-only">Twitter</span>
    </a>
  </li>
</ul>
