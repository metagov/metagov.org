<?php
return [
  'ready' => function ($kirby) {
    return [
      'debug' => kirby()->user() && kirby()->user()->role()->isAdmin()
    ];
  },
  // issue with caching and htmx modals, enable when fixed.
  // 'cache' => [
  //   'pages' => [
  //     'active' => true,
  //   ]
  // ],
  'markdown' => [
    'extra' => true
  ],
  'url' => [
    'https://metagov.org',
    'https://www.metagov.org',
    'http://localhost:8000'
  ],
  'blocks' => [
    'fieldsets' => [
      'text' => [
        'label' => 'Text',
        'type' => 'group',
        'fieldsets' => [
          'text',
          'heading',
          'table',
          'markdown',
          'line',
        ]
      ],
      'media' => [
        'label' => 'Media',
        'type' => 'group',
        'fieldsets' => [
          'image',
          'video'
        ]
      ]
    ]
  ],
  'thathoff.git-content.disable' => true,
  'routes' => [
    [
      'pattern' => 'sitemap.xml',
      'action'  => function () {
        $pages = site()->pages()->index();

        // fetch the pages to ignore from the config settings,
        // if nothing is set, we ignore the error page
        $ignore = kirby()->option('sitemap.ignore', ['error']);

        $content = snippet('sitemap', compact('pages', 'ignore'), true);

        // return response with correct header type
        return new Kirby\Cms\Response($content, 'application/xml');
      }
    ],
    [
      'pattern' => 'sitemap',
      'action'  => function () {
        return go('sitemap.xml', 301);
      }
    ]
  ],
  'sitemap.ignore' => ['error'],
];
