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
    'http://localhost:8000',
    'https://upright-true-goose.ngrok-free.app'
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
  // Self-service password reset in the Panel ("Forgot your password?").
  // Needs outgoing mail: put the SMTP transport in site/config/config.metagov.org.php
  // on the server (kept out of git; see README).
  'auth' => [
    'methods' => ['password', 'password-reset'],
    'challenge' => [
      'email' => [
        'from'     => 'noreply@metagov.org',
        'fromName' => 'Metagov',
      ],
    ],
  ],
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
    ],
    [
      'pattern' => 'swag',
      'action'  => function () {
        return go('https://metagov.printful.me/', 301);
      }
    ]
  ],
  'sitemap.ignore' => ['error'],
  // tell the plugin which `role => fieldname` associations to use
  'sylvainjule.bouncer.list' => [
    'editor' => [ // matches your blueprint filename without .yml
        'fieldname' => 'canaccess',
        'nav' => true
    ]
]
];
