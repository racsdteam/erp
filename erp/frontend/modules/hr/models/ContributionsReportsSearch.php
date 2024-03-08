<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\ContributionsReports;

/**
 * ContributionsReportsSearch represents the model behind the search form of `frontend\modules\hr\models\ContributionsReports`.
 */
class ContributionsReportsSearch extends ContributionsReports
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'contribution', 'user'], 'integer'],
            [['description', 'pay_period_year', 'pay_period_month', 'status', 'timestamp'], 'safe'],
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
        $query = ContributionsReports::find();

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
            'contribution' => $this->contribution,
            'user' => $this->user,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'pay_period_year', $this->pay_period_year])
            ->andFilterWhere(['like', 'pay_period_month', $this->pay_period_month])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
