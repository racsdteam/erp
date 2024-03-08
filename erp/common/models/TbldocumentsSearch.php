<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tbldocuments;

/**
 * TbldocumentsSearch represents the model behind the search form of `common\models\Tbldocuments`.
 */
class TbldocumentsSearch extends Tbldocuments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'date', 'expires', 'owner', 'folder', 'inheritAccess', 'defaultAccess', 'locked'], 'integer'],
            [['name', 'comment', 'folderList', 'keywords'], 'safe'],
            [['sequence'], 'number'],
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
        $query = Tbldocuments::find();

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
            'date' => $this->date,
            'expires' => $this->expires,
            'owner' => $this->owner,
            'folder' => $this->folder,
            'inheritAccess' => $this->inheritAccess,
            'defaultAccess' => $this->defaultAccess,
            'locked' => $this->locked,
            'sequence' => $this->sequence,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'folderList', $this->folderList])
            ->andFilterWhere(['like', 'keywords', $this->keywords]);

        return $dataProvider;
    }
}
