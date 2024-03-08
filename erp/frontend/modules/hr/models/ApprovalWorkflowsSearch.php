<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\ApprovalWorkflows;

/**
 * ApprovalWorkflowsSearch represents the model behind the search form of `frontend\modules\hr\models\ApprovalWorkflows`.
 */
class ApprovalWorkflowsSearch extends ApprovalWorkflows
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'entity_type', 'active','priority', 'user'], 'integer'],
            [['name', 'timestamp'], 'safe'],
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
        $query = ApprovalWorkflows::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
           'sort'=> ['defaultOrder' => ['timestamp' => SORT_DESC]],
            'pagination'=>false,
           
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
            'entity_type' => $this->entity_type,
            'active' => $this->active,
            'user' => $this->user,
            'priority' => $this->priority,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
