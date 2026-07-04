<?php
$errors = session()->getFlashdata('errors') ?? [];
?>

<div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-label">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="user-form" data-table="#user-table">
          <?= csrf_field(); ?>
          <input type="hidden" name="id">

          <?= view('admin/users/_userFormFields', ['errors' => $errors]) ?>

          <div class="d-grid col-12 col-md-8 mx-auto m-3">
            <button type="submit" class="btn btn-block btn-primary" id="form-submit-btn">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>