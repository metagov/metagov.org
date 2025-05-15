<?php
 
class MembersPage extends Page {
  public function children(): Pages
  {
      if ($this->children instanceof Pages) {
          return $this->children;
      }

    $pages = [];
    $users = kirby()->users();
    foreach ($users as $key => $user) {
      $pages[] = [
        'slug' => Str::slug($user->username()),
        'num' => $user->indexOf($users),
        'template' => 'person',
        'model' => 'member',
        'content' => [
          'slug' => Str::slug($user->username()),
          'name' => $user->username(),
          'email' => $user->email(),
          'affiliation' => $user->affiliation(),
          'image' => $user->image(),
          'bio' => $user->bio(),
          'links' => $user->links()->toStructure()->toArray(),
          'interest' => $user->interests(),
          'contributions' => $user->contributions(),
          'role' => $user->role(),
          'projects' => $user->projects(),
          'offering_mentorship' => $user->offering_mentorship(),
          'seeking_mentorship' => $user->seeking_mentorship(),
          'date_joined' => $user->date_joined(),
          'public' => $user->public()
        ]
      ];
    }

    return $this->children = Pages::factory($pages, $this);
  }
}
