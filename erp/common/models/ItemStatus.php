<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item_status".
 *
 * @property int $is_id
 * @property int $item_id
 * @property double $quantity
 * @property string $status
 * @property int $user
 * @property string $status_desc
 * @property string $timestamp
 */
class ItemStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_status';
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
            [['item_id', 'quantity', 'status', 'user', 'status_desc'], 'required'],
            [['item_id', 'user'], 'integer'],
            [['quantity'], 'number'],
            [['status_desc'], 'string'],
            [['timestamp'], 'safe'],
            [['status'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'is_id' => 'Is ID',
            'item_id' => 'Item ID',
            'quantity' => 'Quantity',
            'status' => 'Status',
            'user' => 'User',
            'status_desc' => 'Status Desc',
            'timestamp' => 'Timestamp',
        ];
    }
}
