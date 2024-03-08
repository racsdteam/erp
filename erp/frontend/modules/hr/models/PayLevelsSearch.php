<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\PayLevels;

/**
 * PayLevelsSearch represents the model behind the search form of `frontend\modules\hr\models\PayLevels`.
 */
class PayLevelsSearch extends PayLevels
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'number'], 'integer'],
            [['name','description', 'basic_salary'], 'safe'],
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
        $query = PayLevels::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['number' => SORT_ASC]],
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
            'number' => $this->number,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
         ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'basic_salary', $this->basic_salary]);

        return $dataProvider;
    }
}
