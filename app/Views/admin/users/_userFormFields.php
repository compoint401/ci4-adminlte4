<div class="email-field-group">
  <?= form_input_group([
    'name' => 'email',
    'label' => lang('Auth.email'),
    'type' => 'email',
    'value' => old('email'),
    'floating' => true,
    'extra_attrs' => 'required'
  ]) ?>
</div>

<?= form_input_group([
  'name' => 'username',
  'label' => lang('Auth.username'),
  'value' => old('username'),
  'floating' => true,
  'extra_attrs' => 'required'
]) ?>
<?= form_input_group([
  'name' => 'password',
  'label' => lang('Auth.password'),
  'type' => 'password',
  'floating' => true,
  'extra_attrs' => 'required autocomplete="new-password"'
]) ?>
<?= form_input_group([
  'name' => 'password_confirm',
  'label' => lang('Auth.passwordConfirm'),
  'type' => 'password',
  'floating' => true,
  'extra_attrs' => 'required autocomplete="new-password"'
]) ?>
<?= form_select_group([
  'name' => 'gender',
  'label' => lang('Auth.gender'),
  'selected' => old('gender'),
  'floating' => true,
  'options' => [
    'male' => 'Male',
    'female' => 'Female',
    'bisexual' => 'Bisexual'
  ]
]) ?>
<?= form_input_group([
  'name' => 'first_name',
  'label' => lang('Auth.first_name'),
  'value' => old('first_name'),
  'floating' => true,
  'extra_attrs' => 'required'
]) ?>
<?= form_input_group([
  'name' => 'last_name',
  'label' => lang('Auth.last_name'),
  'value' => old('last_name'),
  'floating' => true,
  'extra_attrs' => 'required'
]) ?>
<?= form_input_group([
  'name' => 'phone_number',
  'label' => lang('Auth.phone_number'),
  'value' => old('phone_number'),
  'floating' => true,
  'extra_attrs' => 'required'
]) ?>
<div class="usertype-field-group" style="display: none;">
  <?= form_select_group([
    'name' => 'usertype',
    'label' => 'User Type',
    'selected' => old('usertype', []),
    'floating' => true,
    'options' => [
      'user' => 'User',
      'admin' => 'Admin',
      'superadmin' => 'Super Admin'
    ],
    'multiple' => true,
    'extra_attrs' => ' size="4" '
  ]) ?>
</div>