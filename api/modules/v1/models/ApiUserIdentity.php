<?php

namespace api\modules\v1\models;

use common\models\User;
use Yii;
use yii\filters\RateLimitInterface;

class ApiUserIdentity extends User implements RateLimitInterface
{

    public int $rateWindowSize = 3600;

    public function getRateLimit($request, $action): array
    {
        return [5000, $this->rateWindowSize];
    }

    public function loadAllowance($request, $action): array
    {
        $allowance = Yii::$app->cache->get($this->getCacheKey('api_rate_allowance'));
        $timestamp = Yii::$app->cache->get($this->getCacheKey('api_rate_timestamp'));
        return [$allowance, $timestamp];
    }

    public function getCacheKey($key): array
    {
        return [__CLASS__, $this->getId(), $key];
    }

    public function saveAllowance($request, $action, $allowance, $timestamp): void
    {
        Yii::$app->cache->set($this->getCacheKey('api_rate_allowance'), $allowance, $this->rateWindowSize);
        Yii::$app->cache->set($this->getCacheKey('api_rate_timestamp'), $timestamp, $this->rateWindowSize);
    }
}
