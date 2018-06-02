@php
/**
 * Calls function names as variables from the controller
 * @see app/controllers/app.php
 */
@endphp

<ul class="c-list-icons">
  <li class="c-list-icons__item">
    <a href="{{ $social->facebook }}" target="_blank" rel="noopener">
      <i class="fab fa-facebook" aria-hidden="true"></i>
      <span class="sr-only">Facebook</span>
    </a>
  </li>

  <li class="c-list-icons__item">
    <a href="{{ $social->twitter }}" target="_blank" rel="noopener">
      <i class="fab fa-twitter" aria-hidden="true"></i>
      <span class="sr-only">Twitter</span>
    </a>
  </li>
</ul>
