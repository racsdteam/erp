<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ErpLpoRequestSupportingDoc;

/**
 * ErpLpoRequestSupportingDocSearch represents the model behind the search form of `common\models\ErpLpoRequestSupportingDoc`.
 */
class ErpLpoRequestSupportingDocSearch extends ErpLpoRequestSupportingDoc
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lpo_request'], 'integer'],
            [['title', 'doc_upload'], 'safe'],
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
        $query = ErpLpoRequestSupportingDoc::find();

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
            'lpo_request' => $this->lpo_request,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'doc_upload', $this->doc_upload]);

        return $dataProvider;
    }
}
