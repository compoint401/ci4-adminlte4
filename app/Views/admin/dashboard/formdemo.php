<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>


<div class="row justify-content-center">
    <div class="col-lg-8 p-5 rounded shadow-sm">

        <h2 class="mb-4 pb-2 border-bottom text-primary">CI4 Form Helper Catalog</h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <!-- Form Open with CSRF Protection automatically included -->
        <?= form_open('bsformdemo/submit', ['id' => 'allFieldsForm', 'novalidate' => '']) ?>

        <div class="row">
            <!-- 1. Standard Text Input -->
            <div class="col-md-6 mb-3">
                <?= form_label('Text Field', 'text_field', ['class' => 'form-label']) ?>
                <?php
                $err = $validation->hasError('text_field') ? ' is-invalid' : '';
                echo form_input([
                    'name'        => 'text_field',
                    'id'          => 'text_field',
                    'value'       => set_value('text_field'),
                    'class'       => 'form-control' . $err,
                    'placeholder' => 'Enter text...'
                ]);
                ?>
                <div class="invalid-feedback"><?= $validation->getError('text_field') ?></div>
            </div>

            <!-- 2. Email Input -->
            <div class="col-md-6 mb-3">
                <?= form_label('Email Address', 'email_field', ['class' => 'form-label']) ?>
                <?php
                $err = $validation->hasError('email_field') ? ' is-invalid' : '';
                echo form_input([
                    'type'        => 'email',
                    'name'        => 'email_field',
                    'id'          => 'email_field',
                    'value'       => set_value('email_field'),
                    'class'       => 'form-control' . $err,
                    'placeholder' => 'name@example.com'
                ]);
                ?>
                <div class="invalid-feedback"><?= $validation->getError('email_field') ?></div>
            </div>
        </div>

        <div class="row">
            <!-- 3. Password Input -->
            <div class="col-md-6 mb-3">
                <?= form_label('Password Field', 'pass_field', ['class' => 'form-label']) ?>
                <?php
                $err = $validation->hasError('pass_field') ? ' is-invalid' : '';
                echo form_password([
                    'name'        => 'pass_field',
                    'id'          => 'pass_field',
                    'class'       => 'form-control' . $err,
                    'placeholder' => '••••••••'
                ]);
                ?>
                <div class="invalid-feedback"><?= $validation->getError('pass_field') ?></div>
            </div>

            <!-- 4. Number Input -->
            <div class="col-md-6 mb-3">
                <?= form_label('Number Range Field', 'num_field', ['class' => 'form-label']) ?>
                <?php echo form_input([
                    'type'  => 'number',
                    'name'  => 'num_field',
                    'id'    => 'num_field',
                    'min'   => '1',
                    'max'   => '100',
                    'value' => set_value('num_field', '10'),
                    'class' => 'form-control'
                ]); ?>
            </div>
        </div>

        <!-- 5. Select Dropdown Menu -->
        <div class="mb-3">
            <?= form_label('Dropdown Select Menu', 'select_menu', ['class' => 'form-label']) ?>
            <?php
            $options = [
                ''         => 'Open this select menu',
                'option_1' => 'First Choice Option',
                'option_2' => 'Second Choice Option',
                'option_3' => 'Third Choice Option',
            ];
            $err = $validation->hasError('select_menu') ? ' is-invalid' : '';
            echo form_dropdown('select_menu', $options, set_value('select_menu'), [
                'id'    => 'select_menu',
                'class' => 'form-select' . $err
            ]);
            ?>
            <div class="invalid-feedback"><?= $validation->getError('select_menu') ?></div>
        </div>

        <!-- 6. Multiselect Box -->
        <div class="mb-3">
            <?= form_label('Multi-Select Menu (Hold Ctrl)', 'multi_select', ['class' => 'form-label']) ?>
            <?php
            $multioptions = [
                'tag_1' => 'Development',
                'tag_2' => 'Design',
                'tag_3' => 'Marketing',
                'tag_4' => 'SEO'
            ];
            echo form_multiselect('multi_select[]', $multioptions, set_value('multi_select[]',[]), [
                'id'    => 'multi_select',
                'class' => 'form-select',
                'rows'  => '3'
            ]);
            ?>
        </div>

        <!-- 7. Textarea Form Control -->
        <div class="mb-3">
            <?= form_label('Text Area Input Description', 'textarea_field', ['class' => 'form-label']) ?>
            <?php echo form_textarea([
                'name'        => 'textarea_field',
                'id'          => 'textarea_field',
                'rows'        => '3',
                'value'       => set_value('textarea_field'),
                'class'       => 'form-control',
                'placeholder' => 'Provide background notes...'
            ]); ?>
        </div>

        <!-- 8. Native File Upload Field -->
        <div class="mb-4">
            <?= form_label('Attachment / File Input', 'file_field', ['class' => 'form-label']) ?>
            <?php echo form_upload([
                'name'  => 'file_field',
                'id'    => 'file_field',
                'class' => 'form-control'
            ]); ?>
        </div>

        <!-- 9. Radio Buttons (Bootstrap 5 Stack Layout) -->
        <div class="mb-4">
            <label class="form-label d-block">Choose Priority Level</label>
            <div class="form-check form-check-inline">
                <?= form_radio([
                    'name'    => 'priority_radio',
                    'id'      => 'radio_low',
                    'value'   => 'low',
                    'checked' => set_radio('priority_radio', 'low', true),
                    'class'   => 'form-check-input'
                ]) ?>
                <?= form_label('Low', 'radio_low', ['class' => 'form-check-label']) ?>
            </div>
            <div class="form-check form-check-inline">
                <?= form_radio([
                    'name'    => 'priority_radio',
                    'id'      => 'radio_high',
                    'value'   => 'high',
                    'checked' => set_radio('priority_radio', 'high'),
                    'class'   => 'form-check-input'
                ]) ?>
                <?= form_label('High', 'radio_high', ['class' => 'form-check-label']) ?>
            </div>
        </div>

        <!-- 10. Checkboxes (Single Opt-in wrapper) -->
        <div class="form-check mb-4">
            <?php
            $err = $validation->hasError('terms_check') ? ' is-invalid' : '';
            echo form_checkbox([
                'name'    => 'terms_check',
                'id'      => 'terms_check',
                'value'   => 'accepted',
                'checked' => set_checkbox('terms_check', 'accepted'),
                'class'   => 'form-check-input' . $err
            ]);
            ?>
            <?= form_label('I accept all service terms and conditions', 'terms_check', ['class' => 'form-check-label']) ?>
            <div class="invalid-feedback"><?= $validation->getError('terms_check') ?></div>
        </div>

        <!-- Hidden Element Demo -->
        <?= form_hidden('hidden_user_id', 'USR-90210') ?>

        <!-- Actions Row -->
        <div class="d-flex gap-2">
            <?= form_button('submit_btn', 'Submit All Fields', ['class' => 'btn btn-primary px-4', 'type' => 'submit']) ?>
            <?= form_reset('reset_btn', 'Reset Form', ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <!-- Form Close Tag -->
        <?= form_close() ?>

    </div>
</div>
<?= $this->endSection(); ?>