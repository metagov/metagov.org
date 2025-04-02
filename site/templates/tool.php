<?php snippet('header') ?>

<?php if ($ajax) : ?>
<?php endif ?>
<?php snippet('pages/tool', ['page' => $page]) ?>
<?php if ($ajax) : ?>
  <?php endsnippet() ?>
<?php endif ?>

<?php snippet('footer') ?>
