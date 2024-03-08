<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\ReportColumns;

/**
 * ReportColumnsSearch represents the model behind the search form of `frontend\modules\hr\models\ReportColumns`.
 */
class ReportColumnsSearch extends ReportColumns
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'report', 'display_order'], 'integer'],
            [['dataset', 'field', 'display_name'], 'safe'],
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
        $query = ReportColumns::find();

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
            'report' => $this->report,
            'display_order' => $this->display_order,
        ]);

        $query->andFilterWhere(['like', 'dataset', $this->dataset])
            ->andFilterWhere(['like', 'field', $this->field])
            ->andFilterWhere(['like', 'display_name', $this->display_name]);

        return $dataProvider;
    }
}
