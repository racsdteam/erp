<?php

namespace frontend\modules\auction\models;

use Yii;

/**
 * This is the model class for table "auctions_event_info".
 *
 * @property int $id
 * @property int $venue
 * @property string $date
 * @property int $auction_id
 */
class AuctionsEventInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auctions_event_info';
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
            [['venue', 'date_time', 'auction_id'], 'required'],
            [['venue', 'auction_id'], 'integer'],
            [['date_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'venue' => 'Venue',
            'date_time' => 'Date and Time',
            'auction_id' => 'Auction ID',
        ];
    }
}
