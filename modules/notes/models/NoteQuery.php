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
    public function forCurrentUser(): NoteQuery
    {
        return $this->andWhere(['user_id' => Yii::$app->user->getId()]);
    }

    /**
     * {@inheritdoc}
     * @return Note[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Note|array|null
     */
    public function one($db = null): Note|array|null
    {
        return parent::one($db);
    }
}
