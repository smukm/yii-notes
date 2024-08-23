<?php

declare(strict_types = 1);

namespace modules\notes\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "taggables".
 *
 * @property int $id
 * @property int $tag_id
 * @property int $taggable_id
 */
class Taggable extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'taggables';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['tag_id', 'taggable_id'], 'required'],
            [['tag_id', 'taggable_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('notes', 'ID'),
            'tag_id' => Yii::t('notes', 'Tag ID'),
            'taggable_id' => Yii::t('notes', 'Taggable ID'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return TaggableQuery the active query used by this AR class.
     */
    public static function find(): TaggableQuery
    {
        return new TaggableQuery(get_called_class());
    }
}
