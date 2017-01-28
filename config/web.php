<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'name' => 'Futsal Calendar',
    'language' => 'pt-BR',
    'timeZone' => 'America/Fortaleza',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@entries' => '@app/modules/entries',
        '@user' => '@app/modules/users',
        '@appModule' => '@app/modules/app',
    ],
    'modules' => [
        'user' => [
            'class' => 'app\modules\user\UserModule',
        ],
        'entries' => [
            'class' => 'app\modules\entries\EntriesModule',
        ],
        'app' => [
            'class' => 'app\modules\app\AppModule',
        ],
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'n9sw_66pjMSALcz6uvgp2nEiBM18upwc',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
        ],
        'session' => [
            'savePath' => '@runtime/session'
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
        'formatter' => [
            'class' => 'app\components\Formatter',
            'nullDisplay' => '-',
            'defaultTimeZone' => 'America/Fortaleza',
            'dateFormat' => 'dd/MM/yyyy',
            'datetimeFormat' => 'dd/MM/yyyy HH:mm:ss',
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'numberFormatterOptions' => [
                NumberFormatter::MIN_FRACTION_DIGITS => 2,
                NumberFormatter::MAX_FRACTION_DIGITS => 2,
            ]
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*']
    ];
}

return $config;