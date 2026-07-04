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
    'title' => 'Settings',
    'icon'  => 'bi bi-tools',
    'url'   => 'settings',
    'permission' => 'admin.settings',
  ],
  [
    'title' => 'Users',
    'icon'  => 'bi bi-address-book',
    'url'   => 'admin/listUsers',
    'permission' => 'users.create',
  ],
  [
    'title' => 'Party Master',
    'icon'  => 'bi bi-address-card',
    'url'   => 'parties',
    'permission' => null,
  ],
  [
    'title' => 'Materials(Items)',
    'icon'  => 'bi bi-boxes',
    'url'   => 'items',
    'permission' => null,
  ],
  [
    'title' => 'Project/Site',
    'icon'  => 'bi bi-building',
    'url'   => 'sites',
    'permission' => null,
  ],
  [
    'title' => 'P. Orders',
    'icon'  => 'bi bi-edit',
    'url'   => 'orders',
    'permission' => null,
  ],
  [
    'title' => 'Delivery',
    'icon'  => 'bi bi-pickup',
    'url'   => 'deliveries',
    'permission' => null,
  ],
  [
    'title' => 'Sale - Invoice',
    'icon'  => 'bi bi-check',
    'url'   => 'sales',
    'permission' => null,
  ],
  [
    'title' => 'Purchase - Invoice',
    'icon'  => 'bi bi-warehouse',
    'url'   => 'purchases',
    'permission' => null,
  ],
  [
    'title' => 'Receipts',
    'icon'  => 'bi bi-rupee-sign',
    'url'   => 'money/receipt',
    'permission' => null,
  ],
  [
    'title' => 'Payments',
    'icon'  => 'bi bi-money-check',
    'url'   => 'money/payment',
    'permission' => null,
  ],
  [
    'title' => 'Vouchers - Journal',
    'icon'  => 'bi bi-money-check',
    'url'   => 'vouchers',
    'permission' => null,
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
  [
    'title' => 'MIS Reports',
    'icon'  => 'bi bi-book',
    'url'   => '#',
    'permission' => 'users.create',
    'submenu' => [
      [
        'title' => 'Delivery Summary',
        'url'   => 'mis/sumDelivery',
      ],
      [
        'title' => 'Sales Overdues',
        'url'   => 'mis/sales',
      ],
      [
        'title' => 'Unbilled Qty Details',
        'url'   => 'mis/unBilled',
      ],
      [
        'title' => 'Summary Report - Customers',
        'url'   => 'mis/sumCustomers',
      ],
      [
        'title' => 'Summary Report - Crushers',
        'url'   => 'mis/sumCrushers',
      ],
      [
        'title' => 'Summary - Transporters',
        'url'   => 'mis/sumTransporters',
      ],
      [
        'title' => 'Summary-Transporters-FOR',
        'url'   => 'mis/sumTransporters2',
      ],
    ],
  ],
];

return $menu;
