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

  <?= bsform_open('bsformdemo/submit', ['class' => 'needs-validation', 'novalidate' => true]) ?>

  <?= bsform_input('username', old('username'), 'Username', ['placeholder' => 'Enter username']) ?>
  <?= bsform_password('password', '', 'Password') ?>
  <?= bsform_email('email', old('email'), 'Email Address') ?>
  <?= bsform_textarea('bio', old('bio'), 'Short Bio', ['rows' => 3]) ?>
  <?= bsform_select('gender', ['m' => 'Male', 'f' => 'Female'], 'Gender', old('gender')) ?>
  <?= bsform_checkbox('terms', '1', old('terms') ? true : false, 'Accept Terms & Conditions') ?>
  <?= bsform_radio_group('subscription', ['basic' => 'Basic', 'pro' => 'Pro'], old('subscription'), true) ?>
  <?= bsform_select('languages[]', ['en' => 'English', 'fr' => 'French'], 'Languages Known', old('languages'),  ['multiple' => 'multiple']) ?>
  <?= bsform_floating_input('phone', old('phone'), 'Phone Number', ['type' => 'tel']) ?>
  <?= bsform_floating_textarea('address', old('address'), 'Address', ['rows' => 3]) ?>
  <?= bsform_input_group('amount', old('amount'), 'Amount', ['placeholder' => 'Enter amount'], '$', '.00') ?>
  <?= bsform_file('profile_pic', 'Upload Profile Picture') ?>

  <div class="mt-4">
    <?= bsform_submit('Register', ['class' => 'btn btn-primary me-2']) ?>
    <?= bsform_reset('Clear', ['class' => 'btn btn-secondary']) ?>
  </div>

  <?= bsform_close() ?>

</div>
<!--end::Row-->


<?= $this->endSection(); ?>
<?= $this->section('scripts') ?>
<script>
// Bootstrap client-side validation
(() => {
  'use strict';

  // Fetch all forms with needs-validation class
  const forms = document.querySelectorAll('.needs-validation');

  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>
<?= $this->endSection(); ?>