<?php
/* @var $this yii\web\View */
/* @var $model \app\common\components\ModelBase */

$this->params['breadcrumbs'][] = [
    'label' => $this->context->controllerDescription,
    'url' => [$this->context->id . '/index']
];

$this->params['breadcrumbs'][] = $this->context->actionDescription;
?>

<div class="user-create">
    <?= $this->render("@{$this->context->module->id}/views/{$this->context->id}/_form", [
        'model' => $model,
    ]) ?>
</div>