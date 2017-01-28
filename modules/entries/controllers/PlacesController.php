<?php

namespace app\modules\entries\controllers;

use app\components\controllers\BackendController;

class PlacesController extends BackendController
{
    public $modelClass = 'app\modules\entries\models\Place';
    public $modelSearchClass = 'app\modules\entries\models\search\PlaceSearch';
    public $controllerDescription = 'Ginásios/Locais de Jogo';
}
