<div id="projects" class="container max-w-[1088px] py-8">
  <div class="mb-12">
    <h1 class="text-xxl mb-2">Projects</h1>
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
    <?php
    // Get all projects
    $projects = $page->children()->listed()->sortBy('modified', 'desc');

    // Get only active projects
    $activeProjects = $projects->filterBy('projectStatus', 'Active', ',');

    // Get only projects that are not active
    $otherProjects = $projects->filterBy('projectStatus', '!=', 'Active', ',');

    // Group together to ensure active projects are displayed first
    $grouped = [
      'Active' => $activeProjects,
      'Other' => $otherProjects
    ];
    ?>
    <?php foreach ($grouped as $group): ?>
      <?php foreach ($group as $project) : ?>
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
    <?php endforeach ?>
  </ul>
  <div id="no-result" class="hidden">
    <p>No projects found</p>
  </div>
</div>


<script>
  // Initial filters
  var filters = {
    category: [],
    type: [],
    status: [],
    participants: []
  }

  // Initialize the filters based on the initial state
  document.addEventListener('DOMContentLoaded', function() {
    updateList();
  });

  // Initialize List.js
  var options = {
    valueNames: [{
      data: ['title', 'category', 'type', 'status', 'participants']
    }]
  }
  // Create a new List instance for the projects
  // This will allow us to filter and sort the project items based on the defined options
  var projectList = new List('projects', options);

  // Display "No results" message if no projects match the filters
  projectList.on('updated', function(list) {
    if (list.matchingItems.length > 0) {
      document.getElementById("no-result").style.display = 'hidden'
    } else {
      document.getElementById("no-result").style.display = 'block'
    }
  });

  // Function to reset filters
  var resetFilter = () => {
    filters = {
      category: [],
      type: [],
      status: [],
      participants: []
    }
    updateList()
  }

  // Function to update the project list based on filters
  // This function filters the project list based on the selected filters
  // and updates the checkboxes and active filter counts accordingly
  // It checks each project item against the filters and only displays those that match.
  // The function is called whenever a filter is toggled or reset.
  var updateList = () => {
    projectList.filter(function(item) {
      let category = false;
      let type = false;
      let status = false;
      let participants = false;

      if (
        filters.category.length === 0 ||
        filters.category.some(selected =>
          item.values().category
          .split(',')
          .map(s => s.trim())
          .includes(selected)
        )
      ) {
        category = true;
      } else {
        category = false;
      }

      if (
        filters.type.length === 0 ||
        filters.type.some(selected =>
          item.values().type
          .split(',')
          .map(s => s.trim())
          .includes(selected)
        )
      ) {
        type = true;
      } else {
        type = false;
      }

      if (
        filters.status.length === 0 ||
        filters.status.some(selected =>
          item.values().status
          .split(',')
          .map(s => s.trim())
          .includes(selected)
        )
      ) {
        status = true;
      } else {
        status = false;
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
        input.checked = filters[group].includes(input.dataset.value);
      });

      // Update the label to show the number of active filters
      const countSpan = document.getElementById(`active-filter-count-${group}`);
      const button = document.getElementById(`filter-button-${group}`);
      const count = filters[group].length;
      console.log(countSpan, button, count);
      if (countSpan && count > 0) {
        button.classList.add('active');
      } else {
        button.classList.remove('active');
      }
      countSpan.innerHTML = count > 0 ? `(${count})` : '';
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

  // Function to toggle a filter checkbox
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