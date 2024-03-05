<?php
$url = null;
if ($page)
  $url = $page->url();
?>

<div x-data="{ modal: false }" @toggle_modal.window="modal = !modal" x-init="$watch('modal', value => handleModalToggle(value))">
  <div role="dialog" aria-labelledby="modal_label" aria-modal="true" tabindex="0" x-cloak x-show="modal" x-trap.noscroll.inert="modal" @keydown.escape="modal = false" class="fixed top-0 left-0 w-full h-screen flex justify-center items-end lg:items-center z-[9999]">
    <div aria-hidden="true" class="absolute top-0 left-0 w-full h-screen bg-default/40 transition duration-300" x-cloak x-show="modal" x-transition.opacity x-transition:leave="delay-150" @click="modal = false"></div>
    <div class="flex flex-col shadow-lg bg-white <?php echo (isset($small)) ? 'w-[600px]' : 'w-[1030px]' ?>  max-h-[85vh] h-auto z-40 relative" data-modal-document @click.stop="" x-cloak x-show="modal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="transform translate-y-[120%]" x-transition:enter-end="transform translate-y-0" x-transition:leave="transition ease-out duration-300" x-transition:leave-start="transform translate-y-0" x-transition:leave-end="transform translate-y-[120%]">
      <?php snippet('window', ['title' => '', 'subheading' => '', 'modal' => true, 'url' => $page->url(), 'ajax' => true], slots: true) ?>
      <div id="modal-content" class="overflow-auto h-[80vh] fade-me-in">
        <div class="h-full flex items-center justify-center">
          <div class="animate-pulse h-4 w-4 bg-brand">
          </div>
        </div>
      </div>
      <?php endsnippet() ?>
    </div>
  </div>
</div>

<script>
  function handleModalToggle(modal) {
    if (!modal) {
      setTimeout(function() {
        // remove content of modal when we close it
        document.getElementById("modal-content").innerHTML = "";
        // change browser url to previous state
        history.replaceState(1, '', '/')
      }, 300);
    }
  }
</script>