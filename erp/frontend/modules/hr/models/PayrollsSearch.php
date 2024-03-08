<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\Payrolls;

/**
 * PayrollsSearch represents the model behind the search form of `frontend\modules\hr\models\Payrolls`.
 */
class PayrollsSearch extends Payrolls
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pay_group', 'user'], 'integer'],
            [['name', 'pay_period_month', 'pay_period_year','run_type', 'status', 'timestamp'], 'safe'],
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
        $query = Payrolls::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => false,//return all models
             'sort'=> ['defaultOrder' => ['timestamp' => SORT_DESC]],
        ]);
        
         /* $dataProvider->sort->attributes['pay_period_month'] = [
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

$dataProvider->sort->defaultOrder = ['pay_period_year' => SORT_DESC,'pay_period_month' => SORT_DESC,'timestamp' => SORT_ASC];*/

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'run_type' => $this->run_type,
            'pay_group' => $this->pay_group,
            'user' => $this->user,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'pay_period_month', $this->pay_period_month])
            ->andFilterWhere(['like', 'pay_period_year', $this->pay_period_year])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
