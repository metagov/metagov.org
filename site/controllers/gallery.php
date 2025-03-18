<?php

return function ($page, $pages, $site, $kirby) {
  $shared = $kirby->controller('site', compact('page', 'pages', 'site', 'kirby'));
  $categories = $page->children()->pluck("category", ",", true);
  $stages = $page->children()->pluck("stage", ",", true);

  return A::merge($shared, compact('categories', 'stages', /*, 'types', 'status', 'seekingParticipants' */));
};
