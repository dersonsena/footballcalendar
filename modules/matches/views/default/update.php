<?php
/* @var yii\web\View $this */
/* @var \app\components\ModelBase $model */
/* @var \app\modules\entries\models\Player[] $players  */

$this->params['breadcrumbs'][] = [
    'label' => $this->context->controllerDescription,
    'url' => [$this->context->id . '/index']
];

$this->params['breadcrumbs'][] = $this->context->actionDescription;
?>

<div class="user-create">
    <?= $this->render("@{$this->context->module->id}/views/{$this->context->id}/_form", [
        'model' => $model,
        'players' => $players
    ]) ?>
</div>