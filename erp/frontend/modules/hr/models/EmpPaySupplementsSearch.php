<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\EmpPaySupplements;

/**
 * EmpPaySupplementsSearch represents the model behind the search form of `frontend\modules\hr\models\EmpPaySupplements`.
 */
class EmpPaySupplementsSearch extends EmpPaySupplements
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee', 'item', 'active', 'user','pay_period'], 'integer'],
            [['item_categ', 'pay_frequency',  'from_date', 'to_date', 'timestamp'], 'safe'],
            [['amount'], 'number'],
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
        $query = EmpPaySupplements::find();

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
            'employee' => $this->employee,
            'item' => $this->item,
            'pay_period' => $this->pay_period,
            'amount' => $this->amount,
            'active' => $this->active,
            'user' => $this->user,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'item_categ', $this->item_categ])
            ->andFilterWhere(['like', 'pay_frequency', $this->pay_frequency])
            ->andFilterWhere(['like', 'from_date', $this->from_date])
            ->andFilterWhere(['like', 'to_date', $this->to_date]);

        return $dataProvider;
    }
}
