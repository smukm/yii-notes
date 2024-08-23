<?php

use modules\notes\NotesModule;
use yii\authclient\clients\VKontakte;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'name' => 'Yii-notes',
    'language' => 'ru-RU',
    'bootstrap' => ['log', 'notes'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['pattern' => '/', 'route' => 'notes/note/index']
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'vkontakte' => [
                    'class' => VKontakte::class,
                    'clientId' => 'xxx',
                    'clientSecret' => 'xxx',
                    'scope' => 'email',
                ],
            ],
        ],
    ],
    'modules' => [
        'notes' => [
            'class' => NotesModule::class,
            'controllerNamespace' => 'modules\notes\controllers',
            'viewPath' => '@modules/notes/views',
        ]
    ],
    'params' => $params,
];
