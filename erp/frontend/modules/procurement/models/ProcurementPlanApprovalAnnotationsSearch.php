<?php

namespace frontend\modules\procurement\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\procurement\models\ProcurementPlanApprovalAnnotations;

/**
 * ProcurementPlanApprovalAnnotationsSearch represents the model behind the search form of `frontend\modules\procurement\models\ProcurementPlanApprovalAnnotations`.
 */
class ProcurementPlanApprovalAnnotationsSearch extends ProcurementPlanApprovalAnnotations
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'doc', 'author'], 'integer'],
            [['type', 'annotation', 'annotation_id', 'timestamp'], 'safe'],
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
        $query = ProcurementPlanApprovalAnnotations::find();

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
            'doc' => $this->doc,
            'author' => $this->author,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'annotation', $this->annotation])
            ->andFilterWhere(['like', 'annotation_id', $this->annotation_id]);

        return $dataProvider;
    }
}
