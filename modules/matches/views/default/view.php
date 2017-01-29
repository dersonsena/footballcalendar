<?php
/* @var $this yii\web\View */
/* @var \app\modules\matches\models\Match $model */

use app\components\controllers\ControllerBase;
use app\models\Setting;
use yii\widgets\DetailView;

$this->params['breadcrumbs'][] = [
    'label' => $this->context->controllerDescription,
    'url' => [$this->context->id . '/index']
];

$this->params['breadcrumbs'][] = $this->context->actionDescription;
?>

<div class="form-actions">
    <?= $this->render('@app/views/partials/crud/view-default-buttons') ?>
</div>

<div class="row">
    <p class="pull-left" style="margin-right: 15px;">
        <?= $model->getStatusLabel() ?>
    </p>
    <p class="pull-left" style="margin-right: 15px">
        <i class="fa fa-calendar"></i> <?= $model->date ?>
    </p>
    <p class="pull-left" style="margin-right: 15px">
        <i class="fa fa-map-marker" aria-hidden="true"></i> <?= $model->place->name ?>
    </p>
</div>

<div class="row">
    <div class="alert alert-warning clearfix">
        <div class="col-md-offset-1 col-md-3" style="margin-top: 11px">
            <h3 class="text-right"><?= Setting::getSettingByAbbreviation('TEAM_NAME')->value ?></h3>

            <div class="text-right">
                <?php foreach ($model->dataSheet as $datasheet) : ?>
                    <?php if ($datasheet->goals == 0) continue; ?>

                    <p>
                        <?= $datasheet->player->name ?>

                        <?php for ($i = 0; $i < $datasheet->goals; $i++) : ?>
                            <i class="fa fa-futbol-o" style="background: #fff"></i>
                        <?php endfor; ?>
                    </p>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-md-1">
            <h3 class="thumbnail text-center"><?= $model->score_owner ?></h3>
        </div>

        <div class="col-md-1" style="margin-top: 11px">
            <h3 class="text-center">VS</h3>
        </div>

        <div class="col-md-1">
            <h3 class="thumbnail text-center"><?= $model->score_guest ?></h3>
        </div>

        <div class="col-md-3" style="margin-top: 11px">
            <h3><?= $model->team->name ?></h3>
        </div>
    </div>

    <?php if (!is_null($model->observations)) : ?>
        <div class="row">
            <h3>Observações do Jogo</h3>
            <p><?= $model->observations ?></p>
        </div>
    <?php endif; ?>
</div>