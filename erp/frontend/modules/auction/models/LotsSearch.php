<?php

namespace frontend\modules\auction\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\auction\models\Lots;

/**
 * LotsSearch represents the model behind the search form of `frontend\modules\auction\models\Lots`.
 */
class LotsSearch extends Lots
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lot', 'winner', 'user'], 'integer'],
            [['description', 'image', 'quantity', 'reserve_price', 'comment', 'auction_date', 'timestamp'], 'safe'],
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
        $query = Lots::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
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
            'lot' => $this->lot,
            'auction_date' => $this->auction_date,
            
            'winner' => $this->winner,
            'user' => $this->user,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'quantity', $this->quantity])
            ->andFilterWhere(['like', 'reserve_price', $this->reserve_price])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
