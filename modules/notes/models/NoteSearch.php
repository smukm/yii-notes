<?php

declare(strict_types = 1);

namespace modules\notes\models;

use Yii;
use yii\base\Model;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;

/**
 * NoteSearch represents the model behind the search form of `modules\notes\models\Note`.
 */
class NoteSearch extends Note
{
    // field for search by tags
    public string $tag = '';
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['title', 'content', 'created_at', 'updated_at'], 'string'],
            [['tag'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Note::find()
            ->cache(
                Yii::$app->params['cacheDuration'], new TagDependency([
                'tags' => Note::tableName()
            ]))
            ->with('tags');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);

        if(!empty($this->tag)) {
            $query->joinWith('tags');
            $query->where(['tags.title' => $this->tag]);
        }

        return $dataProvider;
    }
}
