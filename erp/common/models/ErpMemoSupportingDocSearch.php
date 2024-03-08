<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ErpMemoSupportingDoc;

/**
 * ErpMemoSupportingDocSearch represents the model behind the search form of `common\models\ErpMemoSupportingDoc`.
 */
class ErpMemoSupportingDocSearch extends ErpMemoSupportingDoc
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'memo'], 'integer'],
            [['doc_upload', 'doc_name'], 'safe'],
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
        $query = ErpMemoSupportingDoc::find();

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
            'type' => $this->type,
            'memo' => $this->memo,
        ]);

        $query->andFilterWhere(['like', 'doc_upload', $this->doc_upload])
            ->andFilterWhere(['like', 'doc_name', $this->doc_name]);

        return $dataProvider;
    }
}
