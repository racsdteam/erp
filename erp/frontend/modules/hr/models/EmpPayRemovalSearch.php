<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\EmpPayRemoval;

/**
 * EmpPayRemovalSearch represents the model behind the search form of `frontend\modules\hr\models\EmpPayRemoval`.
 */
class EmpPayRemovalSearch extends EmpPayRemoval
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee', 'pay_structure', 'pay_structure_item', 'user'], 'integer'],
            [['timestamp'], 'safe'],
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
        $query = EmpPayRemoval::find();

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
            'employee' => $this->employee,
            'pay_structure' => $this->pay_structure,
            'pay_structure_item' => $this->pay_structure_item,
            'user' => $this->user,
            'timestamp' => $this->timestamp,
        ]);

        return $dataProvider;
    }
}
