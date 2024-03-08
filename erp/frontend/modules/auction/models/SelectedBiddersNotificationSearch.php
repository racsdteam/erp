<?php

namespace frontend\modules\auction\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\auction\models\SelectedBiddersNotification;

/**
 * SelectedBiddersNotificationSearch represents the model behind the search form of `frontend\modules\auction\models\SelectedBiddersNotification`.
 */
class SelectedBiddersNotificationSearch extends SelectedBiddersNotification
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bidder', 'lot', 'notified', 'notifier'], 'integer'],
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
        $query = SelectedBiddersNotification::find();

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
            'bidder' => $this->bidder,
            'lot' => $this->lot,
            'notified' => $this->notified,
            'notifier' => $this->notifier,
            'timestamp' => $this->timestamp,
        ]);

        return $dataProvider;
    }
}
