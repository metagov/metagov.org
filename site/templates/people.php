<?php snippet('header') ?>
<div class="container max-w-[1088px] py-8">
  <div class="mb-8">
    <h1 class="text-xxl"><?= $page->title()->esc() ?></h1>
    <h2 class="text-large font-normal">
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
  
  <div class="mb-8">
    <div class="flex flex-wrap -mx-4">
      <?php foreach ($page->team()->split() as $role) : ?>
        <div class="w-full md:w-1/2 px-4 mb-8">
          <div class="prose">
            <h4><?= $role ?></h4>
          </div>

          <?php $people = $page->children()->filterBy('role', $role, ',') ?>
          <ul class="grid grid-cols-1 gap-2">
            <?php foreach ($people as $person) : ?>
              <li>
                <p class="mb-0">
                  <a href="/people/<?= $person->slug() ?>" class="text-secondary dark:text-secondary-dark mb-0"><?= $person->title() ?></a>
                  <span class="text-tag italic leading-4"><?= $person->affiliation() ?></span>
                </p>
              </li>
            <?php endforeach ?>
          </ul>
        </div>
      <?php endforeach ?>
    </div>
  </div>


<hr class="border-secondary dark:border-secondary-dark" />

<section id="people">
  <div class="mb-8 lg:flex justify-between items-center">
    <h3 class="text-medium mb-4">Directory</h3>
    <div class="flex flex-col lg:flex-row lg:items-center gap-2 md:gap-4">
      <span>FILTERS:</span>
      <input class="w-full md:w-1/2 lg:w-auto search" placeholder="Search" />
      <?php snippet('blocks/filter', ['filters' => $roles, 'group' => 'role', 'label' => 'Role']) ?>
      <?php snippet('blocks/filter', ['filters' => $researchInterests, 'group' => 'researchInterests', 'label' => 'Research interests']) ?>
    </div>
  </div>

  <ul class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6 mx-auto list">
    <?php $lastImage = "" ?>
    <?php foreach ($page->children()->listed() as $person) : ?>
      <li class="cursor-pointer p-2 rounded-sm hover:outline hover:outline-brand hover:bg-brand/10" x-data="{ openPerson : false }" @click="openPerson = true" data-title="<?= $person->title() ?>" data-role="<?= $person->role() ?? null ?>" data-research-interests="<?= $person->interests() ?? null ?>">
        <?php
        do {
          $image = $page->avatars()->toFiles()->shuffle()->first();
        } while ($lastImage == $image);
        $lastImage = $image;
        if ($person->image()) :
          $image = $person->image();
        endif  ?>
        <img class="w-full border border-brand/30 rounded mb-4" src="<?= $image->crop(300, 300, "center")->url() ?>" srcset="<?= $image->srcset(
                                                                                                                                [
                                                                                                                                  '1x'  => ['width' => 300, 'height' => 300, 'crop' => 'center'],
                                                                                                                                  '2x'  => ['width' => 600, 'height' => 600, 'crop' => 'center'],
                                                                                                                                  '3x'  => ['width' => 900, 'height' => 900, 'crop' => 'center'],
                                                                                                                                ]
                                                                                                                              ) ?>" alt="<?= $image->alt()->esc() ?>" width="<?= $image->resize(154)->width() ?>" height="<?= $image->resize(235)->height() ?>">

        <p class="text-small text-secondary dark:text-secondary-dark mb-1"><?= $person->title() ?></p>
        <p class="text-tag italic mb-2"><?= $person->affiliation() ?></p>
        
        <?php if ($person->role()->isNotEmpty()) : ?>
          <span class="button inline-block mb-2"><?= $person->role()->split()[0] ?></span>
        <?php endif ?>

        <p class="text-tag">
          <?php
          $links = $person->links()->toStructure();
          foreach ($links as $link) : ?>
            <a class="inline-block mr-2" href="<?= $link->content()->url() ?>" target="_blank">
              <?= $link->content()->text() ?>
            </a>
          <?php endforeach ?>
        </p>

        <?php snippet('modal-person', ['page' => $person, 'title' => $person->title(), 'subheading' => '', 'small' => 'true', 'image' => $image]) ?>
      </li>
    <?php endforeach ?>
  </ul>

  <div id="no-result" class="hidden">
    <p class="text-center py-8">No people found</p>
  </div>
  
  <ul class="pagination justify-center"></ul>

</section>
</div>


<?php snippet('footer') ?>

<script>
  var filters = {
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
      document.getElementById("no-result").classList.add('hidden');
    } else {
      document.getElementById("no-result").classList.remove('hidden');
    }
  });

  var updateList = () => {
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

  var toggleFilter = (e) => {
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

    updateList()
  }
</script>