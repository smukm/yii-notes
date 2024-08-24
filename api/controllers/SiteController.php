<?php declare(strict_types=1);

namespace api\controllers;

use HttpException;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SiteController extends Controller
{

    public function actionIndex(): string
    {
        return 'api';
    }

    public function actionError(): Response
    {
        $exception = Yii::$app->errorHandler->exception;

        if ($exception === null) {
            $exception = new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        if ($exception instanceof HttpException) {
            $this->response->setStatusCode($exception->getCode());
        } else {
            $this->response->setStatusCode(500);
        }

        return $this->asJson([
            'error' => $exception->getMessage(),
            'code' => $exception->getCode()]
        );
    }
}
