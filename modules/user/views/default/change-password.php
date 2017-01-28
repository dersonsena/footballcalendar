<?php
/* @var yii\web\View $this */
/* @var \backend\modules\user\forms\ChangePasswordForm $model */
use kartik\form\ActiveForm;
use kartik\password\PasswordInput;

?>

<?php $form = ActiveForm::begin(['validateOnBlur' => false]) ?>

    <div class="box form-actions">
        <div class="box-body">
            <?= $this->render('@backend/views/partials/crud/form-default-buttons') ?>
        </div>
    </div>

    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-lock"></i> Alteração da Senha de Acesso
            </h3>
        </div>

        <div class="box-body">

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'currentPassword')
                        ->passwordInput(['maxlength' => true])
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'newPassword')
                        ->passwordInput(['maxlength' => true])
                        ->widget(PasswordInput::classname(), [
                            'language' => 'pt-BR'
                        ])
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'repeatPassword')
                        ->passwordInput(['maxlength' => true])
                    ?>
                </div>
            </div>

        </div>

    </div>

<?php ActiveForm::end() ?>