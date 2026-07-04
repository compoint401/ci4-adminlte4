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
        'url'   => 'reports',
      ],
      [
        'title' => 'Ledger Summary',
        'url'   => 'reports/sumLedger',
      ],
      [
        'title' => 'Sales Overdues',
        'url'   => 'reports/salesOverdues',
      ],
      [
        'title' => 'Crushers Report',
        'url'   => 'reports/reportsCrushers',
      ],
      [
        'title' => 'Transporters Report',
        'url'   => 'reports/reportsTransporters',
      ],
      [
        'title' => 'Customers Report',
        'url'   => 'reports/reportsCustomers',
      ],
      [
        'title' => 'Delivery Report',
        'url'   => 'reports/reportsDelivery',
      ],
      [
        'title' => 'Invoice Annexure',
        'url'   => 'reports/InvoiceAnnexure',
      ],
    ],
  ],

];

return $menu;
