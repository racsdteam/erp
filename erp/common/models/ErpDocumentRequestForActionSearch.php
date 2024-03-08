<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ErpDocumentRequestForAction;

/**
 * ErpDocumentRequestForActionSearch represents the model behind the search form of `common\models\ErpDocumentRequestForAction`.
 */
class ErpDocumentRequestForActionSearch extends ErpDocumentRequestForAction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'document', 'requested_by'], 'integer'],
            [['action', 'timestamp'], 'safe'],
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
        $query = ErpDocumentRequestForAction::find();

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
            'document' => $this->document,
            'requested_by' => $this->requested_by,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'action', $this->action]);

        return $dataProvider;
    }
}
