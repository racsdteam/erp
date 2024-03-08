<?php

namespace frontend\modules\auction\models;

use Yii;

/**
 * This is the model class for table "bids".
 *
 * @property int $id
 * @property int $user
 * @property int $item
 * @property string $amount
 * @property string $timestamp
 */
class Bids extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bids';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db5');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'item', 'amount'], 'required'],
            [['user', 'item'], 'integer'],
            [['timestamp'], 'safe'],
            [['amount'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'item' => 'Item',
            'amount' => 'Amount',
            'timestamp' => 'Timestamp',
        ];
    }
}
