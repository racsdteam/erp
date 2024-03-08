<?php

namespace frontend\modules\assets0\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\assets0\models\AssetAllocations;

/**
 * AssetAllocationsSearch represents the model behind the search form of `frontend\modules\assets0\models\AssetAllocations`.
 */
class AssetAllocationsSearch extends AssetAllocations
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'asset', 'org_unit', 'employee', 'user'], 'integer'],
            [['allocation_date', 'timestamp'], 'safe'],
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
        $query = AssetAllocations::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>false
            
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
            'asset' => $this->asset,
            'org_unit' => $this->org_unit,
            'employee' => $this->employee,
            'allocation_date' => $this->allocation_date,
            'user' => $this->user,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere([
            'active' =>1
           
           
        ]);

        return $dataProvider;
    }
}
