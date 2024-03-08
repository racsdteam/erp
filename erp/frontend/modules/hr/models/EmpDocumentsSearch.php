<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\EmpDocuments;

/**
 * EmpDocumentsSearch represents the model behind the search form of `frontend\modules\hr\models\EmpDocuments`.
 */
class EmpDocumentsSearch extends EmpDocuments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee'], 'integer'],
            [['category', 'document','details', 'file_name', 'fileType', 'mimeType'], 'safe'],
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
        $query = EmpDocuments::find();

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
            'document' => $this->document,
        ]);

        $query->andFilterWhere(['like', 'details', $this->details])
              ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'fileType', $this->fileType])
            ->andFilterWhere(['like', 'mimeType', $this->mimeType]);

        return $dataProvider;
    }
}
