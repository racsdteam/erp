<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_subdivision_positions".
 *
 * @property int $id
 * @property int $subdiv_id
 * @property int $position_id
 * @property int $position_count
 */
class ErpSubdivisionPositions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_subdivision_positions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subdiv_id', 'position_id', 'position_count'], 'required'],
            [['subdiv_id', 'position_id', 'position_count'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subdiv_id' => 'Subdiv ID',
            'position_id' => 'Position ID',
            'position_count' => 'Position Count',
        ];
    }
}
