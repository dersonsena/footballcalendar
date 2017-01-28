<?php
/* @var $this yii\web\View */
/* @var $searchModel \backend\modules\user\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\components\ControllerBase;
use backend\modules\user\models\Group;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->params['breadcrumbs'][] = $this->context->controllerDescription;
?>
<div class="box box-primary">

    <div class="box-body">

        <section class="well well-sm">
            <?= $this->render('@backend/views/partials/crud/index-default-actions') ?>
        </section>
        
        <?php Pjax::begin() ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'id',
                    'headerOptions' => ['class' => 'text-right', 'style' => 'width: 50px'],
                    'contentOptions' => ['class' => 'text-right'],
                ],
                [
                    'attribute' => 'name',
                    'class' => 'backend\components\LinkDataColumn',
                ],
                [
                    'attribute' => 'email',
                    'format' => 'email',
                    'headerOptions' => ['style' => 'width: 250px'],
                ],
                [
                    'attribute' => 'group_id',
                    'filter' => (new Group)->getDropdownOptions('name'),
                    'headerOptions' => ['style' => 'width: 150px'],
                    'value' => 'group.name'
                ],
                [
                    'attribute' => 'status',
                    'class' => 'backend\components\YesNoDataColumn',
                    'filter' => ControllerBase::getYesNo()
                ],
                ['class' => 'backend\components\ActionGridColumn'],
            ],
        ]) ?>
        <?php Pjax::end() ?>

    </div>

</div>