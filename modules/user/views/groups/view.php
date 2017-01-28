<?php
/* @var $this yii\web\View */
/* @var $model \backend\modules\user\models\Group */
/* @var $dataProvider \backend\modules\user\models\search\GroupSearch */

use common\components\ControllerBase;
use yii\bootstrap\Html;
use yii\widgets\DetailView;

$this->params['breadcrumbs'][] = [
    'label' => $this->context->controllerDescription,
    'url' => [$this->context->id . '/index']
];

$this->params['breadcrumbs'][] = $this->context->actionDescription;
?>

<div class="box form-actions">
    <div class="box-body">
        <div class="btn-group pull-left">
            <?= Html::a('<i class="fa fa-plus-circle"></i> Novo Registro',[$this->context->id . '/create'], [
                'class'=>'btn btn-primary',
                'title' => 'Clique aqui inserir um novo registro'
            ]) ?>

            <?php if (!$model->isSystemGroup()) : ?>
                <?= Html::a('<i class="glyphicon glyphicon-pencil"></i> Editar Registro',[$this->context->id . '/update', 'id'=>Yii::$app->getRequest()->getQueryParam('id')], [
                    'class'=>'btn btn-default',
                    'title' => 'Clique aqui atualizar este registro'
                ]) ?>

                <?= Html::a('<i class="glyphicon glyphicon-trash"></i> Excluir Registro',[$this->context->id . '/delete', 'id'=>Yii::$app->getRequest()->getQueryParam('id')], [
                    'class'=>'btn btn-danger',
                    'title' => 'Clique aqui excluir esse registro',
                    'data-confirm' => 'Deseja realmente remover este registro?',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ]) ?>
            <?php endif; ?>
        </div>

        <div class="btn-group pull-right">

            <?= Html::a('<i class="glyphicon glyphicon-list-alt"></i> Listagem de Dados',[$this->context->id . '/index'], [
                'class'=>'btn btn-link',
                'title' => 'Voltar para a Listagem de dados desse módulo'
            ]) ?>

            <?= Html::a('<i class="glyphicon glyphicon-chevron-left"></i> Página Anterior', 'javascript:;', [
                'class'=>'btn btn-link',
                'title' => 'Voltar uma página do seu histórico de navegação',
                'onclick'=>'history.back(-1)'
            ]) ?>

        </div>
    </div>
</div>

<div class="box box-primary">

    <div class="box-header with-border">
        <h3 class="box-title">Informações do Grupo</h3>
    </div>

    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
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

<div class="box box-primary">

    <div class="box-header with-border">
        <h3 class="box-title">Permissões de Acesso do Grupo</h3>
    </div>

    <div class="box-body">
        <?php if (!empty($model->getPermissions())) : ?>
            <?php foreach ($model->getPermissions() as $name => $parentData) : ?>

                <div class="checkbox">
                    <span class="text-bold" style="font-size: 18px">
                        <?= Html::icon('chevron-right') ?>
                        <?= $parentData['description'] ?>
                    </span>
                </div>

                <div id="childs-<?= $name ?>" class="childs" style="margin: 0 0 20px 22px">
                    <?php foreach ($parentData['childs'] as $childName => $permission) : ?>
                        <div class="checkbox">
                            <?= $permission->description ?>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php endforeach; ?>
        <?php else : ?>

            <p class="text-center">
                Não existem permissões configuradas para este Grupo de Usuário.<br />

                <?php if (!$model->isSystemGroup()) : ?>
                    <?= Html::a('Clique aqui', ['update', 'id' => $model->id]) ?> para configurar as permissões!
                <?php endif; ?>
            </p>

        <?php endif; ?>
    </div>

</div>