<?php

namespace app\modules\matches\assets;

use yii\web\AssetBundle;

class MatchesFormAsset extends AssetBundle
{
    public $sourcePath = '@matches/media';

    public $js = [
        'js/matches-form.js'
    ];

    public $depends = [
        'app\assets\AppAsset'
    ];
}