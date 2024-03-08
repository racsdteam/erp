<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ErpOrganizationAddress;

/**
 * ErpOrganizationAddressSearch represents the model behind the search form of `common\models\ErpOrganizationAddress`.
 */
class ErpOrganizationAddressSearch extends ErpOrganizationAddress
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'org', 'country', 'province', 'city'], 'integer'],
            [['postal code'], 'safe'],
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
        $query = ErpOrganizationAddress::find();

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
            'org' => $this->org,
            'country' => $this->country,
            'province' => $this->province,
            'city' => $this->city,
        ]);

        $query->andFilterWhere(['like', 'postal code', $this->postal code]);

        return $dataProvider;
    }
}
