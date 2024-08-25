<?php

$config = yii\helpers\ArrayHelper::merge(
    require dirname(dirname(__DIR__)) . '/../common/config/codeception-local.php',
    require __DIR__ . '/../../../frontend/config/main.php',
    require __DIR__ . '/../../../frontend/config/main-local.php',
    require __DIR__ . '/../../../frontend/config/test.php',
    require __DIR__ . '/../../../frontend/config/test-local.php',
    [
        'components' => [
            'user' => [
                'identityClass' => \modules\notes\tests\support\DummyUser::class,
                'loginUrl' => ['site/login'],
                'enableAutoLogin' => true,
                'enableSession' => true,
            ],
        ]
    ]
);


return $config;