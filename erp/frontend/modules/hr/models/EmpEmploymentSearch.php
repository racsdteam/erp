<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\EmpEmployment;

/**
 * EmpEmploymentSearch represents the model behind the search form of `frontend\modules\hr\models\EmpEmployment`.
 */
class EmpEmploymentSearch extends EmpEmployment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee', 'unit', 'position', 'pay_type', 'pay_group', 'pay_grade', 'employement_type', 'supervisor','active'], 'integer'],
            [['start_date', 'end_date', 'work_location'], 'safe'],
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
        $query = EmpEmployment::find();

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
            'org_unit' => $this->unit,
            'position' => $this->position,
            'pay_type' => $this->pay_type,
            'active' => $this->active,
            'pay_group' => $this->pay_group,
            'pay_grade' => $this->pay_grade,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'employement_type' => $this->employement_type,
            'supervisor' => $this->supervisor,
        ]);

        $query->andFilterWhere(['like', 'work_location', $this->work_location]);

        return $dataProvider;
    }
}
