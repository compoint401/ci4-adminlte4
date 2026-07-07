<?php


if (! function_exists('bsform_open')) {
  function bsform_open($action = '', $attributes = [], $hidden = [])
  {
    $attributes = array_merge(['class' => 'needs-validation'], $attributes);
    return form_open($action, $attributes, $hidden);
  }
}

if (! function_exists('bsform_close')) {
  function bsform_close()
  {
    return form_close();
  }
}

if (! function_exists('bsform_input')) {
  function bsform_input($name, $value = '', $label = '', $attributes = [], $helpText = '')
  {
    $id = $attributes['id'] ?? $name;
    $html  = '<div class="mb-3">';
    $html .= form_label($label, $id, ['class' => 'form-label']);
    $html .= form_input(array_merge(['name' => $name, 'id' => $id, 'value' => $value, 'class' => 'form-control'], $attributes));
    if ($helpText) {
      $html .= '<div class="form-text">' . $helpText . '</div>';
    }
    $html .= bsform_error($name);
    $html .= '</div>';
    return $html;
  }
}

if (! function_exists('bsform_password')) {
  function bsform_password($name, $value = '', $label = '', $attributes = [])
  {
    return bsform_input($name, $value, $label, array_merge(['type' => 'password'], $attributes));
  }
}

if (! function_exists('bsform_email')) {
  function bsform_email($name, $value = '', $label = '', $attributes = [])
  {
    return bsform_input($name, $value, $label, array_merge(['type' => 'email'], $attributes));
  }
}

if (! function_exists('bsform_textarea')) {
  function bsform_textarea($name, $value = '', $label = '', $attributes = [], $helpText = '')
  {
    $id = $attributes['id'] ?? $name;
    $html  = '<div class="mb-3">';
    $html .= form_label($label, $id, ['class' => 'form-label']);
    $html .= form_textarea(array_merge(['name' => $name, 'id' => $id, 'value' => $value, 'class' => 'form-control'], $attributes));
    if ($helpText) {
      $html .= '<div class="form-text">' . $helpText . '</div>';
    }
    $html .= bsform_error($name);
    $html .= '</div>';
    return $html;
  }
}

if (! function_exists('bsform_select')) {
  function bsform_select($name, $options = [], $label = '', $selected = null, $attributes = [])
  {
    $id = $attributes['id'] ?? $name;
    $html  = '<div class="mb-3">';
    $html .= form_label($label, $id, ['class' => 'form-label']);
    $html .= form_dropdown($name, $options, $selected, array_merge(['id' => $id, 'class' => 'form-select'], $attributes));
    $html .= bsform_error($name);
    $html .= '</div>';
    return $html;
  }
}

if (! function_exists('bsform_checkbox')) {
  function bsform_checkbox($name, $value = '1', $checked = false, $label = '', $attributes = [])
  {
    $id = $attributes['id'] ?? $name;
    $html  = '<div class="form-check mb-3">';
    $html .= form_checkbox(array_merge(['name' => $name, 'id' => $id, 'value' => $value, 'checked' => $checked, 'class' => 'form-check-input'], $attributes));
    $html .= form_label($label, $id, ['class' => 'form-check-label']);
    $html .= bsform_error($name);
    $html .= '</div>';
    return $html;
  }
}

if (! function_exists('bsform_radio')) {
  function bsform_radio($name, $value, $checked = false, $label = '', $attributes = [])
  {
    $id = $attributes['id'] ?? $name . '_' . $value;
    $html  = '<div class="form-check mb-3">';
    $html .= form_radio(array_merge(['name' => $name, 'id' => $id, 'value' => $value, 'checked' => $checked, 'class' => 'form-check-input'], $attributes));
    $html .= form_label($label, $id, ['class' => 'form-check-label']);
    $html .= bsform_error($name);
    $html .= '</div>';
    return $html;
  }
}

