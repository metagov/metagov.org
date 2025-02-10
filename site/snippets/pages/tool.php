<div class="container max-w-3xl py-4" x-data="{ participate: false }" x-init="setTimeout(() => participate = false, 5000)">
  <div class="mb-8">
    <!-- Nav -->
    <div class="mb-8 flex flex-wrap">
      <div class="flex-auto text-left">
        <a href="<?= $page->parent()->url() ?>">&larr; Deliberative Tool Gallery</a>
      </div>
    </div>
    <!-- End Nav -->

    <div class="mb-2 flex gap-4 items-center">
      <h1 class="text-xxl full-width"><?= $page->title()->esc() ?></h1>
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
    <div class="mb-16 grid md:grid-cols-3 md:justify-evenly gap-6">
      <?php if ($page->stage()->isNotEmpty()) : ?>
        <div class="space-y-1">
          <h5 class="mb-2">Stage</h5>
          <?php foreach ($page->stage()->split() as $stage) : ?>
            <span class="tag"><?= $stage ?></span>
          <?php endforeach ?>
        </div>
      <?php endif ?>
      <?php if ($page->function()->isNotEmpty()) : ?>
        <div class="space-y-1">
          <h5 class="mb-2">Function</h5>
          <?php foreach ($page->function()->split() as $function) : ?>
            <span class="tag"><?= $function?></span>
          <?php endforeach ?>
        </div>
      <?php endif ?>
      <?php if ($page->license()->isNotEmpty()) : ?>
        <div class="space-y-1">
          <h5 class="mb-2">License</h5>
          <span class="tag"><?= $page->license()->esc() ?></span>
        </div>
      <?php endif ?>

      <?php if ($page->links()->isNotEmpty() || $page->website()->isNotEmpty()) : ?>
        <div>
          <h5 class="mb-2">Links</h5>
          <div>
            <?php if ($page->website()->isNotEmpty()) : ?>
              <a class="inline-block mr-2" href="<?= $page->website()->url() ?>" target="_blank">
                <?= $page->title()->esc() ?>
              </a>
            <?php endif ?>
            <?php
            $links = $page->links()->toStructure();
            foreach ($links as $link) : ?>
              <a class="inline-block mr-2" href="<?= $link->content()->url() ?>" target="_blank">
                <?= $link->content()->text() ?>
              </a>
            <?php endforeach ?>
          </div>
        </div>
      <?php endif ?>
      <?php if ($page->inputs()->isNotEmpty()) : ?>
        <div>
          <h5 class="mb-2">Inputs</h5>
          <span><?= $page->inputs()->esc() ?></span>
        </div>
      <?php endif ?>
      <?php if ($page->inputs()->isNotEmpty()) : ?>
        <div>
            <h5 class="mb-2">Outputs</h5>
            <span><?= $page->outputs()->esc() ?></span>
        </div>
      <?php endif ?>
    </div>

  </article>

</div>

