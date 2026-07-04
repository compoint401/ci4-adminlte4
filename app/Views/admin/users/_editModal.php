<div class="modal fade editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= route_to('update.user'); ?>" method="post" id="update-user-form">
          <?= csrf_field(); ?>
          <input type="hidden" name="cid">
          <?= form_input_group([
            'name' => 'username',
            'label' => lang('Auth.username'),
            'value' => old('username'),
            'extra_attrs' => 'required'
          ]) ?>
          <?= form_input_group([
            'name' => 'password',
            'label' => lang('Auth.password'),
            'type' => 'password',
            'extra_attrs' => 'required autocomplete="new-password"'
          ]) ?>
          <?= form_input_group([
            'name' => 'password_confirm',
            'label' => lang('Auth.passwordConfirm'),
            'type' => 'password',
            'extra_attrs' => 'required autocomplete="new-password"'
          ]) ?>
          <?= form_select_group([
            'name' => 'gender',
            'label' => lang('Auth.gender'),
            'selected' => old('gender'),
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
            'extra_attrs' => 'required'
          ]) ?>
          <?= form_input_group([
            'name' => 'last_name',
            'label' => lang('Auth.last_name'),
            'value' => old('last_name'),
            'extra_attrs' => 'required'
          ]) ?>
          <?= form_input_group([
            'name' => 'phone_number',
            'label' => lang('Auth.phone_number'),
            'value' => old('phone_number'),
            'extra_attrs' => 'required'
          ]) ?>
          <?= form_select_group([
            'name' => 'usertype',
            'label' => 'User Type',
            'selected' => old('usertype', []),
            'options' => [
              'user' => 'User',
              'admin' => 'Admin',
              'superadmin' => 'Super Admin'
            ],
            'multiple' => true
          ]) ?>
          <div class="d-grid col-12 col-md-8 mx-auto m-3">
            <button type="submit" class="btn btn-block btn-success">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>