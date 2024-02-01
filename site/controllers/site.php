<?php

return function ($page, $pages, $site, $kirby) {
  $titleTag = $page->title() . " | " . $site->title();
  $metaDescription = $page->subheading()->excerpt(120);
  $metaImage = $site->seoImage()->toFile()->resize(1200, 630)->url();
  if ($page->cover()->isNotEmpty())
    $metaImage = $page->cover()->toFile()->resize(1200, 630)->url();
  $ajax = $kirby->request()->header('Hx-Request', null);
  return compact('titleTag', 'metaDescription', 'metaImage', 'ajax');
};
