<?php $children = $page->children();
$inline = $block->inline()->toBool() ?>
<?php if ($children != null) : ?>
  <?php foreach ($children as $childpage) : ?>
    <?php if ($inline === true) : ?>
      <details class="border border-secondary-dark px-3 py-2 mb-3 group shadow-window hover:shadow-windowhover transition-all">
        <summary class="text-large group-open:mb-2 cursor-pointer"><?= html($childpage->title()) ?></summary>
        <?php foreach ($childpage->text()->toBlocks() as $block) : ?>
          <div id="<?= $block->id() ?>" class="block block-type-<?= $block->type() ?>">
            <?php snippet('blocks/' . $block->type(), [
              'block' => $block,
              'theme' => 'dark'
            ]) ?>
          </div>
        <?php endforeach ?>
      </details>
    <?php else : ?>
      <a class="block mb-2" href="<?= $childpage->url() ?>">
        <?= html($childpage->title()) ?>
      </a>
    <?php endif; ?>
  <?php endforeach; ?>
<?php endif; ?>