<?php
/** @var $session \yii\web\Session */
use kartik\growl\Growl;
use yii\helpers\Html;

$session = Yii::$app->session;

if($session->hasFlash('growl')) {

    $message = $session->getFlash('growl');
    $icon = 'fa fa-check-circle';

    if (!isset($message['icon']) || empty($message['icon'])) {
        switch ($message['type']) {
            case 'success' : $icon = 'glyphicon glyphicon-ok-sign'; break;
            case 'warning' : $icon = 'glyphicon glyphicon-exclamation-sign'; break;
            case 'error' : $icon = 'glyphicon glyphicon-remove-sign'; break;
            default : $icon = 'glyphicon glyphicon-info-sign'; break;
        }
    }

    Growl::widget([
        'type' => (!empty($message['type'])) ? $message['type'] : 'info',
        'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
        'icon' => $icon,
        'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
        'showSeparator' => true,
        'delay' => 0,
        'pluginOptions' => [
            'timer' => (isset($message['timer']) && !empty($message['timer']) ? $message['timer'] : 1600),
            'showProgressbar' => true,
            'delay' => (!empty($message['duration'])) ? $message['duration'] : 3500,
            'placement' => [
                'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
            ]
        ]
    ]);
}