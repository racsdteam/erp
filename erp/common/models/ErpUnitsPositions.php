<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_units_positions".
 *
 * @property int $id
 * @property int $unit_id
 * @property int $position_id
 * @property int $position_count
 * @property string $position_status
 */
class ErpUnitsPositions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_units_positions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_id', 'position_id','report_to'], 'required'],
            [['unit_id', 'position_id','report_to', 'position_count'], 'integer'],
            [['position_status'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_id' => 'Unit ID',
            'position_id' => 'Position ID',
            'position_count' => 'Position Count',
            'position_status' => 'Position Status',
        ];
    }
    
function getUnit(){
return $this->hasOne(ErpOrgUnits::className(), ['id' => 'unit_id']);
}

    
function geReportTo(){
return $this->hasOne(ErpOrgPositions::className(), ['id' => 'report_to']);
}
}
