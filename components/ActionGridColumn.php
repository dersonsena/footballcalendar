<?php

namespace app\components;

use Yii;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\User;

class ActionGridColumn extends ActionColumn
{
    /**
     * @inheritdoc
     */
    public $header = 'Ações';

    /**
     * @inheritdoc
     */
    public $headerOptions = ['style' => 'width: 215px', 'class'=>'text-center'];

    /**
     * @inheritdoc
     */
    public $contentOptions = ['class' => 'text-center'];

    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $partialResource;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->template = '<div class="btn-group" role="group">'. $this->template .'</div>';
        $this->user = Yii::$app->user;
        parent::init();
    }

    /**
     * @inheritdoc
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view']))
            $this->createViewButton();

        if (!isset($this->buttons['update']))
            $this->createUpdateButton();

        if (!isset($this->buttons['delete']))
            $this->createDeleteButton();
    }

    /**
     * Metodo que cria o botao view nas acoes, caso ele nao exista
     * @return string
     */
    private function createViewButton()
    {
        $this->buttons['view'] = function ($url, $model, $key) {

            $options = array_merge([
                'title' => 'Ver detalhes do registro',
                'aria-label' => Yii::t('yii', 'View'),
                'data-toggle' => 'tooltip',
                'data-pjax' => '0',
                'class' => 'btn btn-default btn-sm',
            ], $this->buttonOptions);

            return Html::a('<span class="glyphicon glyphicon-eye-open"></span> Ver', $url, $options);
        };
    }

    /**
     * Metodo que cria o botao update nas acoes, caso ele nao exista
     * @return string
     */
    private function createUpdateButton()
    {
        $this->buttons['update'] = function ($url, $model, $key) {

            $options = array_merge([
                'title' => Yii::t('yii', 'Update'),
                'aria-label' => Yii::t('yii', 'Update'),
                'data-toggle' => 'tooltip',
                'data-pjax' => '0',
                'class' => 'btn btn-default btn-sm'
            ], $this->buttonOptions);

            return Html::a('<span class="glyphicon glyphicon-pencil"></span> Editar', $url, $options);
        };
    }

    /**
     * Metodo que cria o botao delete nas acoes, caso ele nao exista
     * @return string
     */
    private function createDeleteButton()
    {
        $this->buttons['delete'] = function ($url, $model, $key) {

            $options = array_merge([
                'title' => Yii::t('yii', 'Delete'),
                'aria-label' => Yii::t('yii', 'Delete'),
                'data-confirm' => 'Deseja realmente remover este registro?',
                'data-toggle' => 'tooltip',
                'data-method' => 'post',
                'data-pjax' => '0',
                'class' => 'btn btn-danger btn-sm'
            ], $this->buttonOptions);

            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
        };
    }
}