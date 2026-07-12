<?php

if (! function_exists('display_error')) {
    /**
     * Displays a Bootstrap validation error block for a given form field.
     *
     * @param string $field  The name of the form field.
     * @param array  $errors The array of validation errors.
     *
     * @return string The HTML for the error message, or an empty string if no error exists.
     */
    function display_error(string $field, array $errors): string
    {
        if (isset($errors[$field])) {
            return '<div class="invalid-feedback d-block">' . esc($errors[$field]) . '</div>';
        }
        return '';
    }
}

if (! function_exists('form_input_group')) {
    /**
     * Generates a Bootstrap 5 form group for an input field.
     *
     * @param array $params Parameters for the input field.
     *                      'name'         => (string) Field name.
     *                      'label'        => (string) Field label.
     *                      'value'        => (string) Field value.
     *                      'errors'       => (array)  Validation errors.
     *                      'type'         => (string) Optional. Input type (default: 'text').
     *                      'extra_attrs'  => (string) Optional. Extra attributes for the input tag.
     *                      'placeholder'  => (string) Optional. Placeholder text.
     *
     * @return string The HTML for the form group.
     */
    function form_input_group(array $params): string
    {
        $name        = $params['name'];
        $label       = $params['label'];
        $value       = $params['value'] ?? '';
        $errors      = $params['errors'] ?? [];
        $type        = $params['type'] ?? 'text';
        $extra_attrs = $params['extra_attrs'] ?? '';
        $placeholder = $params['placeholder'] ?? "Enter {$label}";
        $error_class = isset($errors[$name]) ? 'is-invalid' : '';

        $input = "<input type='{$type}' name='{$name}' id='{$name}' class='form-control {$error_class}' placeholder='{$placeholder}' value='" . esc($value, 'attr') . "' {$extra_attrs}>";

        return "<div class='mb-3'>
                    <label for='{$name}' class='form-label'>{$label}</label>
                    {$input}"
            . display_error($name, $errors) .
            "</div>";
    }
}

if (! function_exists('form_select_group')) {
    /**
     * Generates a Bootstrap 5 form group for a select field.
     *
     * @param array $params Parameters for the select field.
     *                      'name'         => (string) Field name.
     *                      'label'        => (string) Field label.
     *                      'selected'     => (string|array) The selected value(s).
     *                      'options'      => (array)  Key-value pairs for options.
     *                      'errors'       => (array)  Validation errors.
     *                      'multiple'     => (bool)   Optional. True for a multiple select (default: false).
     *
     * @return string The HTML for the form group.
     */
    function form_select_group(array $params): string
    {
        $name        = $params['name'];
        $label       = $params['label'];
        $selected    = $params['selected'] ?? [];
        $options     = $params['options'] ?? [];
        $errors      = $params['errors'] ?? [];
        $is_multiple = $params['multiple'] ?? false;
        $error_class = isset($errors[$name]) ? 'is-invalid' : '';
        $multiple_attr = $is_multiple ? 'multiple' : '';
        $selected_values = is_array($selected) ? $selected : [$selected];

        $select = "<select name='{$name}' id='{$name}' class='form-select {$error_class}' {$multiple_attr}>";
        if (!$is_multiple) {
            $select .= "<option value='' disabled selected>Select {$label}</option>";
        }

        foreach ($options as $value => $optionLabel) {
            $isSelected = in_array((string)$value, $selected_values, true) ? 'selected' : '';
            $select .= "<option value='" . esc($value, 'attr') . "' {$isSelected}>" . esc($optionLabel) . "</option>";
        }

        $select .= "</select>";

        return "<div class='mb-3'>
                    <label for='{$name}' class='form-label'>{$label}</label>
                    {$select}"
            . display_error($name, $errors) .
            "</div>";
    }
}

if (! function_exists('form_textarea_group')) {
    /**
     * Generates a Bootstrap 5 form group for a textarea field.
     *
     * @param array $params Parameters for the textarea field.
     *                      'name'         => (string) Field name.
     *                      'label'        => (string) Field label.
     *                      'value'        => (string) Field value.
     *                      'errors'       => (array)  Validation errors.
     *                      'extra_attrs'  => (string) Optional. Extra attributes for the textarea tag.
     *                      'placeholder'  => (string) Optional. Placeholder text.
     *
     * @return string The HTML for the form group.
     */
    function form_textarea_group(array $params): string
    {
        $name        = $params['name'];
        $label       = $params['label'];
        $value       = $params['value'] ?? '';
        $errors      = $params['errors'] ?? [];
        $extra_attrs = $params['extra_attrs'] ?? 'rows="4"';
        $placeholder = $params['placeholder'] ?? "Enter {$label}";
        $error_class = isset($errors[$name]) ? 'is-invalid' : '';

        $textarea = "<textarea name='{$name}' id='{$name}' class='form-control {$error_class}' placeholder='{$placeholder}' {$extra_attrs}>" . esc($value) . "</textarea>";

        return "<div class='mb-3'>
                    <label for='{$name}' class='form-label'>{$label}</label>
                    {$textarea}"
            . display_error($name, $errors) .
            "</div>";
    }
}
