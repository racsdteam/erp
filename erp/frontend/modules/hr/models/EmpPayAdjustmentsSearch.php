<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\EmpPayAdjustments;

/**
 * EmpPayAdjustmentsSearch represents the model behind the search form of `frontend\modules\hr\models\EmpPayAdjustments`.
 */
class EmpPayAdjustmentsSearch extends EmpPayAdjustments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee', 'user'], 'integer'],
            [['current_pay', 'adjusted_pay', 'effective_date', 'payout_month', 'reason', 'timestamp'], 'safe'],
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
        $query = EmpPayAdjustments::find();

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
            'effective_date' => $this->effective_date,
            'user' => $this->user,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'current_pay', $this->current_pay])
            ->andFilterWhere(['like', 'adjusted_pay', $this->adjusted_pay])
            ->andFilterWhere(['like', 'payout_month', $this->payout_month])
            ->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
