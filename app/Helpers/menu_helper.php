<?php
if (!function_exists('generateMenu')) {
  function generateMenu($menuData)
  {
    $currentUrl = current_url();
    $baseUrl = base_url();

    $menuHtml = '<ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              data-accordion="false"
              id="navigation"
            >';

    foreach ($menuData as $item) {
      // Permission check
      if (isset($item['permission']) && $item['permission'] && (!function_exists('auth') || !auth()->user()->can($item['permission']))) {
        continue;
      }

      $hasSubmenu = isset($item['submenu']) && is_array($item['submenu']);
      $isActive = false;
      $isMenuOpen = false;

      // Check active for main item
      if (!$hasSubmenu && ($currentUrl == $baseUrl . $item['url'])) {
        $isActive = true;
      }

      // Check active for submenu
      if ($hasSubmenu) {
        foreach ($item['submenu'] as $subItem) {
          if ($currentUrl == $baseUrl . $subItem['url']) {
            $isActive = true;
            $isMenuOpen = true;
            break;
          }
        }
      }

      $menuHtml .= '<li class="nav-item' . ($isMenuOpen ? ' menu-open' : '') . '">';
      $menuHtml .= '<a href="' . ($hasSubmenu ? '#' : base_url($item['url'])) . '" class="nav-link' . ($isActive ? ' active' : '') . '">';
      $menuHtml .= '<i class="nav-icon ' . $item['icon'] . '"></i>';
      $menuHtml .= '<p>' . $item['title'];
      if ($hasSubmenu) {
        $menuHtml .= '<i class="nav-arrow bi bi-chevron-right"></i>';
      }
      $menuHtml .= '</p></a>';

      // Submenu
      if ($hasSubmenu) {
        $menuHtml .= '<ul class="nav nav-treeview">';
        foreach ($item['submenu'] as $subItem) {
          $subActive = ($currentUrl == $baseUrl . $subItem['url']) ? ' active' : '';
          $menuHtml .= '<li class="nav-item">';
          $menuHtml .= '<a href="' . base_url($subItem['url']) . '" class="nav-link' . $subActive . '">';
          $menuHtml .= '<i class="nav-icon bi bi-circle"></i>';
          $menuHtml .= '<p>' . $subItem['title'] . '</p>';
          $menuHtml .= '</a></li>';
        }
        $menuHtml .= '</ul>';
      }

      $menuHtml .= '</li>';
    }

    $menuHtml .= '</ul>';
    return $menuHtml;
  }
}
