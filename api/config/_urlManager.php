<?php

use yii\rest\UrlRule;
use yii\web\UrlManager;

return [
    'class' => UrlManager::class,
    'rules' => [
        [
            'class' => UrlRule::class,
            'controller' => ['v1/notes'],
            'pluralize' => false
        ],
    ],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
];
