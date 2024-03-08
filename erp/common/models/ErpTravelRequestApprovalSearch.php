<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ErpTravelRequestApproval;

/**
 * ErpTravelRequestApprovalSearch represents the model behind the search form of `common\models\ErpTravelRequestApproval`.
 */
class ErpTravelRequestApprovalSearch extends ErpTravelRequestApproval
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tr_id', 'approved_by', 'is_new'], 'integer'],
            [['approval_status', 'approved', 'remark'], 'safe'],
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
        $query = ErpTravelRequestApproval::find();

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
            'tr_id' => $this->tr_id,
            'approved_by' => $this->approved_by,
            'approved' => $this->approved,
            'is_new' => $this->is_new,
        ]);

        $query->andFilterWhere(['like', 'approval_status', $this->approval_status])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
