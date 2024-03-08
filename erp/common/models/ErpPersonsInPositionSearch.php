<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ErpPersonsInPosition;

/**
 * ErpPersonsInPositionSearch represents the model behind the search form of `common\models\ErpPersonsInPosition`.
 */
class ErpPersonsInPositionSearch extends ErpPersonsInPosition
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'person_id', 'position_id', 'unit_id'], 'integer'],
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
        $query = ErpPersonsInPosition::find();

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
            'person_id' => $this->person_id,
            'position_id' => $this->position_id,
            'unit_id' => $this->unit_id,
        ]);

        return $dataProvider;
    }
}
