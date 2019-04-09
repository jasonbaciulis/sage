@php
$description = urlencode(App::currentPageMetaDescription(get_the_ID()))
$twitter_profile = 'JasonBaciulis';
@endphp

<ul class="c-list-sharing">
  <li>
    <a href="https://plus.google.com/share?url={{ $current_url_encoded }}" target="_blank" title="Share on Google+">
      <i class="fa fa-google-plus" aria-hidden="true"></i>
      <span class="sr-only">Share on Google+</span>
    </a>
  </li>
  <li>
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $current_url_encoded }}&quote={{ $current_page_title }}" target="_blank" title="Share on Facebook">
      <i class="fa fa-facebook-official" aria-hidden="true"></i>
      <span class="sr-only">Share on Facebook</span>
    </a>
  </li>
  <li>
    <a href="http://www.linkedin.com/shareArticle?mini=true&url={{ $current_url_encoded }}&title={{ $current_page_title }}&summary{{ $description }}=&source={{ $current_url_encoded }}" target="_blank" title="Share on LinkedIn">
      <i class="fa fa-linkedin" aria-hidden="true"></i>
      <span class="sr-only">Share on LinkedIn</span>
    </a>
  </li>
  <li>
    <a href="https://twitter.com/intent/tweet?source={{ $current_url_encoded }}&text={{ $current_page_title }}:%20{{ $current_url_encoded }}&via={{ $twitter_profile }}" target="_blank" title="Tweet">
      <i class="fa fa-twitter" aria-hidden="true"></i>
      <span class="sr-only">Tweet</span>
    </a>
  </li>
</ul>
