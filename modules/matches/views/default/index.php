<?php
/* @var yii\web\View $this  */
/* @var \app\modules\matches\models\search\MatchSearch $searchModel  */
/* @var $dataProvider yii\data\ActiveDataProvider */

use app\components\controllers\ControllerBase;
use app\models\Flag;
use app\modules\matches\models\Match;
use app\widgets\IndexButtons;
use yii\grid\DataColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->params['breadcrumbs'][] = $this->context->controllerDescription;
?>

<section class="well well-sm">
    <?= IndexButtons::widget() ?>
</section>

<?php Pjax::begin() ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'date',
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['style' => 'width: 120px', 'class' => 'text-center'],
        ],
        [
            'attribute' => 'description',
            'class' => 'app\components\LinkDataColumn',
        ],
        [
            'attribute' => 'type_id',
            'headerOptions' => ['class' => 'text-center', 'style' => 'width: 130px'],
            'contentOptions' => ['class' => 'text-center'],
            'filter' => Match::getDecisionList(),
            'value' => 'type.description'
        ],
        [
            'attribute' => 'status_id',
            'headerOptions' => ['class' => 'text-center', 'style' => 'width: 105px'],
            'contentOptions' => ['class' => 'text-center'],
            'format' => 'raw',
            'filter' => Match::getStatusList(),
            'value' => function(Match $model, $key, $index, DataColumn $dataColumn) {
                return $model->getStatusLabel();
            }
        ],
        [
            'attribute' => 'decision_id',
            'headerOptions' => ['class' => 'text-center', 'style' => 'width: 95px'],
            'contentOptions' => ['class' => 'text-center'],
            'format' => 'raw',
            'filter' => Match::getDecisionList(),
            'value' => function(Match $model, $key, $index, DataColumn $dataColumn) {

                if (empty($model->decision_id))
                    return '';

                return $model->getDecisionLabel();
            }
        ],
        ['class' => 'app\components\ActionGridColumn'],
    ],
]) ?>
<?php Pjax::end() ?>