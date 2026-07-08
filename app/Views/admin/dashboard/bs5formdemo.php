<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>

<!--begin::Row-->
<div class="row">

  <h2>Demo Bootstrap 5 Form</h2>

  <!-- Success message -->
  <?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success">
    <?= session()->getFlashdata('success') ?>
  </div>
  <?php endif; ?>

  <!-- Validation errors (global) -->
  <?php if (session('errors')): ?>
  <div class="alert alert-danger">
    Please fix the errors below.
  </div>
  <?php endif; ?>

  <?php
  // Open form
  ?>
  <?= bsform_open('bsformdemo/submit', ['class' => 'needs-validation', 'novalidate' => true]) ?>

  <h4>Standard Form Controls</h4>
  <?= bsform_input('username', '', 'Username', [
    'placeholder' => 'Enter username',
    'required' => true
  ]) ?>
  <?= bsform_textarea('bio', '', 'Short Bio', ['placeholder' => 'Write something...']) ?>
  <?= bsform_select('gender', ['m' => 'Male', 'f' => 'Female'], 'Gender', '', [
    'required' => true
  ]) ?>
  <?= bsform_datepicker('dob', '', 'Date of Birth', ['required' => true]) ?>
  <?= bsform_checkbox('terms', '1', false, 'Accept Terms') ?>
  <?= bsform_radio('newsletter', 'yes', false, 'Subscribe') ?>
  <?= bsform_switch('darkmode', '1', false, 'Enable Dark Mode') ?>

  <h4>Floating Labels</h4>
  <?= bsform_floating_input('email', '', 'Email Address', [
    'type' => 'email',
    'required' => true
  ]) ?>
  <?= bsform_floating_textarea('about', '', 'About You') ?>
  <?= bsform_floating_select('country', ['in' => 'India', 'us' => 'USA'], 'Country') ?>
  <?= bsform_floating_datepicker('start_date', '', 'Start Date') ?>

  <h4>Horizontal Form Controls</h4>
  <?= bsform_horizontal_input('password', '', 'Password', [
    'type' => 'password',
    'required' => true
  ]) ?>
  <?= bsform_horizontal_textarea('address', '', 'Address') ?>
  <?= bsform_horizontal_select('role', ['admin' => 'Admin', 'user' => 'User'], 'Role') ?>
  <?= bsform_horizontal_datepicker('end_date', '', 'End Date') ?>

  <?= bsform_submit('Register', ['class' => 'btn btn-primary']) ?>
  <?= bsform_close() ?>

</div>

<?= $this->endsection() ?>