<?php
$errors = session()->getFlashdata('errors') ?? [];
?>

<div class="modal" id="user-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modal-label">Add User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="user-form" data-table="#user-table">
          <?= csrf_field(); ?>
          <input type="hidden" name="id">
          <?= view('admin/users/_userFormFields', ['errors' => $errors]) ?>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="user-form" id="form-submit-btn">Save</button>
      </div>
    </div>
  </div>
</div>