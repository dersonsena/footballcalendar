<?php
/** @var \yii\web\View $this */
/** @var \app\models\Setting[] $settings */
/** @var \app\components\Formatter $formatter */
/** @var \app\models\Setting $teamName */
/** @var \app\models\Setting $teamAvatar */
use app\widgets\FormButtons;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;

$teamName = $settings['TEAM_NAME'];
$teamAvatar = $settings['TEAM_AVATAR'];
?>

<?php $form = ActiveForm::begin(['options' => [
    'class' => 'form-horizontal'
]]) ?>

    <div class="box form-actions">
        <div class="box-body">
            <?= FormButtons::widget([
                'renderAndContinueSaveButton' => false,
            ]) ?>
        </div>
    </div>

    <div class="box box-primary">

        <div class="box-body">
            <fieldset>
                <legend>Configurações Gerais</legend>

                <div class="form-group">
                    <?= Html::label($teamName->title, 'setting-team-name', ['class' => 'col-sm-2 control-label']) ?>
                    <div class="col-md-5">
                        <?= Html::textInput('Setting[value]['. $teamName->id .']', $teamName->value, [
                            'class' => 'form-control',
                            'id' => 'setting-team-name'
                        ]) ?>
                        <span class="help-block"><?= $teamName->description ?></span>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::label($teamAvatar->title, 'setting-team-avatar', ['class' => 'col-sm-2 control-label']) ?>
                    <div class="col-md-5">
                        <div class="col-md-3">
                            <?= Html::img(Url::base(true) . '/files/common/' . $teamAvatar->value, [
                                'class' => 'thumbnail'
                            ]) ?>
                        </div>

                        <div class="col-md-9">
                            <?= Html::textInput('Setting[value]['. $teamAvatar->id .']', $teamAvatar->value, [
                                'class' => 'form-control',
                                'id' => 'setting-team-avatar'
                            ]) ?>
                            <span class="help-block"><?= $teamAvatar->description ?></span>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
<?php ActiveForm::end() ?>