<?php

namespace frontend\modules\procurement\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\procurement\models\ProcurementPlans;

/**
 * ProcurementPlansSearch represents the model behind the search form of `frontend\modules\procurement\models\ProcurementPlans`.
 */
class ProcurementPlansSearch extends ProcurementPlans
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user'], 'integer'],
            [['name', 'fiscal_year', 'status', 'created_at', 'updated_at'], 'safe'],
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
        $query = ProcurementPlans::find();

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
            'user' => $this->user,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'fiscal_year', $this->fiscal_year])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
