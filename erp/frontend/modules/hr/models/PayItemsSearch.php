<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\PayItems;

/**
 * PayItemsSearch represents the model behind the search form of `frontend\modules\hr\models\PayItems`.
 */
class PayItemsSearch extends PayItems
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'subj_to_paye', 'pensionable', 'visible_on_payslip', 'active'], 'integer'],
            [['name', 'code', 'report_name', 'category', 'pay_type', 'statutory_type'], 'safe'],
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
        $query = PayItems::find();

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
            'subj_to_paye' => $this->subj_to_paye,
            'pensionable' => $this->pensionable,
            'visible_on_payslip' => $this->visible_on_payslip,
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'report_name', $this->report_name])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'pay_type', $this->pay_type])
            ->andFilterWhere(['like', 'statutory_type', $this->statutory_type]);

        return $dataProvider;
    }
}
