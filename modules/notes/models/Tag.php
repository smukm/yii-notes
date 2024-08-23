<?php

declare(strict_types = 1);

namespace modules\notes\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tags".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 */
class Tag extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'tags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'slug'], 'required'],
            [['title', 'slug'], 'string', 'max' => 150],
            [['title'], 'unique'],
            [['slug'], 'unique'],
        ];
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => ['title', 'id'],
                'slugAttribute' => 'slug',
                'immutable' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('notes', 'ID'),
            'title' => Yii::t('notes', 'Title'),
            'slug' => Yii::t('notes', 'Slug'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return TagQuery the active query used by this AR class.
     */
    public static function find(): TagQuery
    {
        return new TagQuery(get_called_class());
    }

    public static function getList(): array
    {
        return ArrayHelper::map(
            self::find()->orderBy(['title' => SORT_ASC])->all(),
            'title',
            'title'
        );
    }
}