if (! function_exists('bsform_file')) {
  function bsform_file($name, $label = '', $attributes = [])
  {
    $id = $attributes['id'] ?? $name;
    $html  = '<div class="mb-3">';
    $html .= form_label($label, $id, ['class' => 'form-label']);
    $html .= form_upload(array_merge(['name' => $name, 'id' => $id, 'class' => 'form-control'], $attributes));
    $html .= bsform_error($name);
    $html .= '</div>';
    return $html;
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

if (! function_exists('bsform_floating_input')) {
  function bsform_floating_input($name, $value = '', $label = '', $attributes = [])
  {
    $id = $attributes['id'] ?? $name;
    $type = $attributes['type'] ?? 'text';
    $html  = '<div class="form-floating mb-3">';
    $html .= form_input(array_merge(['type' => $type, 'name' => $name, 'id' => $id, 'value' => $value, 'class' => 'form-control', 'placeholder' => $label], $attributes));
    $html .= form_label($label, $id);
    $html .= bsform_error($name);
    $html .= '</div>';
    return $html;
  }
}

if (! function_exists('bsform_floating_textarea')) {
  function bsform_floating_textarea($name, $value = '', $label = '', $attributes = [])
  {
    $id = $attributes['id'] ?? $name;
    $html  = '<div class="form-floating mb-3">';
    $html .= form_textarea(array_merge(['name' => $name, 'id' => $id, 'value' => $value, 'class' => 'form-control', 'placeholder' => $label], $attributes));
    $html .= form_label($label, $id);
    $html .= bsform_error($name);
    $html .= '</div>';
    return $html;
  }
}

if (! function_exists('bsform_error')) {
  function bsform_error($field)
  {
    $errors = session('errors');
    if (! empty($errors[$field])) {
      return '<div class="invalid-feedback d-block">' . $errors[$field] . '</div>';
    }
    return '';
  }

  // Grouped radios (stacked or inline)
  if (! function_exists('bsform_radio_group')) {
    function bsform_radio_group($name, $options = [], $selected = null, $inline = false)
    {
      $html = '<div class="mb-3">';
      foreach ($options as $value => $label) {
        $id = $name . '_' . $value;
        $class = $inline ? 'form-check form-check-inline' : 'form-check';
        $html .= '<div class="' . $class . '">';
        $html .= form_radio([
          'name' => $name,
          'id' => $id,
          'value' => $value,
          'checked' => ($selected == $value),
          'class' => 'form-check-input'
        ]);
        $html .= form_label($label, $id, ['class' => 'form-check-label']);
        $html .= '</div>';
      }
      $html .= bsform_error($name);
      $html .= '</div>';
      return $html;
    }
  }

  // Inline checkboxes
  if (! function_exists('bsform_checkbox_group')) {
    function bsform_checkbox_group($name, $options = [], $selected = [], $inline = false)
    {
      $html = '<div class="mb-3">';
      foreach ($options as $value => $label) {
        $id = $name . '_' . $value;
        $class = $inline ? 'form-check form-check-inline' : 'form-check';
        $html .= '<div class="' . $class . '">';
        $html .= form_checkbox([
          'name' => $name . '[]',
          'id' => $id,
          'value' => $value,
          'checked' => in_array($value, (array)$selected),
          'class' => 'form-check-input'
        ]);
        $html .= form_label($label, $id, ['class' => 'form-check-label']);
        $html .= '</div>';
      }
      $html .= bsform_error($name);
      $html .= '</div>';
      return $html;
    }
  }

  // Input group with icons (prepend/append)
  if (! function_exists('bsform_input_group')) {
    function bsform_input_group($name, $value = '', $label = '', $attributes = [], $prepend = '', $append = '')
    {
      $id = $attributes['id'] ?? $name;
      $html  = '<div class="mb-3">';
      if ($label) {
        $html .= form_label($label, $id, ['class' => 'form-label']);
      }
      $html .= '<div class="input-group">';
      if ($prepend) {
        $html .= '<span class="input-group-text">' . $prepend . '</span>';
      }
      $html .= form_input(array_merge(['name' => $name, 'id' => $id, 'value' => $value, 'class' => 'form-control'], $attributes));
      if ($append) {
        $html .= '<span class="input-group-text">' . $append . '</span>';
      }
      $html .= '</div>';
      $html .= bsform_error($name);
      $html .= '</div>';
      return $html;
    }
  }
}