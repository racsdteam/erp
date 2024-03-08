<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ErpOrganizationContact;

/**
 * ErpOrganizationContactSearch represents the model behind the search form of `common\models\ErpOrganizationContact`.
 */
class ErpOrganizationContactSearch extends ErpOrganizationContact
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'org'], 'integer'],
            [['phone', 'website'], 'safe'],
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
        $query = ErpOrganizationContact::find();

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
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'website', $this->website]);

        return $dataProvider;
    }
}
