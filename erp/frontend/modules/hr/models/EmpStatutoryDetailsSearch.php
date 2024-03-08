<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\EmpStatutoryDetails;

/**
 * EmpStatutoryDetailsSearch represents the model behind the search form of `frontend\modules\hr\models\EmpStatutoryDetails`.
 */
class EmpStatutoryDetailsSearch extends EmpStatutoryDetails
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee'], 'integer'],
            [['med_scheme','rama_no', 'mmi_no', 'pension_no'], 'safe'],
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
        $query = EmpStatutoryDetails::find();

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
           
        ]);

        $query->andFilterWhere(['like', 'med_scheme', $this->med_scheme])
                 ->andFilterWhere(['like', 'rama_no', $this->rama_no])
            ->andFilterWhere(['like', 'mmi_no', $this->mmi_no])
            ->andFilterWhere(['like', 'pension_no', $this->pension_no]);

        return $dataProvider;
    }
}
