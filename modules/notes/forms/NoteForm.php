<?php

declare(strict_types=1);

namespace modules\notes\forms;

use common\models\User;
use Yii;
use yii\base\Model;

class NoteForm extends Model
{
    public string $title = '';
    public string $content = '';
    public int $user_id;
    public string|array $tags = [];
    public int $id;

    public function __construct(
        int $id = 0,
        $config = []
    )
    {
        parent::__construct($config);

        $this->user_id = Yii::$app->user->getId();
        $this->id = $id;
    }

    public function beforeValidate()
    {
        if($this->tags === '') {
            $this->tags = [];
        }
        return parent::beforeValidate();
    }

    public function rules(): array
    {
        return [
            [['title', 'content', 'user_id',], 'required'],
            [['content'], 'string'],
            [['user_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']
            ],
            [['tags'], 'safe'],
        ];
    }
}