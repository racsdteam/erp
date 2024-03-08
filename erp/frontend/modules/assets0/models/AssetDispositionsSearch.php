<?php

namespace frontend\modules\assets0\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\assets0\models\AssetDispositions;

/**
 * AssetDispositionsSearch represents the model behind the search form of `frontend\modules\assets0\models\AssetDispositions`.
 */
class AssetDispositionsSearch extends AssetDispositions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'asset', 'user'], 'integer'],
            [['dspl_date', 'dspl_reason', 'comment', 'timestamp'], 'safe'],
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
        $query = AssetDispositions::find();

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
            'dspl_date' => $this->dspl_date,
            'user' => $this->user,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'dspl_reason', $this->dspl_reason])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
