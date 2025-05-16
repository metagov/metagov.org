<?php
/**
 * @var \Kirby\Cms\Block $block
 */
?>
<div class="block-twocolumns grid grid-cols-1 md:grid-cols-2 gap-6">

  <div>
    <?= $block->column1()->text() ?>
  </div>
  <div>
    <?= $block->column2()->text() ?>
  </div>
</div>