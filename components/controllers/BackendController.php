<?php

namespace app\components\controllers;

use Exception;
use RuntimeException;
use Yii;
use app\components\Utils;
use app\components\ModelBase;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\web\NotFoundHttpException;

abstract class BackendController extends ControllerBase
{
    /**
     * @var string
     */
    public $modelClass;

    /**
     * @var string
     */
    public $modelSearchClass;

    /**
     * @var ModelBase
     */
    protected $model;

    /**
     * @var ModelBase
     */
    protected $modelSearch;

    /**
     * @var string string
     */
    public $layout = '@app/views/layouts/main';

    /**
     * Atributo que armazena o caminha para a view padrao para a acao create
     * @var string
     */
    protected $createViewFile = '@app/views/partials/crud/default-create';

    /**
     * Scenario para a acao create
     * @var string
     */
    protected $createScenario = 'default';

    /**
     * Atributo que armazena o caminha para a view padrao para a acao update
     * @var string
     */
    protected $updateViewFile = '@app/views/partials/crud/default-update';

    /**
     * Scenario para a acao update
     * @var string
     */
    protected $updateScenario = 'default';

    /**
     * Atributo que guarda a descricao padrao para action index
     * @var string
     */
    protected $indexActionDescription = 'Listagem de Dados';

    /**
     * Atributo que guarda a descricao padrao para action view
     * @var string
     */
    protected $viewActionDescription = 'Visualizar Detalhes';

    /**
     * Atributo que guarda a descricao padrao para action create
     * @var string
     */
    protected $createActionDescription = 'Novo Registro';

    /**
     * Atributo que guarda a descricao padrao para action update
     * @var string
     */
    protected $updateActionDescription = 'Atualizando Registro';

    /**
     * @var string Nome do atributo para caso a action precise fazer
     * upload de arquivos
     */
    protected $uploadField;

    public function init()
    {
        if (!Utils::IsNullOrEmpty($this->modelClass))
            $this->model = new $this->modelClass;

        if (!Utils::IsNullOrEmpty($this->modelSearchClass))
            $this->modelSearch = new $this->modelSearchClass;

        parent::init();
    }

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
                        'actions' => ['login', 'logout', 'forgot', 'renew-password', 'matches/default/view'],
                        'roles' => ['?']
                    ]
                ]
            ],
        ]);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->actionDescription = $this->indexActionDescription;

        $dataProvider = $this->modelSearch->search($this->getRequest()->queryParams);

        return $this->render('index', [
            'searchModel' => $this->modelSearch,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->actionDescription = $this->viewActionDescription;

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->actionDescription = $this->createActionDescription;
        $this->model->scenario = $this->createScenario;

        if ($this->model->load($this->getRequest()->post())) {

            if ($this->model->validate())
                return $this->saveFormData();

        }

        return $this->render($this->createViewFile, [
            'model' => $this->model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->actionDescription = $this->updateActionDescription;
        $this->model = $this->findModel($id);
        $this->model->scenario = $this->updateScenario;

        if ($this->model->load($this->getRequest()->post())) {

            if ($this->model->validate())
                return $this->saveFormData();

        }

        return $this->render($this->updateViewFile, [
            'model' => $this->model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        /** @var ModelBase $model */
        $model = $this->findModel($id);
        $model->deleted = Yii::$app->params['active'];
        $model->save(true, ['deleted']);

        $this->getSession()->setFlash('growl', [
            'type' => 'success',
            'title' => 'Tudo certo!',
            'message' => 'O registro foi removido com sucesso!'
        ]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ModelBase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = $this->model->findOne($id)) !== null)
            return $model;
        else
            throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Metodo que faz o processo de cadastro ou atualizacao de dados
     * @return \yii\web\Response
     */
    protected function saveFormData()
    {
        try {

            if (!$this->model->save() || $this->model->hasErrors())
                throw new Exception('Houve um erro ao salvar o registro.' . $this->model->getErrorsToString());

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
            return $this->redirect([$this->action->id]);
        }
    }

    /**
     * Metodo que retorna o Objeto do usuario atualmente logado
     * @return IdentityInterface
     * @throws Exception
     */
    public function getUserIdentity()
    {
        if($this->getUser()->isGuest)
            throw new RuntimeException('Não foi possível pegar informações do Usuário. Usuário não autenticado.');

        return $this->getUser()->getIdentity();
    }

    /**
     * @return ModelBase
     */
    public function getModel(): ModelBase
    {
        return $this->model;
    }

    /**
     * @return ModelBase
     */
    public function getModelSearch(): ModelBase
    {
        return $this->modelSearch;
    }
}