<?php

declare(strict_types = 1);
namespace api\modules\v1;

use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\RateLimiter;
use yii\web\Response;
use api\modules\v1\models\ApiUserIdentity;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\v1\controllers';

    public function init(): void
    {
        parent::init();

        Yii::$app->user->identityClass = ApiUserIdentity::class;
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;
    }

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
                'application/xml' => Response::FORMAT_XML,
            ],
        ];

        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::class,
        ];

        return $behaviors;
    }
}
