<div class="container max-w-3xl py-4" x-data="{ participate: false }" x-init="setTimeout(() => participate = false, 5000)">
  <div class="mb-8">
    <!-- Nav -->
    <div class="mb-8 flex flex-wrap">
      <div class="flex-auto text-left">
        <a href="<?= $page->parent()->url() ?>">&larr; All projects</a>
      </div>
    </div>
    <!-- End Nav -->

    <div class="mb-2 flex gap-4 items-center">
     
      <h1 class="text-xxl">
        <?= $page->title()->esc() ?>
      </h1>

      <?php foreach ($page->project_status()->split() as $key => $status) : ?>
        <?php if ($key == 0) : ?>
          <span class="tag active"><?= $status ?></span>
        <?php else : ?>
          <span class="tag secondary active"><?= $status ?></span>
        <?php endif ?>
      <?php endforeach ?>
      <?php if ($page->seeking_participants()->toBool()) : ?>
        <a href="#participate" class="tag secondary active block" @click="participate = true">✅ SEEKING PARTICIPANTS</a>
      <?php endif ?>
    </div>
    <h2 class="text-large">
      <?= $page->subheading()->esc() ?>
    </h2>
  </div>

  <?php if ($page->cover()->isNotEmpty()) : ?>
    <img class="mb-8 border border-brand shadow-window hover:shadow-windowhover transition-[opacity,box-shadow]" src="<?= $page->cover()->toFile()->url() ?>" alt="<?= $page->cover()->toFile()->alt()->esc() ?>">
  <?php endif ?>

  <article>

    <!-- Project meta -->
    <div class="mb-8 grid md:grid-cols-3 md:justify-evenly gap-6">
      <div>
        <?php if ($page->links()->isNotEmpty()) : ?>
          <h5 class="mb-2">LINKS</h5>
          <div>
            <?php
            $links = $page->links()->toStructure();
            foreach ($links as $link) : ?>
              <a class="inline-block mr-2" href="<?= $link->content()->url() ?>" target="_blank">
                <?= $link->content()->text() ?>
              </a>
            <?php endforeach ?>
          </div>
        <?php endif ?>
      </div>
      <div class="space-y-1">
        <?php if ($page->type()->isNotEmpty()) : ?>
          <h5 class="mb-2">PROJECT TYPE</h5>
          <?php foreach ($page->type()->split() as $type) : ?>
            <span class="tag"><?= $type ?></span>
          <?php endforeach ?>
        <?php endif ?>
      </div>
      <div>
        <?php if ($page->contact()->isNotEmpty()) : ?>
          <div class="mb-8">
            <h5 class="mb-2">PRINCIPAL CONTACT</h5>
            <?= Html::email($page->contact()) ?>
          </div>
        <?php endif ?>
        <?php if ($page->research_directors()->isNotEmpty()) : ?>
          <div class="mb-8">
            <h5 class="mb-2">RESEARCH DIRECTORS</h5>
            <?php 
              $researchDirectors = $page->research_directors()->toUsers();
              foreach ($researchDirectors as $person) : ?>
              <a class="inline-block mr-2" href="/members/<?= Str::slug($person->username()) ?>"><?= $person->name() ?></a>
            <?php endforeach ?>
          </div>
        <?php endif ?>
        <?php if ($page->members()->isNotEmpty()) : ?>
          <div>
            <h5 class="mb-2">CONTRIBUTORS</h5>
            <?php
            $participants =  $page->members()->toPages();
            foreach ($participants as $person) : ?>
              <a class="inline-block mr-2" href="/people/<?= $person->slug() ?>"><?= $person->title() ?></a>
            <?php endforeach ?>
          </div>
        <?php endif ?>

      </div>
    </div>



    <!-- Project body -->
    <?php if ($page->description()->isNotEmpty()) : ?>
      <div class="mb-8">
        <h5>DESCRIPTION</h5>
        <div class="prose">
          <?= $page->description()->kt() ?>
        </div>
      </div>
    <?php endif ?>

    <?php if ($page->seeking_participants()->toBool()) : ?>
      <div id="participate" class="mb-8" :class="{ 'highlight-section': participate }">
        <h5>PATHS TO PARTICIPATION</h5>
        <div class="prose">
          <?= $page->participate()->kt() ?>
        </div>
      </div>
    <?php endif ?>

    <?php if ($page->meetings()->isNotEmpty()) : ?>
      <div>
        <h5>DISCUSSION FORUM</h5>
        <div class="prose">
          <?= $page->meetings()->kt() ?>
        </div>
      </div>
    <?php endif ?>

    <hr />

    <!-- Nav -->
    <div class="flex flex-wrap">
      <div class="flex-auto text-left">
        <?php
        $collection = $page->siblings()->sortBy('title', 'asc');
        if ($prev = $page->prevListed($collection)) : ?>
          &larr; <a href="<?= $prev->url() ?>"><?= $prev->title() ?></a>
        <?php endif ?>
      </div>

      <div class="flex-auto text-center">
        <a href="<?= $page->parent()->url() ?>">All projects</a>
      </div>

      <div class="flex-auto text-right">
        <?php
        $collection = $page->siblings()->sortBy('title', 'asc');
        if ($next = $page->nextListed($collection)) : ?>
          <a href="<?= $next->url() ?>"><?= $next->title() ?></a> &rarr;
        <?php endif ?>
      </div>
    </div>
    <!-- End Nav -->


  </article>

</div>