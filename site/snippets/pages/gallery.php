<div id="projects" class="container max-w-[1088px] py-8">
  <div class="mb-12">
  <h1 class="text-xl font-black text-brand mb-2">Deliberative Tool Gallery</h1>
  </div>
  <div class="flex flex-col md:flex-row space-x-4">
    <div class="flex-none w-64 divide-y">
      <div>
        <h4 class="font-black text-brand pb-2">Stage</h4>
        <ul class="indent-2">
          <?php snippet(
            'blocks/checkboxfilter',
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
            ]) 
          ?>
        </ul>
      </div>
      <div>
        <input class="search w-full my-2" placeholder="Search" />
      </div>

    </div>
    <div class="flex-1">
      <ul class="grid lg:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6 list">
        <?php foreach ($page->children()->sortBy('title', 'asc') as $project) : ?>
          <li class="list-none w-64 h-80" data-title="<?= $project->title() ?>" data-status="<?= $project->projectStatus() ?? null ?>" data-type="<?= $project->type() ?? null ?>" data-category="<?= $project->category() ?? null ?>" data-stage="<?= $project->stage() ?? null ?>" data-participants="<?= ($project->seekingParticipants()->toBool()) ? 'Yes' : 'No' ?>">
            <a href="<?= $project->url() ?>">
              <?php snippet('window', ['title' => $project->title(), 'subheading' => $project->subheading()], slots: true) ?>
              <?php if ($image = $project->cover()->toFile()) : ?>
                <div class="flex grow items-center justify-items-center h-full p-2 overflow-hidden">
                  <img class="object-contain" src="<?= $image->url() ?>"  alt="<?= $image->alt()->esc() ?>" />
                </div>
              <?php endif ?>
              <?php endsnippet() ?>
            </a>
          </li>

        <?php endforeach ?>
      </ul>
      <div id="no-result" class="hidden">
        <p>No projects found</p>
      </div>
    </div>
  </div>
</div>


<script>
  var filters = {
    stage: []
  }

  var options = {
    valueNames: [{
      data: ['stage']
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
