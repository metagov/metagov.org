<?php

return function ($site, $kirby) {
    // BUG WIP: $user needs to be changed from the logged in user (which is Admin, when setting a Director's permissions), to the active Director role being created. If that Director has a personPage set, then they should be able to access it. Create a new collection here to include it with the collection of all projects. 

    // Get the logged-in user
    $user = $kirby->user();

    // Retrieve the personPage linked to the user
    $personPage = $user ? $user->personPage()->toPage() : null;

    // Get the project pages
    $projectPages = $site->find('projects')->children();

    // If we have a personPage, create a proper collection and merge
    if ($personPage) {
        // Create a new Pages collection with the single personPage
        $personPageCollection = new Kirby\Cms\Pages([$personPage]);
        
        // Merge the collections and return (reversed order)
        return $personPageCollection->merge($projectPages);
    }

    // If no personPage exists, just return project pages
    return $projectPages;
};
