<?php

namespace app\modules\user\controllers;

use app\components\controllers\BackendController;
use app\modules\user\filters\GroupProtectedFilter;
use app\modules\user\models\Group;
use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\rbac\Role;
use yii\web\ForbiddenHttpException;

class GroupsController extends BackendController
{
    public $modelClass = 'backend\modules\user\models\Group';
    public $modelSearchClass = 'backend\modules\user\models\search\GroupSearch';
    public $controllerDescription = 'Grupos de Usuário';

    public function behaviors()
    {
        return ArrayHelper::merge([
            'groupProtected' => [
                'class' => GroupProtectedFilter::className(),
                'only' => ['update', 'delete'],
            ]
        ], parent::behaviors());
    }

    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $this->actionDescription = $this->createActionDescription;

        /** @var Group $model */
        $model = $this->model = $this->getModel();
        $model->scenario = $this->createScenario;

        if ($model->load($this->getRequest()->post()) && $model->validate())
            return $this->saveFormData();

        return $this->render('create', [
            'model' => $this->getModel(),
            'permissions' => Group::getAllPermissions()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionUpdate($id)
    {
        $this->actionDescription = $this->updateActionDescription;

        /** @var Group $model */
        $model = $this->model = $this->findModel($id);
        $model->scenario = $this->updateScenario;

        if ($model->load($this->getRequest()->post()) && $model->validate())
            return $this->saveFormData();

        return $this->render('update', [
            'model' => $model,
            'permissions' => Group::getAllPermissions()
        ]);
    }

    public function saveFormData()
    {
        try {

            /** @var Group $model */
            /** @var Role $role */
            $model = $this->model;
            $role = null;
            $authManager = Yii::$app->authManager;

            if (!$model->save())
                throw new Exception('Houve um erro ao salvar o registro: ' . $model->getErrorsToString());

            if (is_null($model->getRole())) {
                $role = $authManager->createRole($model->getRoleName());
                $role->description = $model->name;
                $authManager->add($role);
            } else {
                $role = $model->getRole();
                $role->description = $model->name;
                $authManager->update($model->getRoleName(), $role);
            }

            $authManager->removeChildren($role);
            $permissions = $this->getPost('permissions');

            if (!empty($permissions)) {
                foreach ($permissions as $name)
                    $authManager->addChild($role, $authManager->getPermission($name));
            }

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
            $this->getSession()->setFlash('error', '<strong style="font-size: 1.5em">Opsss... Um erro aconteceu!</strong>' . $e->getMessage());

            if (is_null($model->id))
                return $this->redirect([$this->action->id]);

            return $this->redirect([$this->action->id, 'id' => $model->id]);
        }
    }

    public function actionDelete($id)
    {
        /** @var Group $model */
        $model = $this->findModel($id);

        if (!$model->canDelete())
            throw new ForbiddenHttpException("Você não tem permissão de acessar esta página.");

        $model->deleted = Yii::$app->params['active'];
        $model->save();

        Yii::$app->authManager->remove($model->getRole());

        $this->getSession()->setFlash('success', '<strong style="font-size: 1.5em">Sucesso!</strong> O registro foi removido com sucesso!');
        return $this->redirect(['index']);
    }
}