<?php

/**
 * This helper provides functions for checking user permissions within JavaScript.
 */

if (!function_exists('check_permission')) {
  /**
   * Generates a JavaScript block to check a user's permission and show an alert if denied.
   *
   * @param string $permission The permission string to check (e.g., 'items.update').
   * @param string $action     A descriptive name for the action (e.g., 'update this item').
   * @return string            The JavaScript code block or an empty string if permission is granted.
   */
  function check_permission(string $permission, string $action = 'perform this action'): string
  {
    if (!auth()->user()->can($permission)) {
      return "Swal.fire('Forbidden!', 'You are not allowed to {$action}.', 'warning'); return;";
    }
    return '';
  }
}
