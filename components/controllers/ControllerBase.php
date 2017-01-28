<?php

namespace app\components\controllers;

use Yii;
use app\components\Formatter;
use OutOfBoundsException;
use yii\helpers\Url;
use yii\web\Controller;

abstract class ControllerBase extends Controller
{
    public $layout = '/main';

    /**
     * @var string
     */
    public $controllerDescription;

    /**
     * @var string
     */
    public $actionDescription;

    public function init()
    {
        parent::init();
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Metodo que retorna o object Request
     * @return \yii\console\Request|\yii\web\Request
     */
    public function getRequest()
    {
        return Yii::$app->getRequest();
    }

    /**
     * Metodo que retora a instancia da sessao
     * @return \yii\web\Session
     */
    public function getSession()
    {
        return Yii::$app->getSession();
    }

    /**
     * Metodo que retorna a instancia do usuario logado ou nao da aplicacao
     * @return \yii\web\User
     */
    public function getUser()
    {
        return Yii::$app->getUser();
    }

    /**
     * Metodo que captura o post
     * @param string $name
     * @param string $defaultValue
     * @return array|mixed
     */
    public function getPost($name=null, $defaultValue=null)
    {
        return $this->getRequest()->post($name, $defaultValue);
    }

    /**
     * Metodo que retorna a URL base da Aplicacao
     * @param string $url Caso seja necessario concatenar uma URL com
     * o baseUrl, base informar este parametro
     * @return string
     */
    public function getBaseUrl($url=null)
    {
        if(is_null($url))
            return Url::base(true);

        return Url::base(true) . '/' . $url;
    }

    /**
     * Metodo que retorna o formatter para utilizacao nos controllers
     * @return Formatter
     */
    public function getFormatter()
    {
        return Yii::$app->formatter;
    }

    /**
     * Metodo que retorna uma lista de status ou um status especifico
     * @param int $status
     * @return array|int
     */
    public static function getStatus($status=null)
    {
        $list = [
            Yii::$app->params['active'] => 'Ativo',
            Yii::$app->params['inactive'] => 'Inativo'
        ];

        if(!is_null($status) && !isset($list[$status]))
            throw new OutOfBoundsException("Não foi encontrado código do status '{$status}'.");

        return (is_null($status) ? $list : $list[$status]);
    }

    /**
     * Metodo que retorna uma lista de status do tipo SIM/NAO
     * @param int $status
     * @return array|int
     */
    public static function getYesNo($status=null)
    {
        $list = [
            Yii::$app->params['active'] => 'Sim',
            Yii::$app->params['inactive'] => 'Não'
        ];

        if(!is_null($status) && !isset($list[$status]))
            throw new OutOfBoundsException("Não foi encontrado código do status '{$status}'.");

        return (is_null($status) ? $list : $list[$status]);
    }

    /**
     * Metodo que poe um icone do de um status do registro para grid
     * @param integer $status Status do registro
     * @return string HTML com a classe dependendo do status enviado
     */
    public static function getYesNoLabel($status)
    {
        $list = self::getStatus();

        if(!isset($list[$status]))
            throw new OutOfBoundsException("Não foi encontrado código do status '{$status}'.");

        if($status == Yii::$app->params['active']) {

            $params = [
                'cssClass' => 'label-success',
                'label' => 'Sim',
                'iconClass'=>'fa fa-check-circle'
            ];

        } else {

            $params = [
                'cssClass' => 'label-danger',
                'label' => 'Não',
                'iconClass'=>'glyphicon glyphicon-minus-sign'
            ];

        }

        return '<span class="label '. $params['cssClass'] .'">
            <i class="'. $params['iconClass'] .'"></i> '. $params['label'] .
        '</span>';
    }
}