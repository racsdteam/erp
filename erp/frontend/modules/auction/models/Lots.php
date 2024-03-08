<?php

namespace frontend\modules\auction\models;

use Yii;

/**
 * This is the model class for table "Lots".
 *
 * @property int $id
 * @property string $description
 * @property int $category
 * @property int $location
 * @property string $image
 * @property int $lot
 * @property string $quantity
 * @property string $reserve_price
 * @property string $comment
 * @property string $start_date
 * @property string $end_date
 * @property int $winner
 * @property int $user
 * @property string $timestamp
 */
class Lots extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lots';
    }
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
            [['description', 'location', 'lot', 'reserve_price', 'user'], 'required'],
            [['description', 'comment'], 'string'],
            [['category', 'location', 'lot', 'winner', 'user'], 'integer'],
            [['auction_date', 'timestamp'], 'safe'],
            [['image', 'quantity', 'reserve_price'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'category' => 'Category',
            'location' => 'Location',
            'image' => 'Image',
            'lot' => 'Lot #',
            'quantity' => 'Quantity',
            'reserve_price' => 'Reserve Price',
            'comment' => 'Comment',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'winner' => 'Winner',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
    public function Location()
{
    $location='';
    $loc =LotsLocations::find()->where(['id'=>$this->location])->One();
   
    if($loc !=null){ 
       $location =$loc->location;        
    }
   

    return $location;
}

    public function auctionEventInfo()
{
   
    $eventInfo =AuctionsEventInfo::find()->where(['auction_id'=>$this->auction_id,'venue'=>$this->location])->One();
    return  $eventInfo;
}
}

