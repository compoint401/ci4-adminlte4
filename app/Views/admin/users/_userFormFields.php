<div class="email-field-group">
  <?= bsform_floating_input('email',old('email'),lang('Auth.email'),['type' => 'email','required'=>true]) ?>
</div>

<?= bsform_floating_input('username',old('username'),lang('Auth.username'),['required'=>true]) ?>
<?= bsform_floating_input('password','',lang('Auth.password'),['type' => 'password','required'=>true,'autocomplete'=>'new-password']) ?>
<?= bsform_floating_input('password_confirm','',lang('Auth.passwordConfirm'),['type' => 'password','required'=>true, 'autocomplete'=>'new-password']) ?>
<?php 
$gender = [
    'male' => 'Male',
    'female' => 'Female',
    'bisexual' => 'Bisexual'
  ];
 echo bsform_select('gender',$gender,lang('Auth.gender'),old('gender'),['required'=>true]); 
?>
<?= bsform_floating_input('first_name',old('first_name'),lang('Auth.first_name'),['required'=>true]) ?>
<?= bsform_floating_input('last_name',old('last_name'),lang('Auth.last_name'),['required'=>true]) ?>
<?= bsform_floating_input('phone_number',old('phone_number'),lang('Auth.phone_number'),['required'=>true]) ?>

<div class="usertype-field-group" style="display:none;">
<?php  
$usertypes = [
    'user'        => 'User',
    'admin'       => 'Admin',
    'superadmin'  => 'Super Admin'
];

echo bsform_select('usertype',$usertypes,lang('Auth.usertype'),old('usertype'),['required'=>true, 'multiple' => true,'extra_attrs' => ' style="min-height:7rem;"']); 
?>
</div>