<?php

namespace app\modules\user\filters;

use app\modules\user\models\Group;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

class GroupProtectedFilter extends ActionFilter
{
    public function afterAction($action, $result)
    {
        /** @var Group $group */
        $group = $action->controller->getModel();

        if ($group->isSystemGroup())
            throw new ForbiddenHttpException('Você não tem permissão de acessar esta página.');

        return parent::afterAction($action, $result);
    }
}