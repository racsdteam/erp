<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ErpUnitsPositions;

/**
 * ErpUnitsPositionsSearch represents the model behind the search form of `common\models\ErpUnitsPositions`.
 */
class ErpUnitsPositionsSearch extends ErpUnitsPositions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'unit_id', 'position_id', 'position_count'], 'integer'],
            [['position_status'], 'safe'],
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
        $query = ErpUnitsPositions::find();

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
            'unit_id' => $this->unit_id,
            'position_id' => $this->position_id,
            'position_count' => $this->position_count,
        ]);

        $query->andFilterWhere(['like', 'position_status', $this->position_status]);

        return $dataProvider;
    }
}
