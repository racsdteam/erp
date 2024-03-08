<?php

namespace frontend\modules\hr\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\EmpTermAttachments;

/**
 * EmpTermAttachmentsSearch represents the model behind the search form of `frontend\modules\hr\models\EmpTermAttachments`.
 */
class EmpTermAttachmentsSearch extends EmpTermAttachments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'term', 'user'], 'integer'],
            [['title', 'category', 'fileName', 'dir', 'fileType', 'mimeType', 'timestamp'], 'safe'],
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
        $query = EmpTermAttachments::find();

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
            'term' => $this->term,
            'user' => $this->user,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'fileName', $this->fileName])
            ->andFilterWhere(['like', 'dir', $this->dir])
            ->andFilterWhere(['like', 'fileType', $this->fileType])
            ->andFilterWhere(['like', 'mimeType', $this->mimeType]);

        return $dataProvider;
    }
}
