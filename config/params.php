<?php

use yii\bootstrap\Html;

return [
    'adminEmail' => 'admin@example.com',
    'inactive' => 0,
    'active' => 1,
    'contactName' => 'Studio Stilo',
    'contactEmail' => 'contato@studiostilo.com.br',
    'pagination' => [
        'pageSize' => 30
    ],
    'datepickerOptions' => [
        'options' => ['placeholder' => 'dd/mm/aaaa'],
        'removeButton' => false,
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'todayBtn' => true
        ]
    ],
    'defaultAddons' => [
        'money' => [
            'prepend' => ['content' => '<i class="fa fa-money" aria-hidden="true"></i>']
        ],
        'percent' => [
            'append' => ['content' => '%']
        ],
        'url' => [
            'prepend' => ['content' => 'http://']
        ],

        'email' => [
            'prepend' => ['content' => Html::icon('envelope')]
        ],
        'phone' => [
            'prepend' => ['content' => Html::icon('phone-alt')]
        ],
        'whatsapp' => [
            'prepend' => ['content' => '<i class="fa fa-whatsapp"></i>']
        ],
        'date' => [
            'prepend' => ['content' => Html::icon('calendar')]
        ],
        'time' => [
            'prepend' => ['content' => Html::icon('time')]
        ]
    ]
];
