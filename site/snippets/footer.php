<?php if (!$ajax) : ?>

  </main>

  <footer class="grid grid-cols-3 w-full px-6 py-[30px]">
    <span class="text-brand mb-0">Metagov –– </span>
    <?php snippet('color-mode') ?>
    <span class="text-brand text-right mb-0">–– <?= date("Y"); ?></span>
  </footer>

  <?php snippet('modal-ajax') ?>

  </body>

  </html>
<?php endif ?>