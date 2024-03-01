<div x-data="{
            filterOpen: false,
            toggle() {
                if (this.filterOpen) {
                    return this.close()
                }
 
                this.$refs.button.focus()
 
                this.filterOpen = true
            },
            close(focusAfter) {
                if (! this.filterOpen) return
 
                this.filterOpen = false
 
                focusAfter && focusAfter.focus()
            }
        }" x-on:keydown.escape.prevent.stop="close($refs.button)" x-on:focusin.window="! $refs.panel.contains($event.target) && close()" x-id="['dropdown-button']" class="relative window-scrollbar">
  <button class="flex gap-2 items-center justify-between button py-2" x-ref="button" x-on:click="toggle()" :aria-expanded="filterOpen" :aria-controls="$id('dropdown-button')" type="button">
    <?= $label ?>
    <svg :class="filterOpen ? 'rotate-180' : ''" width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" clip-rule="evenodd" d="M12 5.5C11.72 5.5 11.47 5.61 11.29 5.79L8 9.09L4.71 5.79C4.53 5.61 4.28 5.5 4 5.5C3.45 5.5 3 5.95 3 6.5C3 6.78 3.11 7.03 3.29 7.21L7.29 11.21C7.47 11.39 7.72 11.5 8 11.5C8.28 11.5 8.53 11.39 8.71 11.21L12.71 7.21C12.89 7.03 13 6.78 13 6.5C13 5.95 12.55 5.5 12 5.5Z" fill="#00CC99" />
    </svg>
  </button>
  <div x-ref="panel" x-show="filterOpen" x-transition.origin.top.left x-on:click.outside="close($refs.button)" :id="$id('dropdown-button')" class="shadow-window hover:shadow-windowhover bg-white dark:bg-black border-brand border text-brand absolute z-[99999999] top-12 left-0 rounded-sm p-1 min-w-[200px] max-h-72 overflow-auto transition" x-cloak>
    <div class="flex flex-col gap-2">
      <?php foreach ($filters as $filter) : ?>
        <label class="p-2 hover:bg-brand/15 filter-checkbox flex justify-between items-center cursor-pointer" @click="toggleFilter">
          <?= $filter ?>
          <input data-value="<?= $filter ?>" data-group="<?= $group ?>" type="checkbox" />
          <svg class="filter-checkbox-svg" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg">
            <path class="checkmark" fill-rule="evenodd" clip-rule="evenodd" d="M14 3C13.72 3 13.47 3.11 13.29 3.29L6 10.59L2.71 7.29C2.53 7.11 2.28 7 2 7C1.45 7 1 7.45 1 8C1 8.28 1.11 8.53 1.29 8.71L5.29 12.71C5.47 12.89 5.72 13 6 13C6.28 13 6.53 12.89 6.71 12.71L14.71 4.71C14.89 4.53 15 4.28 15 4C15 3.45 14.55 3 14 3Z" fill="none" />
          </svg>
        </label>
      <?php endforeach ?>
    </div>
  </div>
</div>