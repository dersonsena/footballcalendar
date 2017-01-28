<?php
/* @var yii\web\View $this */
/* @var \app\modules\entries\models\Competition $model */
use app\widgets\FormButtons;
use kartik\form\ActiveForm;
use yii\widgets\MaskedInput;
?>

<?php $form = ActiveForm::begin(['validateOnBlur' => false]) ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->hiddenInput() ?>

    <div class="form-actions">
        <?= FormButtons::widget() ?>
    </div>

    <div class="row">
        <div class="col-md-7">
            <?= $form->field($model, 'name')->textInput([
                'autofocus' => true
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'responsible') ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'responsible_phone', [
                'addon' => Yii::$app->params['defaultAddons']['phone']
            ])->widget(MaskedInput::className(), [
                'mask' => ['(99) 99999-9999', '(99) 9999-9999'],
            ]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'responsible_whatsapp', [
                'addon' => Yii::$app->params['defaultAddons']['whatsapp']
            ])->widget(MaskedInput::className(), [
                'mask' => ['(99) 99999-9999', '(99) 9999-9999'],
            ]) ?>
        </div>
    </div>

    <?= $form->field($model, 'status')->checkbox() ?>

<?php ActiveForm::end() ?>