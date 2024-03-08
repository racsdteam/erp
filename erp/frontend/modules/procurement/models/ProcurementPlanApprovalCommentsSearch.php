<?php

namespace frontend\modules\procurement\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\procurement\models\ProcurementPlanApprovalComments;

/**
 * ProcurementPlanApprovalCommentsSearch represents the model behind the search form of `frontend\modules\procurement\models\ProcurementPlanApprovalComments`.
 */
class ProcurementPlanApprovalCommentsSearch extends ProcurementPlanApprovalComments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'wfInstance', 'wfStep', 'request', 'user'], 'integer'],
            [['comment', 'scope', 'timestamp'], 'safe'],
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
        $query = ProcurementPlanApprovalComments::find();

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
            'user' => $this->user,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'scope', $this->scope]);

        return $dataProvider;
    }
}
