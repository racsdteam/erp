<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ErpRequisition;

/**
 * ErpRequisitionSearch represents the model behind the search form of `common\models\ErpRequisition`.
 */
class ErpRequisitionSearch extends ErpRequisition
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'created_by', 'created_at', 'reference_memo', 'approve_status', 'tender_on_proc_plan'], 'integer'],
            [['title'], 'safe'],
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
        $query = ErpRequisition::find();

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
            'type' => $this->type,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'reference_memo' => $this->reference_memo,
            'approve_status' => $this->approve_status,
            'tender_on_proc_plan' => $this->tender_on_proc_plan,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
