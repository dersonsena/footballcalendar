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
            'headerOptions' => ['style' => 'width: 150px', 'class' => 'text-center'],
        ],
        [
            'attribute' => 'description',
            'class' => 'app\components\LinkDataColumn',
        ],
        [
            'attribute' => 'type_id',
            'headerOptions' => ['class' => 'text-center', 'style' => 'width: 130px'],
            'contentOptions' => ['class' => 'text-center'],
            'filter' => Flag::getFlagsDownDownOptions('MATCH_TYPE'),
            'value' => 'type.description'
        ],
        [
            'attribute' => 'status_id',
            'headerOptions' => ['class' => 'text-center', 'style' => 'width: 130px'],
            'contentOptions' => ['class' => 'text-center'],
            'filter' => Flag::getFlagsDownDownOptions('MATCH_STATUS'),
            'value' => 'status.description'
        ],
        [
            'attribute' => 'decision_id',
            'headerOptions' => ['class' => 'text-center', 'style' => 'width: 130px'],
            'contentOptions' => ['class' => 'text-center'],
            'filter' => Flag::getFlagsDownDownOptions('MATCH_DECISION'),
            'value' => 'decision.description'
        ],
        ['class' => 'app\components\ActionGridColumn'],
    ],
]) ?>
<?php Pjax::end() ?>