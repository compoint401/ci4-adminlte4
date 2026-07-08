<?php

if (!function_exists('bsform_open')) {
  function bsform_open($action = '', $attributes = [])
  {
    return form_open($action, $attributes);
  }
}

if (!function_exists('bsform_close')) {
  function bsform_close()
  {
    return form_close();
  }
}

if (! function_exists('bsform_submit')) {
  function bsform_submit($label = 'Submit', $attributes = [])
  {
    return form_submit(array_merge(['class' => 'btn btn-primary'], $attributes), $label);
  }
}

if (! function_exists('bsform_reset')) {
  function bsform_reset($label = 'Reset', $attributes = [])
  {
    return form_reset(array_merge(['class' => 'btn btn-secondary'], $attributes), $label);
  }
}

/**
 * Centralized field builder
 */
function bsform_field($name, $attrs, $label = '', $style = 'standard')
{
  $validation = \Config\Services::validation();
  $error = $validation->hasError($name);
  if ($error) {
    $attrs['class'] = ($attrs['class'] ?? '') . ' is-invalid';
  }

  $id = $attrs['id'] ?? $name;
  $attrs['id'] = $id;

  // Wrapper start
  $html = '';
  if ($style === 'horizontal') {
    $html .= '<div class="row mb-3">';
    $html .= '<label for="' . $id . '" class="col-sm-2 col-form-label">' . $label . '</label>';
    $html .= '<div class="col-sm-10">';
  } elseif ($style === 'floating') {
    $html .= '<div class="form-floating mb-3">';
  } else {
    $html .= '<div class="mb-3">';
    if ($label) {
      $html .= '<label for="' . $id . '" class="form-label">' . $label . '</label>';
    }
  }

  // Input element
  if ($attrs['type'] === 'textarea') {
    $html .= form_textarea($attrs);
  } elseif ($attrs['type'] === 'select') {
    $options  = $attrs['options'];
    $selected = $attrs['selected'] ?? '';
    unset($attrs['options'], $attrs['selected'], $attrs['type']);
    $extra = stringify_attributes($attrs);
    $html .= form_dropdown($name, $options, $selected, $extra);
  } else {
    $html .= form_input($attrs);
  }

  // Floating label
  if ($style === 'floating' && $label) {
    $html .= '<label for="' . $id . '">' . $label . '</label>';
  }

  // Error block
  if ($error) {
    $html .= '<div class="invalid-feedback">' . $validation->getError($name) . '</div>';
  }

  // Wrapper end
  if ($style === 'horizontal') {
    $html .= '</div></div>';
  } else {
    $html .= '</div>';
  }

  return $html;
}

/**
 * =========================
 * INPUTS
 * =========================
 */
function bsform_input($name, $value = '', $label = '', $options = [])
{
  return bsform_field($name, [
    'type' => $options['type'] ?? 'text',
    'name' => $name,
    'value' => $value,
    'class' => 'form-control ' . ($options['class'] ?? ''),
    'placeholder' => $options['placeholder'] ?? $label,
    'id' => $options['id'] ?? $name
  ], $label, 'standard');
}

function bsform_floating_input($name, $value = '', $label = '', $options = [])
{
  return bsform_field($name, [
    'type' => $options['type'] ?? 'text',
    'name' => $name,
    'value' => $value,
    'class' => 'form-control ' . ($options['class'] ?? ''),
    'placeholder' => $label,
    'id' => $options['id'] ?? $name
  ], $label, 'floating');
}

function bsform_horizontal_input($name, $value = '', $label = '', $options = [])
{
  return bsform_field($name, [
    'type' => $options['type'] ?? 'text',
    'name' => $name,
    'value' => $value,
    'class' => 'form-control ' . ($options['class'] ?? ''),
    'id' => $options['id'] ?? $name
  ], $label, 'horizontal');
}

/**
 * =========================
 * TEXTAREA
 * =========================
 */
function bsform_textarea($name, $value = '', $label = '', $options = [])
{
  return bsform_field($name, [
    'type' => 'textarea',
    'name' => $name,
    'value' => $value,
    'class' => 'form-control ' . ($options['class'] ?? ''),
    'placeholder' => $options['placeholder'] ?? $label,
    'id' => $options['id'] ?? $name
  ], $label, 'standard');
}

function bsform_floating_textarea($name, $value = '', $label = '', $options = [])
{
  return bsform_field($name, [
    'type' => 'textarea',
    'name' => $name,
    'value' => $value,
    'class' => 'form-control ' . ($options['class'] ?? ''),
    'placeholder' => $label,
    'id' => $options['id'] ?? $name
  ], $label, 'floating');
}

function bsform_horizontal_textarea($name, $value = '', $label = '', $options = [])
{
  return bsform_field($name, [
    'type' => 'textarea',
    'name' => $name,
    'value' => $value,
    'class' => 'form-control ' . ($options['class'] ?? ''),
    'id' => $options['id'] ?? $name
  ], $label, 'horizontal');
}

