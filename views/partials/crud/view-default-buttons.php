<?php
/** @var \yii\web\View $this */
/** @var \yii\web\User $user */

use yii\helpers\Html;

$user = Yii::$app->user;
?>

<div class="btn-group pull-left">
    <?= Html::a('<i class="fa fa-plus-circle"></i> Novo Registro',[$this->context->id . '/create'], [
        'class'=>'btn btn-primary',
        'title' => 'Clique aqui para inserir um novo registro',
    ]) ?>

    <?= Html::a('<i class="glyphicon glyphicon-pencil"></i> Editar Registro',[$this->context->id . '/update', 'id'=>Yii::$app->getRequest()->getQueryParam('id')], [
        'class'=>'btn btn-default',
        'title' => 'Clique aqui para atualizar este registro'
    ]) ?>

    <?= Html::a('<i class="glyphicon glyphicon-trash"></i> Excluir Registro',[$this->context->id . '/delete', 'id'=>Yii::$app->getRequest()->getQueryParam('id')], [
        'class'=>'btn btn-danger',
        'title' => 'Clique aqui para excluir esse registro',
        'data-confirm' => 'Deseja realmente remover este registro?',
        'data-method' => 'post',
        'data-pjax' => '0',
    ]) ?>
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