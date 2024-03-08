<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tbldocumentfiles;

/**
 * TbldocumentfilesSearch represents the model behind the search form of `common\models\Tbldocumentfiles`.
 */
class TbldocumentfilesSearch extends Tbldocumentfiles
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'document', 'userID', 'date'], 'integer'],
            [['comment', 'name', 'dir', 'orgFileName', 'fileType', 'mimeType'], 'safe'],
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
        $query = Tbldocumentfiles::find();

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
            'document' => $this->document,
            'userID' => $this->userID,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'dir', $this->dir])
            ->andFilterWhere(['like', 'orgFileName', $this->orgFileName])
            ->andFilterWhere(['like', 'fileType', $this->fileType])
            ->andFilterWhere(['like', 'mimeType', $this->mimeType]);

        return $dataProvider;
    }
}
