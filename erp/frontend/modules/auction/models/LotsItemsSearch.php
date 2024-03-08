<?php

namespace frontend\modules\auction\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\auction\models\LotsItems;

/**
 * LotsItemsSearch represents the model behind the search form of `frontend\modules\auction\models\LotsItems`.
 */
class LotsItemsSearch extends LotsItems
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lot', 'user'], 'integer'],
            [['item_name', 'timestamp'], 'safe'],
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
        $query = LotsItems::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>false
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
            'user' => $this->user,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'item_name', $this->item_name]);

        return $dataProvider;
    }
}
