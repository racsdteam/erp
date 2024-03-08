<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_transmission_slip".
 *
 * @property int $id
 * @property string $type
 * @property int $type_id
 * @property int $created_by
 * @property string $timestamp
 */
class ErpTransmissionSlip extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_transmission_slip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'created_by'], 'required'],
            [['type_id', 'created_by'], 'integer'],
            [['timestamp'], 'safe'],
            [['type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'type_id' => 'Type ID',
            'created_by' => 'Created By',
            'timestamp' => 'Timestamp',
        ];
    }
}
