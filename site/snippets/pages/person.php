<article class="container lg:flex lg:gap-8 py-8 max-w-2xl mx-auto">
  <div class="mb-8 w-full lg:w-[200px] lg:flex-none">
    <?php
      if ($page->image()) :
        $image = $page->image();
      elseif (!isset($image)) :
        $image = $page->parent()->avatars()->toFiles()->shuffle()->first();
      endif ?>
    <img class="w-full border border-brand/30 rounded mb-4 max-w-[200px]" 
          src="<?= $image->toFile()->crop(200, 200, "center")->url() ?>" 
          srcset="<?= $image->srcset([
            '1x'  => ['width' => 200, 'height' => 200, 'crop' => 'center'],
            '2x'  => ['width' => 400, 'height' => 400, 'crop' => 'center'],
            '3x'  => ['width' => 600, 'height' => 600, 'crop' => 'center'],
          ]) ?>" 
          alt="<?= $image->alt()->esc() ?>" 
          width="200" 
          height="200"
    />

    <h1 class="text-small text-secondary dark:text-secondary-dark mb-1"><?= $page->title()->esc() ?></h1>
    
    <p class="text-tag mb-4 italic"><?= $page->affiliation() ?></p>

    <?php if ($page->role()->isNotEmpty()) : ?>
      <?php foreach ($page->role()->split() as $role) : ?>
        <span class="button inline-block mb-4"><?= $role ?></span>
      <?php endforeach ?>
    <?php endif ?>

    <div>
      <?php
      $links = $page->links()->toStructure();
      foreach ($links as $link) : ?>
        <a class="inline-block mr-2" href="<?= $link->content()->url() ?>" target="_blank">
          <?= $link->content()->text() ?>
        </a>
      <?php endforeach ?>
    </div>
  </div>

  <div class="max-w-prose">
    <?php if ($page->bio()->isNotEmpty()) : ?>
      <h3 class="text-small font-mono text-secondary">BIO</h3>
      <div class="prose mb-4">
        <?= $page->bio()->kt() ?>
      </div>
    <?php endif ?>
    <?php if ($page->interests()->isNotEmpty()) : ?>
      <h3 class="text-small font-mono text-secondary">RESEARCH INTERESTS</h3>
      <p><?= $page->interests() ?>
      <?php endif ?>
      <?php if ($page->dateJoined()->isNotEmpty()) : ?>
      <h3 class="text-small font-mono text-secondary">JOINED</h3>
      <p><?= $page->dateJoined()->toDate('F Y') ?></p>
    <?php endif ?>
  </div>
</article>