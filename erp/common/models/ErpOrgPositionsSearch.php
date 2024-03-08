<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ErpOrgPositions;

/**
 * ErpOrgPositionsSearch represents the model behind the search form of `common\models\ErpOrgPositions`.
 */
class ErpOrgPositionsSearch extends ErpOrgPositions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'report_to'], 'integer'],
            [['position'], 'safe'],
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
        $query = ErpOrgPositions::find()->where(['active_status'=>1]);

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
            'report_to' => $this->report_to,
        ]);

        $query->andFilterWhere(['like', 'position', $this->position]);

        return $dataProvider;
    }
}
