<?php

namespace app\modules\entries\controllers;

use app\components\controllers\BackendController;

class PlayersController extends BackendController
{
    public $modelClass = 'app\modules\entries\models\Player';
    public $modelSearchClass = 'app\modules\entries\models\search\PlayerSearch';
    public $controllerDescription = 'Atletas';
}
