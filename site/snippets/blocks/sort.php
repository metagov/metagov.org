<?php
/**
 * Sort dropdown component
 * 
 * @param array $options Array of sort options with 'value' and 'label' keys
 * @param string $default Default sort option value
 * @param string $onchange JavaScript function name to call when sort changes
 * @param string $containerClass Additional CSS classes for the container
 */

$options = $options ?? [
  ['value' => 'updated', 'label' => 'Last updated'],
  ['value' => 'alphabetical', 'label' => 'Alphabetical']
];
$default = $default ?? 'updated';
$onchange = $onchange ?? 'sortProjects';
$containerClass = $containerClass ?? 'lg:ml-auto w-full md:w-1/2 lg:w-auto';

// Find the default option label
$defaultLabel = 'Sort';
foreach ($options as $option) {
  if ($option['value'] === $default) {
    $defaultLabel = $option['label'];
    break;
  }
}
?>

<div x-data="{
        sortOpen: false,
        currentSort: '<?= $default ?>',
        sortLabel: '<?= $defaultLabel ?>',
        toggle() {
            if (this.sortOpen) {
                return this.close()
            }

            this.$refs.button.focus()

            this.sortOpen = true
        },
        close(focusAfter) {
            if (! this.sortOpen) return

            this.sortOpen = false

            focusAfter && focusAfter.focus()
        },
        selectSort(value, label) {
            this.currentSort = value
            this.sortLabel = label
            this.close(this.$refs.button)
            <?= $onchange ?>(value)
        }
    }" x-on:keydown.escape.prevent.stop="close($refs.button)" x-on:focusin.window="! $refs.panel.contains($event.target) && close()" x-id="['sort-dropdown-button']" class="relative <?= $containerClass ?> window-scrollbar">
  <button class="flex gap-2 items-center justify-between button py-2 w-full md:w-1/2 lg:w-auto" x-ref="button" x-on:click="toggle()" :aria-expanded="sortOpen" :aria-controls="$id('sort-dropdown-button')" type="button">
    <span x-text="sortLabel"><?= $defaultLabel ?></span>
    <svg :class="sortOpen ? 'rotate-180' : ''" width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" clip-rule="evenodd" d="M12 5.5C11.72 5.5 11.47 5.61 11.29 5.79L8 9.09L4.71 5.79C4.53 5.61 4.28 5.5 4 5.5C3.45 5.5 3 5.95 3 6.5C3 6.78 3.11 7.03 3.29 7.21L7.29 11.21C7.47 11.39 7.72 11.5 8 11.5C8.28 11.5 8.53 11.39 8.71 11.21L12.71 7.21C12.89 7.03 13 6.78 13 6.5C13 5.95 12.55 5.5 12 5.5Z" fill="#00CC99" />
    </svg>
  </button>
  <div x-ref="panel" x-show="sortOpen" x-transition.origin.top.left x-on:click.outside="close($refs.button)" :id="$id('sort-dropdown-button')" class="w-full md:w-1/2 lg:w-auto shadow-window hover:shadow-windowhover bg-white dark:bg-black border-brand border text-brand absolute z-[99999999] top-12 left-0 rounded-sm p-1 min-w-[150px] transition" x-cloak>
    <div class="flex flex-col">
      <?php foreach ($options as $option) : ?>
        <button @click="selectSort('<?= $option['value'] ?>', '<?= $option['label'] ?>')" class="p-2 hover:bg-brand/15 text-left cursor-pointer" :class="currentSort === '<?= $option['value'] ?>' ? 'bg-brand/15' : ''">
          <?= $option['label'] ?>
        </button>
      <?php endforeach ?>
    </div>
  </div>
</div>
