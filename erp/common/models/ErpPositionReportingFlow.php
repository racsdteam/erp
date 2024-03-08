<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_position_reporting_flow".
 *
 * @property int $id
 * @property int $pos_from
 * @property int $pos_to
 */
class ErpPositionReportingFlow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_position_reporting_flow';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pos_from', 'pos_to'], 'required'],
            [['pos_from', 'pos_to'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pos_from' => 'Pos From',
            'pos_to' => 'Pos To',
        ];
    }
}
