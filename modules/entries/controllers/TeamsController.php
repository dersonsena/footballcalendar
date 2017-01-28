<?php

namespace app\modules\entries\controllers;

use app\components\controllers\BackendController;

class TeamsController extends BackendController
{
    public $modelClass = 'app\modules\entries\models\Team';
    public $modelSearchClass = 'app\modules\entries\models\search\TeamSearch';
    public $controllerDescription = 'Times';
}
