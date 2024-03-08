<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tbldocumentcontent;

/**
 * TbldocumentcontentSearch represents the model behind the search form of `common\models\Tbldocumentcontent`.
 */
class TbldocumentcontentSearch extends Tbldocumentcontent
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'document', 'version', 'date', 'createdBy', 'fileSize'], 'integer'],
            [['comment', 'dir', 'orgFileName', 'fileType', 'mimeType', 'checksum'], 'safe'],
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
        $query = Tbldocumentcontent::find();

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
            'version' => $this->version,
            'date' => $this->date,
            'createdBy' => $this->createdBy,
            'fileSize' => $this->fileSize,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'dir', $this->dir])
            ->andFilterWhere(['like', 'orgFileName', $this->orgFileName])
            ->andFilterWhere(['like', 'fileType', $this->fileType])
            ->andFilterWhere(['like', 'mimeType', $this->mimeType])
            ->andFilterWhere(['like', 'checksum', $this->checksum]);

        return $dataProvider;
    }
}
