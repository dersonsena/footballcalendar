<?php

namespace app\controllers;

use app\components\controllers\ControllerBase;
use app\modules\user\forms\LoginForm;
use Yii;

class SiteController extends ControllerBase
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
            return $this->goHome();

        $model = new LoginForm;

        if ($model->load(Yii::$app->request->post()) && $model->login())
            return $this->goBack();

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
