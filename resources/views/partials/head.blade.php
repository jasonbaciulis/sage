<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- Preload logo to show it ASAP
    @see https://images.guide/#preload-critical-image-assets   --}}
  <link rel="preload" as="image" href="@asset('images/logo.svg')" />
  @php wp_head() @endphp
</head>
