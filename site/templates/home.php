<style>
  .chaos-window-1 {
    top: 25vh;
    left: 0;
    right: 0;
    margin-left: auto;
    margin-right: auto;
    z-index: 1000;
  }

  .chaos-window-2 {
    top: 16%;
    left: 10%;
    z-index: 999;
  }

  .chaos-window-3 {
    top: 0%;
    left: 18%;
    z-index: 998;
  }

  .chaos-window-4 {
    top: 32%;
    right: 10%;
    z-index: 997;
  }

  .chaos-window-5 {
    top: 5%;
    right: 15%;
    z-index: 996;
  }

  .chaos-window-6 {
    top: 40%;
    left: 14%;
    z-index: 995;
  }

  .chaos-window-7 {
    top: 45%;
    right: 18%;
    z-index: 994;
  }

  .chaos-window-8 {
    top: 58%;
    left: 10%;
    z-index: 993;
  }

  .chaos-window-9 {
    top: 75%;
    left: 18%;
    z-index: 992;
  }

  .chaos-window-10 {
    top: 62%;
    right: 12%;
    z-index: 991;
  }
</style>

<?php snippet('header') ?>

<div x-data="{order: false, shareModal: false}" class="h-auto p-5" x-init="
      width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
      if (width < 1024) {
      order = true
      }" @resize.window="
      width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
      if (width < 1024) {
      order = true
      }">
  <image class="p-8 sm:p-0 sm:w-[480px] sm:h-[480px] fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 -z-10" alt="Dithered image of the globe in green" src="/src/globe-dithered.png" width="480px" height="480px" />
  <?php snippet('chaos-order') ?>
  <!-- chaos -->
  <div x-cloak x-show="!order" x-transition.duration.450ms x-transition:enter.delay.500ms style="height: <?php echo $chaosHeight ?>px" class="min-h-[calc(100vh-250px)] relative mt-16" :class="order ? 'opacity-0 ' : ''" id="window-container">
    <?php foreach ($windows as $index => $window) : ?>
      <?php $content = $window->description();
      $page = $window->page()->toPage() ?>
      <?php if ($page) : ?>
        <button class="draggable absolute w-[450px] h-[275px] chaos-window-<?= $index + 1 ?> prose" href="#" @click="$dispatch('toggle_modal')" hx-get="<?= $page->url() ?>" hx-replace-url="true" hx-target="#modal-content" hx-swap="innerHTML">
          <?php snippet('window', ['title' => $page->title(), 'subheading' => $page->subheading()], slots: true) ?>

          <?php if (($image = $page->cover()->toFile()) && ($window->window_content() == 'image')) : ?>
            <img class="w-full h-full object-cover" src="<?= $image->url() ?>" alt="<?= $image->alt()->esc() ?>">
          <?php elseif ($page->text()->isNotEmpty()) : ?>
            <div class="modal-text p-4 overflow-auto pointer-events-none">
              <?php foreach ($page->text()->toBlocks() as $block) : ?>
                <?php if ($block->type() != 'markdown') : ?>
                  <div id="<?= $block->id() ?>" class="block block-type-<?= $block->type() ?>">
                    <?php snippet('blocks/' . $block->type(), [
                      'block' => $block,
                      'theme' => 'dark'
                    ]) ?>
                  </div>
                <?php endif ?>
              <?php endforeach ?>
            </div>
          <?php endif ?>

          <?php endsnippet() ?>

        </button>
      <?php elseif ($content) : ?>
        <button class="draggable absolute w-[450px] h-[275px] chaos-window-<?= $index + 1 ?> prose" x-data="{ open: false }" @click="open = true">
          <?php snippet('window', ['title' => $window->title(), 'subheading' => $window->subheading()], slots: true) ?>

          <div class="modal-text p-4 overflow-auto pointer-events-none">
            <?= $content->kt() ?>
          </div>
          <?php snippet('modal', ['content' => $content, 'title' => $window->title(), 'subheading' => $window->subheading()]) ?>
          <?php endsnippet() ?>

        </button>

      <?php endif ?>
    <?php endforeach ?>
  </div>

  <!-- ordered -->
  <div x-cloak x-show="order" class="grid md:grid-cols-2 gap-4 md:gap-6 max-w-[924px] mx-auto mt-16" x-transition.duration.450ms x-transition:enter.delay.500ms>
    <?php foreach ($windows as $index => $window) : ?>
      <?php if ($window->in_order()->toBool() === true) : ?>
        <?php $content = $window->description();
        $page = $window->page()->toPage() ?>
        <?php if ($page) : ?>
          <button class="<?php if ($window->width_order()->toBool() === true) echo 'md:col-span-2' ?> h-[275px] cursor-pointer prose" @click=" $dispatch('toggle_modal')" hx-get="<?= $page->url() ?>" hx-replace-url="true" hx-target="#modal-content" hx-swap="innerHTML">
            <?php snippet('window', ['title' => $page->title(), 'subheading' => $page->subheading()], slots: true) ?>

            <?php if (($image = $page->cover()->toFile()) && ($window->window_content() == 'image')) : ?>
              <img class="w-full h-full object-cover" src="<?= $image->url() ?>" alt="<?= $image->alt()->esc() ?>">
            <?php elseif ($page->text()->isNotEmpty()) : ?>
              <div class="modal-text p-4 overflow-auto pointer-events-none">
                <?php foreach ($page->text()->toBlocks() as $block) : ?>
                  <?php if ($block->type() != 'markdown') : ?>
                    <div id="<?= $block->id() ?>" class="block block-type-<?= $block->type() ?>">
                      <?php snippet('blocks/' . $block->type(), [
                        'block' => $block,
                        'theme' => 'dark'
                      ]) ?>
                    </div>
                  <?php endif ?>
                <?php endforeach ?>
              </div>
            <?php endif ?>

            <?php endsnippet() ?>

          </button>
        <?php elseif ($content) : ?>
          <button class="<?php if ($window->width_order()->toBool() === true) echo 'md:col-span-2' ?> h-[275px] cursor-pointer prose" x-data="{ open: false }" @click="open = true">
            <?php snippet('window', ['title' => $window->title(), 'subheading' => $window->subheading()], slots: true) ?>

            <div class="modal-text p-4 overflow-auto pointer-events-none">
              <?= $content->kt() ?>
            </div>
            <?php snippet('modal', ['content' => $content, 'title' => $window->title(), 'subheading' => $window->subheading()]) ?>
            <?php endsnippet() ?>

          </button>

        <?php endif ?>
      <?php endif ?>
    <?php endforeach ?>
  </div>

</div>

<?php snippet('footer', ['title' => 'Hello!', 'subheading' => 'Subheading']) ?>
<?= js('assets/js/home.js') ?>