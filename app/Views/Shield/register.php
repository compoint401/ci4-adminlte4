<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container d-flex justify-content-center p-5">
  <div class="card col-12 col-md-5 shadow-sm">
    <div class="card-body">
      <h5 class="card-title mb-5"><?= lang('Auth.register') ?></h5>

      <?php if (session('error') !== null): ?>
        <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
      <?php elseif (session('errors') !== null): ?>
        <div class="alert alert-danger" role="alert">
          <?php if (is_array(session('errors'))): ?>
            <?php foreach (session('errors') as $error): ?>
              <?= $error ?>
              <br>
            <?php endforeach ?>
          <?php else: ?>
            <?= session('errors') ?>
          <?php endif ?>
        </div>
      <?php endif ?>

      <form action="<?= url_to('register') ?>" method="post">
        <?= csrf_field() ?>

        <!-- Email -->
        <div class="form-floating mb-2">
          <input type="email" class="form-control" id="floatingEmailInput" name="email" inputmode="email"
            autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
          <label for="floatingEmailInput"><?= lang('Auth.email') ?></label>
        </div>

        <!-- Username -->
        <div class="form-floating mb-4">
          <input type="text" class="form-control" id="floatingUsernameInput" name="username" inputmode="text"
            autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required>
          <label for="floatingUsernameInput"><?= lang('Auth.username') ?></label>
        </div>

        <!-- Password -->
        <div class="form-floating mb-2">
          <input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text"
            autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required>
          <label for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
        </div>

        <!-- Password (Again) -->
        <div class="form-floating mb-5">
          <input type="password" class="form-control" id="floatingPasswordConfirmInput" name="password_confirm"
            inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required>
          <label for="floatingPasswordConfirmInput"><?= lang('Auth.passwordConfirm') ?></label>
        </div>
      <!-- Gender-->
        <div class="form-floating mb-4">
          <select id="gender" class="form-control" name="gender" id="floatingGender" placeholder="<?= lang('Auth.gender') ?>">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="bisexual">Bisexual</option>
          </select>
          <label for="floatingGender"><?= lang('Auth.gender') ?></label>
        </div>
        <!-- First Name-->
        <div class="form-floating mb-4">
          <input type="text" class="form-control" name="first_name" id="floatingFirstName" inputmode="text" autocomplete="first_name"
            placeholder="<?= lang('Auth.first_name') ?>" value="<?= old('first_name') ?>" required />
            <label for="floatingFirstName"><?= lang('Auth.first_name') ?></label>
        </div>
        <!-- Last Name-->
        <div class="form-floating mb-4">
          <input type="text" class="form-control" name="last_name" id="floatingLastName" inputmode="text" autocomplete="last_name"
            placeholder="<?= lang('Auth.last_name') ?>" value="<?= old('last_name') ?>" required />
            <label for="floatingLastName"><?= lang('Auth.last_name') ?></label>
        </div>
        <!-- Phone Number -->
        <div class="form-floating mb-4">
          <input type="text" class="form-control" name='phone_number' id="floatingPhoneNo" inputmode="text" autocomplete='phone_number'
            placeholder="<?= lang('Auth.phone_number') ?>" value="<?= old('phone_number') ?>" required />
            <label for="floatingPhoneNo"><?= lang('Auth.phone_number') ?></label>
        </div>
        <div class="d-grid col-12 col-md-8 mx-auto m-3">
          <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
        </div>

        <p class="text-center"><?= lang('Auth.haveAccount') ?> <a
            href="<?= url_to('login') ?>"><?= lang('Auth.login') ?></a></p>

      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>