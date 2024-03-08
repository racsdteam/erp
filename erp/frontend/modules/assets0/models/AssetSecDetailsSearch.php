<?php

namespace frontend\modules\assets0\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\assets0\models\AssetSecDetails;

/**
 * AssetSecDetailsSearch represents the model behind the search form of `frontend\modules\assets0\models\AssetSecDetails`.
 */
class AssetSecDetailsSearch extends AssetSecDetails
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'asset', 'enabled', 'up_to_date', 'user'], 'integer'],
            [['category', 'product', 'product_code', 'vendor','timestamp'], 'safe'],
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
        $query = AssetSecDetails::find();

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
            'asset' => $this->asset,
            'enabled' => $this->enabled,
         
            'up_to_date' => $this->up_to_date,
            'user' => $this->user,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'product', $this->product])
            ->andFilterWhere(['like', 'product_code', $this->product_code])
            ->andFilterWhere(['like', 'vendor', $this->vendor]);

        return $dataProvider;
    }
}
