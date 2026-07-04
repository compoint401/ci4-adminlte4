<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <div class="col-md-4 offset-md-4">
    <form action="<?= route_to('user.savepwd'); ?>" method="post" id="passwordreset-form">
      <?= csrf_field(); ?>

      <!-- Password -->
      <div class="form-floating mb-2">
        <label for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
        <input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text"
          autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required>
        <span class="text-danger error-text password_error"></span>
      </div>

      <!-- Password (Again) -->
      <div class="form-floating mb-5">
        <label for="floatingPasswordConfirmInput"><?= lang('Auth.passwordConfirm') ?></label>
        <input type="password" class="form-control" id="floatingPasswordConfirmInput" name="password_confirm"
          inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required>
        <span class="text-danger error-text password_confirm_error"></span>
      </div>

      <div class="d-grid col-12 col-md-8 mx-auto m-3">
        <button type="submit" class="btn btn-primary btn-block">Save Password</button>
      </div>
  </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('scripts'); ?>
<script>
  $('#passwordreset-form').submit(function(e) {
    e.preventDefault();
    var form = this;
    $.ajax({
      url: $(form).attr('action'),
      method: $(form).attr('method'),
      data: new FormData(form),
      processData: false,
      dataType: 'json',
      contentType: false,
      beforeSend: function() {
        $(form).find('span.error-text').text('');
      },
      success: function(data) {
        if ($.isEmptyObject(data.error)) {
          if (data.code == 1) {
            Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: data.msg,
              showConfirmButton: false,
              timer: 2000
            }).then(function() {
              window.location.href = "<?= route_to('user.home') ?>";
            });
          } else {
            alert(data.msg);
          }
        } else {
          $.each(data.error, function(prefix, val) {
            $(form).find('span.' + prefix + '_error').text(val);
          });
        }
      }
    });
  });
</script>
<?= $this->endSection(); ?>