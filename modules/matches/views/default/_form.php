<?php
/* @var yii\web\View $this */
/* @var \app\modules\matches\models\Match $model */
/* @var \app\modules\entries\models\Player[] $players */
use app\models\Flag;
use app\models\Setting;
use app\modules\entries\models\Competition;
use app\modules\entries\models\Place;
use app\modules\entries\models\Team;
use app\modules\matches\assets\MatchesFormAsset;
use app\widgets\FormButtons;
use kartik\date\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Json;
use yii\web\View;

MatchesFormAsset::register($this);

$this->registerJs('
    var dataSheetUpdate = '. Json::encode($model->dataSheet) .'
', View::POS_BEGIN);

$this->registerJs('
    var selectMatchType = document.querySelector("select#match-type_id");
    var selectCompetition = document.querySelector("select#match-competition_id");
    var isNewRecord = (document.querySelector("input#match-id").value === "");
    
    selectMatchType.onchange = function() {
        selectCompetition.disabled = (this.value != 13);
        
        if (this.value != 13)
            selectCompetition.value = "";
    };
    
    if (!isNewRecord)
        $(selectMatchType).trigger("change");
');
?>

<?php $form = ActiveForm::begin(['validateOnBlur' => false]) ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->hiddenInput() ?>

    <div class="form-actions">
        <?= FormButtons::widget() ?>
    </div>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'date')
                ->widget(DatePicker::classname(), Yii::$app->params['datepickerOptions']) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'place_id')->dropDownList((new Place)->getDropdownOptions('name'), [
                'prompt' => ':: SELECIONE ::'
            ]) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'status_id')->dropDownList(Flag::getFlagsDownDownOptions('MATCH_STATUS'), [
                'prompt' => ':: SELECIONE ::'
            ]) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'type_id')->dropDownList(Flag::getFlagsDownDownOptions('MATCH_TYPE'), [
                'prompt' => ':: SELECIONE ::'
            ]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'competition_id')->dropDownList((new Competition)->getDropdownOptions('name'), [
                'prompt' => ':: NENHUMA ::',
                'disabled' => 'disabled'
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'observations')->textarea([
                'style' => 'height: 120px;'
            ]) ?>
        </div>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="alert alert-warning clearfix">
            <div class="col-md-offset-2 col-md-2">
                <h3><?= Setting::getSettingByAbbreviation('TEAM_NAME')->value ?></h3>
            </div>

            <div class="col-md-1" style="margin-top: 12px">
                <?= Html::activeInput('number', $model, 'score_owner', ['class' => 'input-lg form-control text-center']) ?>
            </div>

            <div class="col-md-1 text-center">
                <h3>VS</h3>
            </div>

            <div class="col-md-1" style="margin-top: 12px">
                <?= Html::activeInput('number', $model, 'score_guest', ['class' => 'input-lg form-control text-center']) ?>
            </div>

            <div class="col-md-3" style="margin-top: 12px">
                <?= $form->field($model, 'team_id')->dropDownList((new Team)->getDropdownOptions('name'), [
                    'prompt' => ':: ADVERSÁRIO ::',
                    'class' => 'form-control input-lg'
                ])->label(false) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <table id="dataSheet" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th colspan="4" class="text-center">
                            <h3 style="margin-top: 10px">Ficha Técnica</h3>
                        </th>
                    </tr>
                    <tr>
                        <th style="width: 35px" class="text-center"><i class="fa fa-trash"></i></th>
                        <th>Atleta</th>
                        <th style="width: 85px" class="text-right">Nº Gol(s)</th>
                        <th style="width: 100px" class="text-right">Nº Assist.</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-center">
                            <i class="fa fa-info-circle"></i> Nenhum jogador neste jogo.
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="col-md-5">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th colspan="4" class="text-center">
                            <h3 style="margin-top: 10px">Atletas</h3>
                        </th>
                    </tr>
                    <tr>
                        <th style="width: 60px">&nbsp;</th>
                        <th>Atleta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($players as $player) : ?>
                        <tr id="player-<?= $player->id ?>" class="row-players">
                            <td class="text-center">
                                <?= Html::button('<i class="fa fa-plus-circle"></i>', [
                                    'class' => 'btn btn-success btn-add-player',
                                    'title' => 'Adicionar atleta na ficha técnica',
                                    'onclick' => 'MatchesForm.addPlayerInDataSheet('. Json::encode($player) .')'
                                ]) ?>
                                <?= Html::hiddenInput('player[]', Json::encode($player)) ?>
                            </td>
                            <td>
                                <?= $player->name ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php ActiveForm::end() ?>