<?php

namespace frontend\modules\procurement\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\procurement\models\ProcurementActivities;

/**
 * ProcurementActivitiesSearch represents the model behind the search form of `frontend\modules\procurement\models\ProcurementActivities`.
 */
class ProcurementActivitiesSearch extends ProcurementActivities
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'planId', 'end_user_org_unit', 'user'], 'integer'],
            [['code', 'description', 'procurement_category', 'procurement_method', 'funding_source', 'status', 'created', 'updated'], 'safe'],
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
        $query = ProcurementActivities::find();

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
            'planId' => $this->planId,
            'end_user_org_unit' => $this->end_user_org_unit,
            'user' => $this->user,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'procurement_category', $this->procurement_category])
            ->andFilterWhere(['like', 'procurement_method', $this->procurement_method])
            ->andFilterWhere(['like', 'funding_source', $this->funding_source])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
