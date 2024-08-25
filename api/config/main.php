<?php

use api\modules\v1\Module;
use modules\notes\NotesModule;
use yii\log\FileTarget;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
);

$config = [
    'id' => 'frontend',
    'basePath' => dirname(__DIR__),
    'name' => 'Yii-notes',
    'bootstrap' => ['log', 'notes'],
    'homeUrl' => $params['API_HOST'],
    'controllerNamespace' => 'api\controllers',
    'defaultRoute' => 'site/index',
    'components' => [
        'urlManager' => require(__DIR__ . '/_urlManager.php'),
        'cache' => require(__DIR__ . '/_cache.php'),
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'request' => [
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'class' => yii\web\User::class,
            'identityClass' => common\models\User::class,
            'loginUrl' => ['/user/sign-in/login'],
        ],
    ],
    'modules' => [
        'v1' => Module::class,
        'notes' => [
            'class' => NotesModule::class,
        ]
    ],
    'params' => $params,
];

return $config;
