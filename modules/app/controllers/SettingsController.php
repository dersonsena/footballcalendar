<?php

namespace app\modules\app\controllers;

use app\components\controllers\BackendController;
use app\models\Setting;

class SettingsController extends BackendController
{
    public $controllerDescription = 'Configurações';

    public function actionIndex()
    {
        $this->controllerDescription = 'Configurações do Sistema';

        if ($this->getRequest()->isPost) {

            $post = $this->getPost('Setting')['value'];

            foreach ($post as $id => $value) {
                $row = Setting::findOne($id);
                $row->changeSetting($value);
            }

            $this->getSession()->setFlash('growl', [
                'type' => 'success',
                'title' => 'Tudo certo!',
                'message' => 'As configurações do sistema foram salvas com sucesso!'
            ]);

            return $this->refresh();
        }

        return $this->render('index', [
            'settings' => Setting::getSettingsRows()
        ]);
    }
}
