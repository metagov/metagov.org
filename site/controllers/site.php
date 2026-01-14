<?php

return function ($page, $pages, $site, $kirby) {
  $titleTag = $page->title() . " | " . $site->title();
  $metaDescription = $page->subheading()->excerpt(120);
  
  // Set default meta image to cover.png
  $metaImage = url('cover.png');
  
  // Try to get SEO image from site settings
  if ($site->seoImage()->isNotEmpty()) {
    $metaImage = $site->seoImage()->toFile()->resize(1200, 630)->url();
  }
  
  // Override with page cover if available
  if ($page->cover()->isNotEmpty()) {
    $metaImage = $page->cover()->toFile()->resize(1200, 630)->url();
  }
  
  $ajax = $kirby->request()->header('Hx-Request', null);
  return compact('titleTag', 'metaDescription', 'metaImage', 'ajax');
};
