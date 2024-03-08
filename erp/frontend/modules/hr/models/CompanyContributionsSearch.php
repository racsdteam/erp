<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\CompanyContributions;

/**
 * CompanyContributionsSearch represents the model behind the search form of `frontend\modules\hr\models\CompanyContributions`.
 */
class CompanyContributionsSearch extends CompanyContributions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'deduction', 'user'], 'integer'],
            [[  'earnings_basis', 'formula_base', 'amount_base', 'timestamp'], 'safe'],
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
        $query = CompanyContributions::find();

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
            'deduction' => $this->deduction,
            'user' => $this->user,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'earnings_basis', $this->earnings_basis])
            ->andFilterWhere(['like', 'formula_base', $this->formula_base])
            ->andFilterWhere(['like', 'amount_base', $this->amount_base]);

        return $dataProvider;
    }
}
