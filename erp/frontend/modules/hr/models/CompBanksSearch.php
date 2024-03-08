<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\CompBanks;

/**
 * CompBanksSearch represents the model behind the search form of `frontend\modules\hr\models\CompBanks`.
 */
class CompBanksSearch extends CompBanks
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'acc_no', 'branch'], 'safe'],
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
        $query = CompBanks::find();

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'acc_no', $this->acc_no])
            ->andFilterWhere(['like', 'branch', $this->branch]);

        return $dataProvider;
    }
}
