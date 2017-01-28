<?php

namespace app\modules\user\assets;

use yii\web\AssetBundle;

class GroupsFormAsset extends AssetBundle
{
    public $sourcePath = '@user/media';

    public $js = [
        'js/groups-form.js'
    ];

    public $depends = [
        'backend\assets\AppAsset'
    ];
}