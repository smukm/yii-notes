<?php

declare(strict_types = 1);

namespace common\models;

use yii\db\ActiveQuery;


class UserQuery extends ActiveQuery
{

    public function active(): static
    {
        $this->andWhere(['status' => User::STATUS_ACTIVE]);
        return $this;
    }
}