<?php

namespace app\controllers;

use app\components\controllers\ControllerBase;
use app\modules\matches\models\Match;
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
        $this->controllerDescription = 'Estatísticas';
        $selectedYear = $this->getRequest()->get('year', date('Y'));

        return $this->render('index', [
            'artillery' => Match::getArtillery($selectedYear),
            'goalsBalance' => Match::getGoalsBalance($selectedYear),
            'lastMatches' => Match::getLastMatches($selectedYear),
            'years' => Match::getYearsGrouped(),
            'selectedYear' => $selectedYear
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm;

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

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
