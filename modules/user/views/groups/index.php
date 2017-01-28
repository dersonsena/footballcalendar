<?php
/* @var $this yii\web\View */
/* @var $searchModel \backend\modules\user\models\search\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\components\ControllerBase;
use backend\modules\user\models\Group;
use yii\grid\GridView;
use \yii\bootstrap\Html;
use yii\widgets\Pjax;

$this->params['breadcrumbs'][] = $this->context->controllerDescription;
?>
<div class="box box-primary">

    <div class="box-body">

        <section class="well well-sm">
            <?= $this->render('@backend/views/partials/crud/index-default-actions') ?>
        </section>

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
                    'attribute' => 'status',
                    'class' => 'backend\components\YesNoDataColumn',
                    'filter' => ControllerBase::getYesNo()
                ],
                [
                    'class' => 'backend\components\ActionGridColumn',
                    'buttons' => [
                        'update' => function ($url, Group $model, $key) {

                            if ($model->isSystemGroup())
                                return '';

                            return Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', $url, [
                                'title' => Yii::t('yii', 'Update'),
                                'aria-label' => Yii::t('yii', 'Update'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-default btn-sm'
                            ]);
                        },
                        'delete' => function ($url, Group $model, $key) {

                            if ($model->isSystemGroup() || !$model->canDelete())
                                return '';

                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('yii', 'Delete'),
                                'aria-label' => Yii::t('yii', 'Delete'),
                                'data-confirm' => 'Deseja realmente remover este registro?',
                                'data-method' => 'post',
                                'data-pjax' => '0',
                                'class' => 'btn btn-danger btn-sm'
                            ]);
                        }
                    ]
                ],
            ],
        ]) ?>

    </div>

</div>