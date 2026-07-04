<div class="modal fade addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form action="<?= route_to('add.user'); ?>" method="post" id="add-user-form">
          <?= csrf_field(); ?>
          <!-- Email -->
          <div class="form-floating mb-2">
            <label for="email"><?= lang('Auth.email') ?></label>
            <input type="email" class="form-control" id="email" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
            <span class="text-danger error-text email_error"></span>
          </div>

          <!-- Username -->
          <div class="form-floating mb-4">
            <label for="username"><?= lang('Auth.username') ?></label>
            <input type="text" class="form-control" id="username" name="username" inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required>
            <span class="text-danger error-text username_error"></span>
          </div>

          <!-- Password -->
          <div class="form-floating mb-2">
            <label for="password"><?= lang('Auth.password') ?></label>
            <input type="password" class="form-control" id="password" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required>
            <span class="text-danger error-text password_error"></span>
          </div>

          <!-- Password (Again) -->
          <div class="form-floating mb-5">
            <label for="password_confirm"><?= lang('Auth.passwordConfirm') ?></label>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required>
            <span class="text-danger error-text password_confirm_error"></span>
          </div>
          <!-- Gender-->
          <div class="form-floating mb-4">
            <label for="inputGender"><?= lang('Auth.gender') ?></label>
            <select id="inputGender" class="form-control" name="gender" placeholder="<?= lang('Auth.gender') ?>">
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="bisexual">Bisexual</option>
            </select>
            <span class="text-danger error-text gender_error"></span>
          </div>
          <!-- First Name-->
          <div class="form-floating mb-4">
            <label for="first_name"><?= lang('Auth.first_name') ?></label>
            <input type="text" class="form-control" name="first_name" id="first_name" inputmode="text" autocomplete="first_name" placeholder="<?= lang('Auth.first_name') ?>" value="<?= old('first_name') ?>" required />
            <span class="text-danger error-text first_name_error"></span>
          </div>
          <!-- Last Name-->
          <div class="form-floating mb-4">
            <label for="last_name"><?= lang('Auth.last_name') ?></label>
            <input type="text" class="form-control" name="last_name" id="last_name" inputmode="text" autocomplete="last_name" placeholder="<?= lang('Auth.last_name') ?>" value="<?= old('last_name') ?>" required />
            <span class="text-danger error-text last_name_error"></span>
          </div>
          <!-- Phone Number -->
          <div class="form-floating mb-4">
            <label for="phone_number"><?= lang('Auth.phone_number') ?></label>
            <input type="text" class="form-control" name='phone_number' id="phone_number" inputmode="text" autocomplete='phone_number' placeholder="<?= lang('Auth.phone_number') ?>" value="<?= old('phone_number') ?>" required />
            <span class="text-danger error-text phone_number_error"></span>
          </div>
          <div class="d-grid col-12 col-md-8 mx-auto m-3">
            <button type="submit" class="btn btn-primary btn-block">Add User</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>