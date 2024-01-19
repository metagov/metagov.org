<?php snippet('header') ?>
<div class="container">
  <div class="mb-8">
    <h1 class="text-xxl"><?= $page->title()->esc() ?></h1>
    <h2 class="text-large font-serif font-normal">
      <?= $page->subHeading()->esc() ?>
    </h2>
  </div>

  <div class="mb-8 prose max-w-prose">
    <?php foreach ($page->content()->content()->toBlocks() as $block) : ?>
      <div id="<?= $block->id() ?>" class="block block-type-<?= $block->type() ?>">
        <?php snippet('blocks/' . $block->type(), [
          'block' => $block,
          'theme' => 'dark'
        ]) ?>
      </div>
    <?php endforeach ?>
  </div>
  <div class="mb-8 lg:grid lg:grid-cols-3 xl:grid-cols-3 grid-flow-row gap-4">
    <?php // splitting team into 3 equal columns by checking index against size of team.
    $index = 0;
    $teamSplit = 1;
    $splitEnd = true;
    ?>
    <?php foreach ($page->team()->split() as $role) : ?>
      <?php if ($splitEnd) : ?>
        <div>
        <?php endif ?>
        <h3 class="text-medium mb-4">
          <?= $role ?>
        </h3>
        <?php $people = $page->children()->filterBy('role', $role, ',') ?>
        <ul class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-2 gap-4">
          <?php foreach ($people as $person) : ?>
            <?php $index += 1 ?>
            <li>
              <p class="text-secondary dark:text-secondary-dark mb-0"><?= $person->title() ?></p>
              <p class="font-serif"><?= $person->affiliation() ?></p>
            </li>
          <?php endforeach ?>
        </ul>
        <?php
        if ($index > ($teamSize / 3) * $teamSplit) :
          $splitEnd = true;
          $teamSplit += 1;
        else :
          $splitEnd = false;
        endif;
        ?>
        <?php if ($splitEnd) : ?>
        </div>
      <?php endif ?>
    <?php endforeach ?>
  </div>
</div>
<hr class="border-secondary dark:border-secondary-dark" />
<section id="people">
  <div class="mb-8 md:flex justify-between items-center">
    <h3 class="text-medium mb-4">Community directory</h3>
    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4">
      <span>FILTERS:</span>
      <input class="hidden md:block search" placeholder="Search" />
      <?php snippet('blocks/filter', ['filters' => $roles, 'group' => 'role', 'label' => 'Role']) ?>
      <?php snippet('blocks/filter', ['filters' => $researchInterests, 'group' => 'researchInterests', 'label' => 'Research interests']) ?>
    </div>
  </div>

  <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 sm:gap-6 mx-auto list">
    <?php foreach ($page->children()->listed() as $person) : ?>
      <li class="cursor-pointer p-2 rounded-sm hover:outline hover:outline-brand hover:bg-brand/10" x-data="{ open : false }" @click="open = true" data-title="<?= $person->title() ?>" data-role="<?= $person->role() ?? null ?>" data-research-interests="<?= $person->interests() ?? null ?>">
        <?php
        if ($person->image()) :
          $image = $person->image();
        else :
          $image = $site->avatar();
        endif ?>
        <img class="w-full border border-brand/30 rounded mb-4" src="<?= $image->toFile()->crop(200, 200, "center")->url() ?>" srcset="<?= $image->srcset(
                                                                                                                                          [
                                                                                                                                            '1x'  => ['width' => 200, 'height' => 200, 'crop' => 'center'],
                                                                                                                                            '2x'  => ['width' => 400, 'height' => 400, 'crop' => 'center'],
                                                                                                                                            '3x'  => ['width' => 600, 'height' => 600, 'crop' => 'center'],
                                                                                                                                          ]
                                                                                                                                        ) ?>" alt="<?= $image->alt()->esc() ?>" width="<?= $image->resize(154)->width() ?>" height="<?= $image->resize(235)->height() ?>">

        <p class="text-small text-secondary dark:text-secondary-dark mb-1"><?= $person->title() ?></p>
        <p class="mb-1 italic font-serif line-clamp-1"><?= $person->affiliation() ?></p>
        <?php if ($person->role()->isNotEmpty()) : ?>
          <span class="button inline-block mb-1"><?= $person->role()->split()[0] ?></span>
        <?php endif ?>
        <div>
          <?php
          $links = $person->links()->toStructure();
          foreach ($links as $link) : ?>
            <a class="inline-block mr-2" href="<?= $link->content()->url() ?>" target="_blank">
              <?= $link->content()->text() ?>
            </a>
          <?php endforeach ?>
        </div>
        <?php snippet('modal', ['page' => $person, 'title' => $person->title(), 'subheading' => '', 'small' => 'true']) ?>
      </li>
    <?php endforeach ?>
  </ul>
  <div id="no-result" class="hidden">
    <p>No people found</p>
  </div>
  <ul class="pagination"></ul>

</section>
</div>
<?php snippet('footer') ?>

<script>
  let filters = {
    role: [],
    researchInterests: []
  }

  var options = {
    valueNames: [{
      data: ['title', 'role', 'research-interests']
    }],
    page: 40,
    pagination: true
  }

  var peopleList = new List('people', options);

  peopleList.on('updated', function(list) {
    if (list.matchingItems.length > 0) {
      document.getElementById("no-result").style.display = 'hidden'
    } else {
      document.getElementById("no-result").style.display = 'block'
    }
  });

  const updateList = () => {
    peopleList.filter(function(item) {
      let role = false
      let researchInterests = false

      if (filters.role.find((element) => item.values().role.includes(element)) || filters.role.length == 0) {
        role = true
      } else {
        role = false
      }

      if (filters.researchInterests.find((element) => item.values()['research-interests'].includes(element)) || filters.researchInterests.length == 0) {
        researchInterests = true
      } else {
        researchInterests = false
      }

      if (role && researchInterests) return true
      else return false
    })
  }

  const toggleFilter = (e) => {
    const checked = e.target.checked
    const value = e.target.dataset.value
    const group = e.target.dataset.group

    if (checked) {
      filters[group].push(value)
    } else {
      const index = filters[group].indexOf(value);
      if (index > -1) {
        filters[group].splice(index, 1);
      }
    }

    console.log(filters)

    updateList()
  }
</script>