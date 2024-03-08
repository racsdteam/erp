<?php

namespace frontend\modules\auction\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\auction\models\Auctions;

/**
 * AuctionsSearch represents the model behind the search form of `frontend\modules\auction\models\Auctions`.
 */
class AuctionsSearch extends Auctions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user'], 'integer'],
            [['name', 'description', 'status', 'start_time', 'end_time', 'location', 'timestamp'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Auctions::find();

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
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'user' => $this->user,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'location', $this->location]);

        return $dataProvider;
    }
}
