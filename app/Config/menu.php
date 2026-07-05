<?php

$menu = [
  [
    'title' => 'Home',
    'icon'  => 'bi bi-house',
    'url'   => 'user/home',
    'permission' => null,
  ],
  [
    'title' => 'Database Backup',
    'icon'  => 'bi bi-archive',
    'url'   => 'backup',
    'permission' => 'admin.settings',
  ],
  [
    'title' => 'Users',
    'icon'  => 'bi bi-book',
    'url'   => 'admin/listUsers',
    'permission' => 'users.create',
  ],

  [
    'title' => 'Reports',
    'icon'  => 'bi bi-book',
    'url'   => '#',
    'permission' => 'users.create',
    'submenu' => [
      [
        'title' => 'Ledgers',
        'url'   => 'demo?t=Demo Ledgers',
      ],
      [
        'title' => 'Balance Sheet',
        'url'   => 'demo?t=Balance Sheet',
      ],
      [
        'title' => 'Profit & Loss',
        'url'   => 'demo?t=Profit and Loss',
      ],
      [
        'title' => 'Other Report',
        'url'   => 'demo?t=Other Report',
      ],
    ],
  ],

];

return $menu;
