<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\EmpAddress;

/**
 * EmpAddressSearch represents the model behind the search form of `frontend\modules\hr\models\EmpAddress`.
 */
class EmpAddressSearch extends EmpAddress
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee', 'country', 'province', 'district', 'sector', 'village'], 'integer'],
            [['city', 'address_line1','address_line2'], 'safe'],
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
        $query = EmpAddress::find();

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
            'country' => $this->country,
            'province' => $this->province,
            'district' => $this->district,
            'sector' => $this->sector,
            'village' => $this->village,
        ]);

        $query->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'address_line1', $this->address_line1])
         ->andFilterWhere(['like', 'address_line2', $this->address_line2]);

        return $dataProvider;
    }
}
