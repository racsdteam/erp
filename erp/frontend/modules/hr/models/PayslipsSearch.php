<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\Payslips;

/**
 * PayslipsSearch represents the model behind the search form of `frontend\modules\hr\models\Payslips`.
 */
class PayslipsSearch extends Payslips
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee', 'pay_period', 'org_unit','position', 'user'], 'integer'],
            [['base_pay'], 'number'],
            [['status'], 'string'],
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
        $query = Payslips::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>['defaultOrder'=>['id'=>SORT_DESC]]
        ]);
       
        $this->load($params);
        
        if (empty($this->employee) || $this->status!='approved'){
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        /*if (!$this->validate()) {
            var_dump(0);die();
            // uncomment the following line if you do not want to return any records when validation fails
            //$query->where('0=1');
            return $dataProvider;
        }*/

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'employee' => $this->employee,
            'base_pay' => $this->base_pay,
            'pay_period' => $this->pay_period,
            'org_unit' => $this->org_unit,
            'position' => $this->position,
            'status' => $this->status,
            'user' => $this->user,
            'timestamp' => $this->timestamp,
        ]);

        return $dataProvider;
    }
}
