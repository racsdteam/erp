<?php

namespace frontend\modules\auction\models;

use Yii;

/**
 * This is the model class for table "selected_bidders_notification".
 *
 * @property int $id
 * @property int $bidder
 * @property int $lot_id
 * @property int $notified
 * @property int $notifier
 * @property string $timestamp
 */
class SelectedBiddersNotification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'selected_bidders_notification';
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
            [['bidder', 'lot', 'notified', 'notifier'], 'required'],
            [['bidder', 'lot', 'notified', 'notifier'], 'integer'],
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
            'bidder' => 'Bidder',
            'lot' => 'Lot No',
            'notified' => 'Notified',
            'notifier' => 'Notifier',
            'timestamp' => 'Timestamp',
        ];
    }
}
