<?php

declare(strict_types = 1);

namespace modules\notes\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [[Taggable]].
 *
 * @see Taggable
 */
class TaggableQuery extends ActiveQuery
{

    /**
     * {@inheritdoc}
     * @return Taggable[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return array|ActiveRecord|null
     */
    public function one($db = null): array|ActiveRecord|null
    {
        return parent::one($db);
    }
}
