<?php

declare(strict_types = 1);

namespace modules\notes\models;

use common\models\User;
use creocoder\taggable\TaggableBehavior;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notes".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 */
class Note extends ActiveRecord
{
    public static function create(
        string $title,
        string $content,
        int $user_id
    ): self
    {
        $note = new self();
        $note->title = $title;
        $note->content = $content;
        $note->user_id = $user_id;
        $note->created_at = date('Y-m-d H:i:s');
        $note->updated_at = date('Y-m-d H:i:s');

        return $note;
    }
    public static function tableName(): string
    {
        return 'notes';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('notes', 'ID'),
            'title' => Yii::t('notes', 'Title'),
            'content' => Yii::t('notes', 'Content'),
            'user_id' => Yii::t('notes', 'User ID'),
            'created_at' => Yii::t('notes', 'Created At'),
            'updated_at' => Yii::t('notes', 'Updated At'),
        ];
    }

    public function behaviors(): array
    {
        return [
            'taggable' => [
                'class' => TaggableBehavior::class,
                'tagValuesAsArray' => true,
                'tagRelation' => 'tags',
                 'tagValueAttribute' => 'title',
                'tagFrequencyAttribute' => false,
            ],
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @throws InvalidConfigException
     */
    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable(Taggable::tableName(), ['taggable_id' => 'id'])
            ->orderBy(['tags.title' => SORT_ASC]);
    }

    /**
     * {@inheritdoc}
     * @return NoteQuery the active query used by this AR class.
     */
    public static function find(): NoteQuery
    {
        return new NoteQuery(get_called_class());
    }
}
