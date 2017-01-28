<?php

namespace app\modules\entries\controllers;

use app\components\controllers\BackendController;

class CompetitionsController extends BackendController
{
    public $modelClass = 'app\modules\entries\models\Competition';
    public $modelSearchClass = 'app\modules\entries\models\search\CompetitionSearch';
    public $controllerDescription = 'Competições';
}
