<?php

declare(strict_types = 1);

namespace modules\notes\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Note]].
 *
 * @see Note
 */
class NoteQuery extends ActiveQuery
{
    public function all($db = null): array
    {
        $this->andWhere(['user_id' => Yii::$app->user->getId()]);
        return parent::all($db);
    }

    public function one($db = null): Note|array|null
    {
        $this->andWhere(['user_id' => Yii::$app->user->getId()]);
        return parent::one($db);
    }
}
