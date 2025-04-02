<div id="projects" class="container max-w-[1088px] py-8">
  <div class="mb-12">
    <h1 class="text-xl mb-2">Deliberative Tool Gallery</h1>
  </div>
  <div class="mb-8 prose max-w-prose">
    <?php foreach ($page->content()->content()->toBlocks() as $block) : ?>
      <div id="<?= $block->id() ?>" class="block block-type-<?= $block->type() ?>">
        <?php snippet('blocks/' . $block->type(), [
          'block' => $block,
          'theme' => 'dark'
        ]) ?>
      </div>
    <?php endforeach ?>
  </div>
  <div class="mb-12 flex flex-col lg:flex-row lg:items-center gap-2 lg:gap-4">
    <span>FILTERS:</span>
    <input class="search w-full md:w-1/2 lg:w-auto" placeholder="Search" />
    <ul class="indent-2">
      <?php snippet(
        'blocks/filter',
        [
          'filters' => [
            'Framing',
            'Elicitation',
            'Learning',
            'Deliberation',
            'Decision',
            'Actuation',
            'Reflection'
          ],
          'group' => 'stage',
          'label' => 'Stage'
        ]
      )
      ?>
    </ul>
  </div>


  <ul class="grid sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 list">
    <?php foreach ($page->children()->sortBy('title', 'asc') as $project) : ?>
      <li class="list-none" data-title="<?= $project->title() ?>" data-stage="<?= $project->stage() ?>">
        <a href="<?= $project->url() ?>">
          <?php snippet('window', ['title' => $project->title(), 'subheading' => $project->subheading()], slots: true) ?>
          <?php if ($image = $project->cover()->toFile()) : ?>
            <div class="flex grow items-center justify-items-center h-full p-8 bg-white overflow-hidden">
              <img class="w-full" src="<?= $image->url() ?>" alt="<?= $image->alt()->esc() ?>" />
            </div>
          <?php endif ?>
          <?php endsnippet() ?>
        </a>
      </li>

    <?php endforeach ?>
  </ul>

  <div id="no-result" class="hidden">
    <p>No tools found</p>
  </div>
</div>


<script>
  var filters = {
    stage: []
  }

  var options = {
    valueNames: [{
      data: ['title', 'stage']
    }]
  }

  var projectList = new List('projects', options);
  console.log('projectList', projectList)

  projectList.on('updated', function(list) {
    const el = document.getElementById("no-result")
    if (list.matchingItems.length > 0) {
      el.classList.add('hidden')
      el.classList.remove('block')
    } else {
      el.classList.remove('hidden')
      el.classList.add('block')
    }
  });

  var resetFilter = () => {
    filters = {
      stage: [],
    }
    updateList()
  }

  var updateList = () => {
    projectList.filter(function(item) {
      let stage = false

      if (filters.stage.find((element) => item.values().stage.includes(element)) || filters.stage.length == 0) {
        stage = true
      } else {
        stage = false
      }

      if (stage) return true
      return false
    })
  }

  var toggleFilter = (e) => {
    const checked = e.target.checked
    const value = e.target.dataset.value
    const group = e.target.dataset.group

    if (checked) {
      filters[group].push(value)
    } else {
      const index = filters[group].indexOf(value);
      if (index > -1) {
        filters[group].splice(index, 1);
      }
    }

    updateList()
  }
</script>