<?php

return function ($page, $pages, $site, $kirby) {
  $shared = $kirby->controller('site', compact('page', 'pages', 'site', 'kirby'));
  $roles = $page->children()->pluck("role", ",", true);
  $researchInterests = $page->children()->pluck("interests", ",", true);
  $teamSize = 0;
  foreach ($page->team()->split() as $role) :   // get total size of team
    $people = $page->children()->filterBy('role', $role, ',');
    foreach ($people as $person) :
      $teamSize += 1;
    endforeach;
  endforeach;
  return A::merge($shared, compact('roles', 'researchInterests', 'teamSize'));
};
