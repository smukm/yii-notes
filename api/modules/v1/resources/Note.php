<?php

namespace api\modules\v1\resources;

use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;


class Note extends \modules\notes\models\Note implements Linkable
{
    public function fields(): array
    {
        return ['id', 'title', 'content', 'created_at','updated_at', 'tags'];
    }

    public function extraFields(): array
    {
        return ['tags'];
    }

    public function getLinks(): array
    {
        return [
            Link::REL_SELF => Url::to(['notes/view', 'id' => $this->id], true)
        ];
    }
}
