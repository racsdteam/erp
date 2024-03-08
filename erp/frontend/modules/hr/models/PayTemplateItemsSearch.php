<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\PayStructureItems;

/**
 * PayStructureItemsSearch represents the model behind the search form of `frontend\modules\hr\models\PayStructureItems`.
 */
class PayStructureItemsSearch extends PayStructureItems
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pay_structure', 'item', 'active'], 'integer'],
            [['item_categ', 'calc_type', 'formula', 'amount'], 'safe'],
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
        $query = PayStructureItems::find();

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
            'pay_structure' => $this->pay_structure,
            'item' => $this->item,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'item_categ', $this->item_categ])
            ->andFilterWhere(['like', 'calc_type', $this->calc_type])
            ->andFilterWhere(['like', 'formula', $this->formula])
            ->andFilterWhere(['like', 'amount', $this->amount]);

        return $dataProvider;
    }
}
