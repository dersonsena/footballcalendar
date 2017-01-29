<?php
/* @var yii\web\View $this */
/* @var \app\modules\entries\models\Team $model */
use app\widgets\FormButtons;
use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin(['validateOnBlur' => false]) ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->hiddenInput() ?>

    <div class="form-actions">
        <?= FormButtons::widget() ?>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput([
                'autofocus' => true
            ]) ?>
        </div>
    </div>

    <?= $form->field($model, 'status')->checkbox() ?>

<?php ActiveForm::end() ?>