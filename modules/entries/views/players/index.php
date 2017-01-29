<?php
/* @var yii\web\View $this  */
/* @var \app\modules\entries\models\search\PlayerSearch $searchModel  */
/* @var $dataProvider yii\data\ActiveDataProvider */

use app\components\controllers\ControllerBase;
use app\widgets\IndexButtons;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->params['breadcrumbs'][] = $this->context->controllerDescription;
?>
<div class="box box-primary">

    <div class="box-body">

        <section class="well well-sm">
            <?= IndexButtons::widget() ?>
        </section>
        
        <?php Pjax::begin() ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'name',
                    'class' => 'app\components\LinkDataColumn',
                ],
                [
                    'attribute' => 'status',
                    'class' => 'app\components\YesNoDataColumn',
                    'filter' => ControllerBase::getYesNo()
                ],
                ['class' => 'app\components\ActionGridColumn'],
            ],
        ]) ?>
        <?php Pjax::end() ?>

    </div>

</div>