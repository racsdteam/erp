<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\EmpPayRevisions;

/**
 * EmpPayRevisionsSearch represents the model behind the search form of `frontend\modules\hr\models\EmpPayRevisions`.
 */
class EmpPayRevisionsSearch extends EmpPayRevisions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee', 'previous_pay', 'revised_pay', 'user'], 'integer'],
            [['revision_date', 'effective_date', 'payout_year', 'payout_month', 'status', 'activation_date', 'reason', 'timestamp'], 'safe'],
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
        $query = EmpPayRevisions::find();

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
            'previous_pay' => $this->previous_pay,
            'revised_pay' => $this->revised_pay,
            'revision_date' => $this->revision_date,
            'effective_date' => $this->effective_date,
            'activation_date' => $this->activation_date,
            'user' => $this->user,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'payout_year', $this->payout_year])
            ->andFilterWhere(['like', 'payout_month', $this->payout_month])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
