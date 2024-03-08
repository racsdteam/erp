<?php

namespace frontend\modules\procurement\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\procurement\models\ProcurementActivityDates;

/**
 * ProcurementActivityDatesSearch represents the model behind the search form of `frontend\modules\procurement\models\ProcurementActivityDates`.
 */
class ProcurementActivityDatesSearch extends ProcurementActivityDates
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'activity', 'user'], 'integer'],
            [['end_user_requirements_submission', 'tender_preparation', 'tender_publication', 'bids_opening', 'award_notification', 'contract_signing', 'contract_start', 'supervising_firm', 'created', 'updated'], 'safe'],
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
        $query = ProcurementActivityDates::find();

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
            'activity' => $this->activity,
            'end_user_requirements_submission' => $this->end_user_requirements_submission,
            'tender_preparation' => $this->tender_preparation,
            'tender_publication' => $this->tender_publication,
            'bids_opening' => $this->bids_opening,
            'award_notification' => $this->award_notification,
            'contract_signing' => $this->contract_signing,
            'contract_start' => $this->contract_start,
            'supervising_firm' => $this->supervising_firm,
            'created' => $this->created,
            'updated' => $this->updated,
            'user' => $this->user,
        ]);

        return $dataProvider;
    }
}
