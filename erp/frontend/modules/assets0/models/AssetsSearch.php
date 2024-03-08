<?php

namespace frontend\modules\assets0\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\assets0\models\Assets;

/**
 * AssetsSearch represents the model behind the search form of `frontend\modules\assets0\models\Assets`.
 */
class AssetsSearch extends Assets
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by'], 'integer'],
            [['type', 'name', 'manufacturer', 'model', 'serialNo', 'tagNo', 'acq_date', 'ass_cond', 'life_span', 'status', 'created'], 'safe'],
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
        $query = Assets::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => false,
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
            'acq_date' => $this->acq_date,
            //'created_by' => $this->created_by,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'manufacturer', $this->manufacturer])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'serialNo', $this->serialNo])
            ->andFilterWhere(['like', 'tagNo', $this->tagNo])
            ->andFilterWhere(['like', 'ass_cond', $this->ass_cond])
            ->andFilterWhere(['like', 'life_span', $this->life_span])
             ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
