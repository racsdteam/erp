<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_desko_device".
 *
 * @property int $id
 * @property string $serial_number
 * @property int $status_id
 * @property int $location_id
 * @property int $gate_id
 * @property int $active
 */
class ErpDeskoDevice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_desko_device';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['serial_number', 'status_id', 'location_id'], 'required'],
            [['status_id', 'location_id', 'gate_id', 'active'], 'integer'],
            [['serial_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'serial_number' => 'Serial Number',
            'status_id' => 'Status ID',
            'location_id' => 'Location ID',
            'gate_id' => 'Gate ID',
            'active' => 'Active',
        ];
    }
}
