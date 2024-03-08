<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_travel_clearance_flow".
 *
 * @property int $id
 * @property int $requisition
 * @property int $creator
 * @property string $timestamp
 */
class ErpTravelClearanceFlow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_travel_clearance_flow';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['requisition', 'creator'], 'required'],
            [['requisition', 'creator'], 'integer'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'requisition' => 'Requisition',
            'creator' => 'Creator',
            'timestamp' => 'Timestamp',
        ];
    }
}
