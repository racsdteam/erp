<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ErpRequisitionItems;

/**
 * ErpRequisitionItemsSearch represents the model behind the search form of `common\models\ErpRequisitionItems`.
 */
class ErpRequisitionItemsSearch extends ErpRequisitionItems
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quantity', 'requisition_id'], 'integer'],
            [['designation', 'specs', 'badget_code'], 'safe'],
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
        $query = ErpRequisitionItems::find();

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
            'quantity' => $this->quantity,
            'requisition_id' => $this->requisition_id,
        ]);

        $query->andFilterWhere(['like', 'designation', $this->designation])
            ->andFilterWhere(['like', 'specs', $this->specs])
            ->andFilterWhere(['like', 'badget_code', $this->badget_code]);

        return $dataProvider;
    }
}
