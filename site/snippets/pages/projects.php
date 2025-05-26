<div id="projects" class="container max-w-[1088px] py-8">
  <div class="mb-12">
    <h1 class="text-xl font-semibold mb-2">Projects</h1>
  </div>
  <div class="mb-12 flex flex-col lg:flex-row lg:items-center gap-2 lg:gap-4">
    <span>FILTERS:</span>
    <input class="search w-full md:w-1/2 lg:w-auto" placeholder="Search" />
    <?php snippet('blocks/filter', ['filters' => $categories, 'group' => 'category', 'label' => 'Category']) ?>
    <?php snippet('blocks/filter', ['filters' => $types, 'group' => 'type', 'label' => 'Project type']) ?>
    <?php snippet('blocks/filter', ['filters' => $status, 'group' => 'status', 'label' => 'Status']) ?>
    <?php snippet('blocks/filter', ['filters' => $seekingParticipants, 'group' => 'participants', 'label' => 'Seeking participants']) ?>
    <button class="button py-2 w-full md:w-1/2 lg:w-auto" onclick="resetFilter()">Reset filters</button>
  </div>
  <ul class="grid sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6 mx-auto list">
    <?php foreach ($page->children()->listed()->sortBy('modified', 'desc') as $project) : ?>
      <li class="list-none" data-title="<?= $project->title() ?>" data-status="<?= $project->projectStatus() ?? null ?>" data-type="<?= $project->type() ?? null ?>" data-category="<?= $project->category() ?? null ?>" data-participants="<?= ($project->seekingParticipants()->toBool()) ? 'Yes' : 'No' ?>">
        <a href="<?= $project->url() ?>">
          <?php snippet('window', ['title' => $project->title(), 'subheading' => $project->subheading()], slots: true) ?>
          <?php if ($image = $project->cover()->toFile()) : ?>
            <img class="w-full" src="<?= $image->crop(434, 235, "center")->url() ?>" srcset="<?= $image->srcset(
                                                                                                [
                                                                                                  '1x'  => ['width' => 434, 'height' => 235, 'crop' => 'center'],
                                                                                                  '2x'  => ['width' => 868, 'height' => 470, 'crop' => 'center'],
                                                                                                  '3x'  => ['width' => 1320, 'height' => 705, 'crop' => 'center'],
                                                                                                ]
                                                                                              ) ?>" alt="<?= $image->alt()->esc() ?>" width="<?= $image->resize(434)->width() ?>" height="<?= $image->resize(235)->height() ?>">
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


<script>
  var filters = {
    category: [],
    type: [],
    status: ['Active'],
    participants: []
  }

  document.addEventListener('DOMContentLoaded', function() {
    updateList();
  });

  var options = {
    valueNames: [{
      data: ['title', 'category', 'type', 'status', 'participants']
    }]
  }

  var projectList = new List('projects', options);

  projectList.on('updated', function(list) {
    if (list.matchingItems.length > 0) {
      document.getElementById("no-result").style.display = 'hidden'
    } else {
      document.getElementById("no-result").style.display = 'block'
    }
  });

  var resetFilter = () => {
    filters = {
      category: [],
      type: [],
      status: [],
      participants: []
    }
    updateList()
  }

  var updateList = () => {
    projectList.filter(function(item) {
      let category = false
      let type = false
      let status = false
      let participants = false

      if (filters.category.find((element) => item.values().category.includes(element)) || filters.category.length == 0) {
        category = true
      } else {
        category = false
      }

      if (filters.type.find((element) => item.values().type.includes(element)) || filters.type.length == 0) {
        type = true
      } else {
        type = false
      }

      if (filters.status.indexOf(item.values().status) > -1 || filters.status.length == 0) {
        status = true
      } else {
        status = false
      }

      if (filters.participants.indexOf(item.values().participants) > -1 || filters.participants.length == 0) {
        participants = true
      } else {
        participants = false
      }

      if (category && type && status && participants) return true
      else return false
    })

    const filterGroups = ['category', 'type', 'status', 'participants'];

    // For each filter group, update the checked state of checkboxes based on filters object
    filterGroups.forEach(group => {
      console.log(document.querySelectorAll(`input[data-group="${group}"]`))
      document.querySelectorAll(`input[data-group="${group}"]`).forEach(input => {
        console.log(input.dataset.value, filters[group])
        input.checked = filters[group].includes(input.dataset.value);
      });
    });

    // Show or hide the reset button based on whether any filters are applied
    const resetBtn = document.querySelector('button[onclick="resetFilter()"]');
    if (resetBtn) {
      const isFiltered =
        filters.category.length > 0 ||
        filters.type.length > 0 ||
        filters.status.length > 0 ||
        filters.participants.length > 0;
      resetBtn.style.display = isFiltered ? 'inline-block' : 'none';
    }
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