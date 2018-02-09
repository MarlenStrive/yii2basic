<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Presentation;

/**
 * PresentationSearch represents the model behind the search form of `common\models\Presentation`.
 */
class PresentationSearch extends Presentation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'is_public', 'created_at', 'updated_at', 'rating', 'category_id'], 'integer'],
            [['title', 'description_pure', 'image_preview', 'publication_date', 'expiration_date', 'public_url'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
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
    public function search($params)
    {
        $query = Presentation::find();
        Presentation::setEditorQueryConditions($query);
        
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
            'is_public' => $this->is_public,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'publication_date' => $this->publication_date,
            'expiration_date' => $this->expiration_date,
            'rating' => $this->rating,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description_pure', $this->description_pure])
            ->andFilterWhere(['like', 'public_url', $this->public_url]);

        return $dataProvider;
    }
}
