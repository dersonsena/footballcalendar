<?php
/* @var yii\web\View $this */
/* @var \backend\modules\user\models\User $model */

use backend\modules\entries\models\Store;
use backend\modules\user\models\Group;
use kartik\form\ActiveForm;
use kartik\password\PasswordInput;
use kartik\select2\Select2;

?>

<?php $form = ActiveForm::begin(['validateOnBlur' => false]) ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->hiddenInput() ?>

    <div class="box form-actions">
        <div class="box-body">
            <?= $this->render('@backend/views/partials/crud/form-default-buttons') ?>
        </div>
    </div>

    <div class="box box-primary">

        <div class="box-header with-border">
            <h3 class="box-title">Formulário</h3>
        </div>

        <div class="box-body">

            <div class="row">

                <div class="col-md-5">
                    <?= $form->field($model, 'name') ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'email', [
                        'addon' => Yii::$app->params['defaultAddons']['email']
                    ]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'group_id', ['template'=>"{label}{input}{error}{hint}"])
                        ->dropDownList((new Group)->getDropdownOptions('name'), [
                            'prompt' => ':: SELECIONE ::'
                        ]) ?>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'storesList')->widget(Select2::classname(), [
                        'data' => (new Store)->getDropdownOptions('name'),
                        'language' => 'pt-BR',
                        'options' => [
                            'placeholder' => 'Selecione pelo menos uma loja...',
                            'multiple' => true
                        ],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ]); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'password')
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
                        ->hint($model->isNewRecord ? null : 'Mantenha o campo vazio para que a senha atual não seja alterada.')
                    ?>
                </div>
            </div>

            <?= $form->field($model, 'status')->checkbox() ?>

        </div>

    </div>

<?php ActiveForm::end() ?>