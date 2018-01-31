<?php

namespace frontend\models;

//use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Presentation;
use common\models\Tag;


/**
 * PresentationSearch represents the model behind the search form of `common\models\Presentation`.
 */
class PresentationSearch extends Presentation
{
    public $username;
    public $tagNames;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'is_public', 'created_at', 'updated_at', 'rating', 'category_id'], 'integer'],
            [['title', 'description', 'image_preview', 'publication_date', 'expiration_date', 'public_url'], 'safe'],
            [['username', 'tagNames'], 'safe'],
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
        $query = Presentation::getUserQueryConditions();
        $query->distinct(true)->joinWith(['user']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['user.username'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];
        
        $this->load($params);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            //'id' => $this->id,
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
            ->andFilterWhere(['like', 'user.username', $this->username]);
        
        if (!empty($this->tagNames)) {
            $tags = explode(',', $this->tagNames);
            $condition = Tag::find()
                ->select('id')
                ->where(['IN', 'name', $tags]);
            $query->joinWith('tags');
            $query->andWhere(['IN', 'tag_id', $condition]);
        }
        
        return $dataProvider;
    }
}
