<?php

namespace frontend\modules\procurement\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\procurement\models\ProcurementPlanApprovals;

/**
 * ProcurementPlanApprovalsSearch represents the model behind the search form of `frontend\modules\procurement\models\ProcurementPlanApprovals`.
 */
class ProcurementPlanApprovalsSearch extends ProcurementPlanApprovals
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'wfInstance', 'wfStep', 'request', 'assigned_to', 'on_behalf_of', 'assigned_from', 'is_new'], 'integer'],
            [['name', 'description', 'action_required', 'outcome', 'status', 'created_at', 'started_at', 'completed_at'], 'safe'],
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
        $query = ProcurementPlanApprovals::find();

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
            'wfInstance' => $this->wfInstance,
            'wfStep' => $this->wfStep,
            'request' => $this->request,
            'assigned_to' => $this->assigned_to,
            'on_behalf_of' => $this->on_behalf_of,
            'assigned_from' => $this->assigned_from,
            'is_new' => $this->is_new,
            'created_at' => $this->created_at,
            'started_at' => $this->started_at,
            'completed_at' => $this->completed_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'action_required', $this->action_required])
            ->andFilterWhere(['like', 'outcome', $this->outcome])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
