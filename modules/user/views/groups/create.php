<?php
/* @var $this yii\web\View */
/* @var $model \backend\modules\user\models\Group */
/* @var array $permissions */

$this->params['breadcrumbs'][] = [
    'label' => $this->context->controllerDescription,
    'url' => [$this->context->id . '/index']
];

$this->params['breadcrumbs'][] = $this->context->actionDescription;
?>

<div class="user-create">
    <?= $this->render("_form", [
        'model' => $model,
        'permissions' => $permissions,
    ]) ?>
</div>