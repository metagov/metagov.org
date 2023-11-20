<?php
$width = 'max-w-3xl';

if ($page->width()->toBool()) {
  $width = 'max-w-[1120px]';
}

?>

<div class="container <?= $width ?>">
  <div class="mb-8">
    <div class="flex gap-4 items-center">
      <h1 class="text-xl font-semibold mb-2"><?= $page->title()->esc() ?></h1>
    </div>
  </div>

  <?php if ($image = $page->cover()->toFile()) : ?>
    <img class="mb-8 w-full" src="<?= $image->url() ?>" alt="<?= $image->alt()->esc() ?>">
  <?php endif ?>

  <article class="mb-8 prose">
    <?php foreach ($page->text()->toBlocks() as $block) : ?>
      <div id="<?= $block->id() ?>" class="block block-type-<?= $block->type() ?>">
        <?php snippet('blocks/' . $block->type(), [
          'block' => $block,
          'theme' => 'dark'
        ]) ?>
      </div>
    <?php endforeach ?>
  </article>
</div>