/**
 * =========================
 * DATEPICKER
 * =========================
 */
function bsform_datepicker($name, $value = '', $label = '', $options = [])
{
  return bsform_field($name, [
    'type' => 'date',
    'name' => $name,
    'value' => $value,
    'class' => 'form-control ' . ($options['class'] ?? ''),
    'id' => $options['id'] ?? $name
  ], $label, 'standard');
}

function bsform_floating_datepicker($name, $value = '', $label = '', $options = [])
{
  return bsform_field($name, [
    'type' => 'date',
    'name' => $name,
    'value' => $value,
    'class' => 'form-control ' . ($options['class'] ?? ''),
    'placeholder' => $label,
    'id' => $options['id'] ?? $name
  ], $label, 'floating');
}

function bsform_horizontal_datepicker($name, $value = '', $label = '', $options = [])
{
  return bsform_field($name, [
    'type' => 'date',
    'name' => $name,
    'value' => $value,
    'class' => 'form-control ' . ($options['class'] ?? ''),
    'id' => $options['id'] ?? $name
  ], $label, 'horizontal');
}

/**
 * =========================
 * SELECT
 * =========================
 */
function bsform_select($name, $options = [], $label = '', $selected = '', $attrs = [])
{
  return bsform_field($name, [
    'type' => 'select',
    'name' => $name,
    'options' => $options,
    'selected' => $selected,
    'class' => 'form-select ' . ($attrs['class'] ?? ''),
    'id' => $attrs['id'] ?? $name
  ], $label, 'standard');
}

function bsform_floating_select($name, $options = [], $label = '', $selected = '', $attrs = [])
{
  return bsform_field($name, [
    'type' => 'select',
    'name' => $name,
    'options' => $options,
    'selected' => $selected,
    'class' => 'form-select ' . ($attrs['class'] ?? ''),
    'id' => $attrs['id'] ?? $name
  ], $label, 'floating');
}

function bsform_horizontal_select($name, $options = [], $label = '', $selected = '', $attrs = [])
{
  return bsform_field($name, [
    'type' => 'select',
    'name' => $name,
    'options' => $options,
    'selected' => $selected,
    'class' => 'form-select ' . ($attrs['class'] ?? ''),
    'id' => $attrs['id'] ?? $name
  ], $label, 'horizontal');
}

/**
 * =========================
 * CHECKBOX / RADIO / SWITCH
 * =========================
 */
function bsform_checkbox($name, $value, $checked = false, $label = '', $attrs = [])
{
  return bsform_choice('checkbox', $name, $value, $checked, $label, $attrs);
}

function bsform_radio($name, $value, $checked = false, $label = '', $attrs = [])
{
  return bsform_choice('radio', $name, $value, $checked, $label, $attrs);
}

function bsform_switch($name, $value, $checked = false, $label = '', $attrs = [])
{
  return bsform_choice('switch', $name, $value, $checked, $label, $attrs);
}

function bsform_choice($type, $name, $value, $checked, $label, $attrs)
{
  $validation = \Config\Services::validation();
  $id = $attrs['id'] ?? $name . (($type === 'radio') ? ('_' . $value) : '');
  $class = 'form-check-input ' . ($attrs['class'] ?? '');
  if ($validation->hasError($name)) $class .= ' is-invalid';

  $html  = '<div class="form-check ' . ($type === 'switch' ? 'form-switch ' : '') . 'mb-3">';
  if ($type === 'radio') {
    $html .= form_radio($name, $value, $checked, ['id' => $id, 'class' => $class]);
  } else {
    $html .= form_checkbox($name, $value, $checked, ['id' => $id, 'class' => $class, 'role' => $type === 'switch' ? 'switch' : null]);
  }
  $html .= '<label class="form-check-label" for="' . $id . '">' . $label . '</label>';
  if ($validation->hasError($name)) {
    $html .= '<div class="invalid-feedback">' . $validation->getError($name) . '</div>';
  }
  $html .= '</div>';
  return $html;
}

/**
 * =========================
 * SLIDER
 * =========================
 */
function bsform_slider($name, $value = '', $label = '', $attrs = [])
{
  $validation = \Config\Services::validation();
  $id = $attrs['id'] ?? $name;
  $class = 'form-range ' . ($attrs['class'] ?? '');
  if ($validation->hasError($name)) $class .= ' is-invalid';

  $html  = '<div class="mb-3">';
  $html .= '<label for="' . $id . '" class="form-label">' . $label . '</label>';
  $html .= form_input(['type' => 'range', 'name' => $name, 'id' => $id, 'value' => $value, 'class' => $class]);
  if ($validation->hasError($name)) {
    $html .= '<div class="invalid-feedback">' . $validation->getError($name) . '</div>';
  }
  $html .= '</div>';
  return $html;
}