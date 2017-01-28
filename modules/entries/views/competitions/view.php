<?php
/* @var $this yii\web\View */
/* @var \app\modules\entries\models\Competition $model */

use app\components\controllers\ControllerBase;
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

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'responsible',
        [
            'attribute' => 'responsible_phone',
            'format' => 'phoneDDD'
        ],
        [
            'attribute' => 'responsible_whatsapp',
            'format' => 'phoneDDD'
        ],
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