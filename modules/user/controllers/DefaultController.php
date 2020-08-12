<?php

namespace app\modules\user\controllers;

use app\components\controllers\BackendController;
use app\modules\user\forms\ChangePasswordForm;
use app\modules\user\models\User;
use Exception;
use Yii;

class DefaultController extends BackendController
{
    public $modelClass = 'app\modules\user\models\User';
    public $modelSearchClass = 'app\modules\user\models\search\UserSearch';
    public $controllerDescription = 'Usuários';
    protected $createScenario = 'create';

    public function saveFormData()
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {

            /** @var User $model */
            $model = $this->model;

            if (!$model->save() || $model->hasErrors())
                throw new Exception('Houve um erro ao salvar o registro.');

            $model->saveUserStores();
            $model->addAuthAssign();
            $transaction->commit();

            $this->getSession()->setFlash('growl', [
                'type' => 'success',
                'title' => 'Tudo certo!',
                'message' => 'Seus dados foram gravados com sucesso!'
            ]);

            if (!is_null($this->getRequest()->post('save-and-continue'))) {
                return $this->refresh();
            } else {
                return $this->redirect(['index']);
            }

        } catch(Exception $e) {
            $transaction->rollBack();
            $this->getSession()->setFlash('error', '<strong style="font-size: 1.5em">Opsss... Um erro aconteceu!</strong>' . $e->getMessage());
            return $this->redirect([$this->action->id]);
        }
    }

    public function actionChangePassword()
    {
        $this->actionDescription = 'Alteração de Senha';

        /** @var User $user */
        $user = $this->getUserIdentity();
        $formModel = new ChangePasswordForm;

        if ($this->getRequest()->isPost && $formModel->load($this->getPost())) {

            try {
                $formModel->changePassword($user);

                $this->getSession()->setFlash('growl', [
                    'type' => 'success',
                    'title' => 'Tudo certo!',
                    'message' => 'Sua senha de acesso foi alterada com sucesso!'
                ]);

                return $this->redirect(['/app/default']);

            } catch(Exception $e) {
                $this->getSession()->setFlash('error', $e->getMessage());
                return $this->refresh();
            }

        }

        return $this->render('change-password', [
            'model' => $formModel
        ]);
    }
}
