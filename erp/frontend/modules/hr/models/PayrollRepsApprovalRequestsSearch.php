<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\PayrollRepsApprovalRequests;

/**
 * PayrollRepsApprovalRequestsSearch represents the model behind the search form of `frontend\modules\hr\models\PayrollRepsApprovalRequests`.
 */
class PayrollRepsApprovalRequestsSearch extends PayrollRepsApprovalRequests
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user', 'wfInstance'], 'integer'],
            [['pay_period_year', 'pay_period_month', 'pay_period_start', 'pay_period_end', 'reports', 'status', 'timestamp'], 'safe'],
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
        $query = PayrollRepsApprovalRequests::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            
        ]);

          $dataProvider->sort->attributes['pay_period_month'] = [
    'asc' => [
        new \yii\db\Expression("TRIM(LEADING '0' FROM pay_period_month) DESC"),
        'pay_period_month' => SORT_ASC,
     ],
     'desc' => [
         new \yii\db\Expression("TRIM(LEADING '0' FROM pay_period_month) DESC"),
         'pay_period_month' => SORT_DESC,
     ],
     'label' => $this->getAttributeLabel('pay_period_month'),
];

$dataProvider->sort->defaultOrder = ['pay_period_year' => SORT_DESC,'pay_period_month' => SORT_DESC,'timestamp' => SORT_DESC];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'pay_period_start' => $this->pay_period_start,
            'pay_period_end' => $this->pay_period_end,
            'user' => $this->user,
            'wfInstance' => $this->wfInstance,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'pay_period_year', $this->pay_period_year])
            ->andFilterWhere(['like', 'pay_period_month', $this->pay_period_month])
            ->andFilterWhere(['like', 'reports', $this->reports])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
