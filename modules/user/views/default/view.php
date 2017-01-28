<?php
/* @var $this yii\web\View */
/* @var $model \backend\modules\user\models\User */

use common\components\ControllerBase;
use yii\widgets\DetailView;

$this->params['breadcrumbs'][] = [
    'label' => $this->context->controllerDescription,
    'url' => [$this->context->id . '/index']
];

$this->params['breadcrumbs'][] = $this->context->actionDescription;
?>

<div class="box form-actions">
    <div class="box-body">
        <?= $this->render('@backend/views/partials/crud/view-default-buttons') ?>
    </div>
</div>

<div class="box box-primary">

    <div class="box-body">

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'email:email',
                'group.name:text:'. $model->getAttributeLabel('group_id'),
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => ControllerBase::getYesNoLabel($model->status),
                ],
                'created_at',
                'updated_at',
                'createdBy.name:text:' . $model->getAttributeLabel('created_by'),
            ],
        ]) ?>

    </div>

</div>