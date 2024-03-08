<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\EmpPayDetails;

/**
 * EmpPayDetailsSearch represents the model behind the search form of `frontend\modules\hr\models\EmpPayDetails`.
 */
class EmpPayDetailsSearch extends EmpPayDetails
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee', 'org_unit', 'position', 'pay_level', 'pay_group', 'created_by'], 'integer'],
            [['pay_basis', 'base_pay', 'created'], 'safe'],
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
        $query = EmpPayDetails::find()->select(['*',"cast(REPLACE(base_pay,',','') as unsigned ) as base"])->where(['active'=>1]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>false,
            'sort'=> ['defaultOrder' => ['base' => SORT_DESC]],
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
            'org_unit' => $this->org_unit,
            'position' => $this->position,
            'pay_level' => $this->pay_level,
            'pay_group' => $this->pay_group,
            'created_by' => $this->created_by,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'pay_basis', $this->pay_basis])
               ->andFilterWhere(['like', 'base_pay', $this->base_pay]);

        return $dataProvider;
    }
}
