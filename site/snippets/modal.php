<template x-teleport="body">
  <div role="dialog" aria-labelledby="modal_label" aria-modal="true" tabindex="0" x-cloak x-show="open" x-trap.noscroll.inert="open" @click="open = false" @click.away="open = false" @keydown.window.escape="open = false" class="fixed top-0 left-0 w-full h-screen flex justify-center items-end lg:items-center z-[9999]">
    <div aria-hidden="true" class="absolute top-0 left-0 w-full h-screen bg-default/40 transition duration-300" x-cloak x-show="open" x-transition.opacity x-transition:leave="delay-150"></div>
    <div class="flex flex-col shadow-lg overflow-auto bg-white <?php echo (isset($small)) ? 'w-[600px]' : 'w-[1030px]' ?> max-h-[85vh] h-auto z-40  relative" data-modal-document @click.stop="" x-cloak x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="transform translate-y-[120%]" x-transition:enter-end="transform translate-y-0" x-transition:leave="transition ease-out duration-300" x-transition:leave-start="transform translate-y-0" x-transition:leave-end="transform translate-y-[120%]">
      <?php snippet('window', ['title' => $title, 'subheading' => $subheading, 'modal' => true], slots: true) ?>
      <div class="p-4 max-h-[75vh]">
        <div class="overflow-auto prose">
          <?= $content->kt() ?>
        </div>
      </div>
      <?php endsnippet() ?>
    </div>
  </div>
</template>