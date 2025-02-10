
<?php foreach ($filters as $filter) : ?>
  <label class="p-2 hover:bg-brand/15 flex justify-between items-center cursor-pointer text-brand" >
    <?= $filter ?>
    <input class="peer" data-value="<?= $filter ?>" data-group="<?= $group ?>" type="checkbox" x-on:change="toggleFilter" />
  </label>
<?php endforeach ?>
