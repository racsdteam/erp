<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\EmpPayOverrides;

/**
 * EmpPayOverridesSearch represents the model behind the search form of `frontend\modules\hr\models\EmpPayOverrides`.
 */
class EmpPayOverridesSearch extends EmpPayOverrides
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pay_id', 'tmpl', 'tmpl_line', 'active', 'user'], 'integer'],
            [['amount', 'timestamp'], 'safe'],
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
        $query = EmpPayOverrides::find();

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
            'pay_id' => $this->pay_id,
            'tmpl' => $this->tmpl,
            'tmpl_line' => $this->tmpl_line,
            'active' => $this->active,
            'user' => $this->user,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'amount', $this->amount]);

        return $dataProvider;
    }
}
