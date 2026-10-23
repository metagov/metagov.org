## Metagov.org

The Metagovernance Project is an interdisciplinary research collective. We build standards and infrastructure for digital self-governance.


## Dev guidelines
* For local development, use composer: `composer start`.
* For CSS changes use Tailwind (requires node):
    * Install node: `npm install` (into node folder)
    * `npm run watch`
    * `npm run build`
* For pushing to live site, SSH into Digital Ocean

## Panel password reset

`site/config/config.php` turns on "Forgot your password?" in the Panel. Kirby emails a one-time code, so the live server needs outgoing mail. DigitalOcean blocks direct mail from droplets by default, so use an SMTP service (for example Postmark, Mailgun or a Google Workspace account) whose sending domain covers `noreply@metagov.org`.

Put the transport in `site/config/config.metagov.org.php` on the server only (it is git-ignored; Kirby loads it automatically for that host):

```php
<?php
return [
  'email' => [
    'transport' => [
      'type'     => 'smtp',
      'host'     => 'smtp.example.com',
      'port'     => 587,
      'security' => true,
      'auth'     => true,
      'username' => 'SMTP_USERNAME',
      'password' => 'SMTP_PASSWORD',
    ],
  ],
];
```

Check: log out, use "Forgot your password?" on `/panel/login` with your own account, and confirm the code arrives.

https://getkirby.com/docs/reference/panel/fields/line

## Reference links

-   **[getkirby.com](https://getkirby.com)** – Get to know the CMS
-   **[Documentation](https://getkirby.com/docs/guide)** – Read the official guide, reference and cookbook recipes
-   **[Cheatsheet](https://getkirby.com/docs/reference)** Quick reference
