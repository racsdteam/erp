<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\CompStatutoryDetails;

/**
 * CompStatutoryDetailsSearch represents the model behind the search form of `frontend\modules\hr\models\CompStatutoryDetails`.
 */
class CompStatutoryDetailsSearch extends CompStatutoryDetails
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'rama_pay', 'pension_pay'], 'integer'],
            [['comp_rama_no', 'comp_pension_no'], 'safe'],
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
        $query = CompStatutoryDetails::find();

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
            'rama_pay' => $this->rama_pay,
            'pension_pay' => $this->pension_pay,
        ]);

        $query->andFilterWhere(['like', 'comp_rama_no', $this->comp_rama_no])
            ->andFilterWhere(['like', 'comp_pension_no', $this->comp_pension_no]);

        return $dataProvider;
    }
}
