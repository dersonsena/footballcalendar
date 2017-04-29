<?php

namespace app\modules\matches\controllers;

use app\components\controllers\BackendController;
use app\models\Flag;
use app\modules\entries\models\Player;
use app\modules\matches\models\Match;
use app\modules\matches\models\MatchDatasheet;
use DateTime;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class DefaultController extends BackendController
{
    public $modelClass = 'app\modules\matches\models\Match';
    public $modelSearchClass = 'app\modules\matches\models\search\MatchSearch';
    public $controllerDescription = 'Jogos';
    private $players = [];

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['?']
                    ]
                ]
            ],
        ]);
    }

    public function init()
    {
        parent::init();

        if ($this->model->isNewRecord) {
            $this->model->date = (new DateTime())->format('d/m/Y');
            $this->model->type_id = Flag::MATCH_TYPE_FRIENDLY;
        }

        $this->players = Player::find()
            ->where(['status' => Yii::$app->params['active']])
            ->orderBy('name ASC')
            ->all();
    }

    public function actionCreate()
    {
        $this->actionDescription = $this->createActionDescription;
        $this->model->scenario = $this->createScenario;

        if ($this->model->load($this->getRequest()->post())) {

            if ($this->model->validate())
                return $this->saveFormData();

        }

        return $this->render('create', [
            'model' => $this->model,
            'players' => $this->players
        ]);
    }

    public function actionUpdate($id)
    {
        $this->actionDescription = $this->updateActionDescription;
        $this->model = $this->findModel($id);
        $this->model->scenario = $this->updateScenario;

        if ($this->model->load($this->getRequest()->post())) {

            if ($this->model->validate())
                return $this->saveFormData();

        }

        return $this->render('update', [
            'model' => $this->model,
            'players' => $this->players
        ]);
    }

    public function actionDelete($id)
    {
        /** @var Match $model */
        $model = $this->findModel($id);
        $model->delete();

        $this->getSession()->setFlash('growl', [
            'type' => 'success',
            'title' => 'Tudo certo!',
            'message' => 'O registro foi removido com sucesso!'
        ]);

        return $this->redirect(['index']);
    }

    protected function saveFormData()
    {
        $transaction = Yii::$app->getDb()->beginTransaction();

        try {

            /** @var Match $model */
            $model = $this->model;

            if (!$model->save() || $model->hasErrors())
                throw new Exception('Houve um erro ao salvar o registro.' . $model->getErrorsToString());

            $model->registerDataSheet($this->getDataSheetCollection());

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

    /**
     * @return MatchDatasheet[]
     */
    private function getDataSheetCollection()
    {
        $post = $this->getPost('MatchDatasheet');
        $total = count($post['player_id']);
        $collection = [];

        for ($i = 0; $i < $total; $i++) {
            $row = new MatchDatasheet;
            $row->player_id = $post['player_id'][$i];
            $row->goals = $post['goals'][$i];
            $row->assists = $post['assists'][$i];

            $collection[] = $row;
        }

        return $collection;
    }
}
