<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fuel_voucher_info".
 *
 * @property int $id
 * @property int $item_request_id
 * @property string $driver
 * @property string $car
 * @property string $timestamp
 */
class FuelVoucherInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fuel_voucher_info';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_request_id', 'driver', 'car','date'], 'required'],
            [['item_request_id'], 'integer'],
            [['driver'], 'string', 'max' => 250],
            [['car'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_request_id' => 'Item Request ID',
            'driver' => 'Driver',
            'car' => 'Car',
            'timestamp' => 'Timestamp',
        ];
    }
}
