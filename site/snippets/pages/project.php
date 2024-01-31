<div class="container max-w-3xl pb-16" x-data="{ participate: false }" x-init="setTimeout(() => participate = false, 5000)">
  <div class="mb-8">
    <div class="mb-2 flex gap-4 items-center">
      <h1 class="text-xxl"><?= $page->title()->esc() ?></h1>
      <?php foreach ($page->projectStatus()->split() as $key => $status) : ?>
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
    <h2 class="font-serif text-large">
      <?= $page->subheading()->esc() ?>
    </h2>
  </div>

  <?php if ($page->cover()->isNotEmpty()) : ?>
    <img class="mb-8" src="<?= $page->image()->url() ?>" alt="<?= $page->image()->alt()->esc() ?>">
  <?php endif ?>

  <article>

    <!-- Project meta -->
    <div class="mb-8 grid grid-cols-3 justify-evenly gap-6">
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
          <div class="mb-4">
            <h5 class="mb-2">PRINCIPLE CONTACT</h5>
            <?= Html::email($page->contact()) ?>
          </div>
        <?php endif ?>
        <?php if ($page->members()->isNotEmpty()) : ?>
          <div>
            <h5 class="mb-2">MEMBERS</h5>
            <?php
            $members =  $page->members()->toPages();
            foreach ($members as $member) : ?>
              <p><?= $member->title() ?></p>
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

    <?php if ($page->participate()->isNotEmpty()) : ?>
      <div id="participate" class="mb-8" :class="{ 'highlight-section': participate }">
        <h5>PATHS TO PARTICIPATION</h5>
        <div class="prose">
          <?= $page->participate()->kt() ?>
        </div>
      </div>
    <?php endif ?>

    <?php if ($page->participate()->isNotEmpty()) : ?>
      <div class="mb-8">
        <h5>DISCUSSION FORUM</h5>
        <div class="prose">
          <?= $page->discussion_forum()->kt() ?>
        </div>
        <!-- <div class="relative mb-8 mt-1 border-t border-t-brand overflow-hidden">
          <div class="border border-brand border-t-0" style="position: relative; top: -55px">
            <iframe class="w-full aspect-video invert dark:invert-0" src="https://www.linen.dev/s/metaproxy/c/general"></iframe>
          </div>
          <div class="grid absolute place-content-center bottom-12 left-0 w-full h-20 z-50 m-1">
            <span class="tag w-fit active">
              JOIN THE COMMUNITY
            </span>
          </div>
        </div> -->
      </div>
    <?php endif ?>

    <?php if ($page->meetings()->isNotEmpty()) : ?>
      <div>
        <h5>MEETINGS</h5>
        <div class="prose">
          <?= $page->meetings()->kt() ?>
        </div>
      </div>
    <?php endif ?>

  </article>
</div>