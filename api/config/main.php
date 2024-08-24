<?php

use api\modules\v1\Module;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
);

$config = [
    'id' => 'frontend',
    'basePath' => dirname(__DIR__),
    'name' => 'Yii-notes',
    'homeUrl' => $params['API_HOST'],
    'controllerNamespace' => 'api\controllers',
    'defaultRoute' => 'site/index',
    'components' => [
        'urlManager' => require(__DIR__ . '/_urlManager.php'),
        'cache' => require(__DIR__ . '/_cache.php'),
        'errorHandler' => [
            'errorAction' => 'site/error'
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
    ],
    'params' => $params,
];

return $config;
