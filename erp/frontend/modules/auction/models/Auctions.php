<?php

namespace frontend\modules\auction\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "auctions".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $status
 * @property string $start_time
 * @property string $end_time
 * @property string $location
 * @property int $user
 * @property string $timestamp
 */
class Auctions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auctions';
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
            [['name', 'description', 'start_time', 'end_time', 'location', 'user'], 'required'],
            [['name', 'description', 'status'], 'string'],
            [['start_time', 'end_time', 'timestamp'], 'safe'],
            [['user'], 'integer'],
            [['location'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'status' => 'Status',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'location' => 'Location',
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

      public function User()
{
   
    $_user =User::find()->where(['user_id'=>$this->user])->One();
   
    return $_user;
}

 public function getLots(){
    
     return $this->hasMany(Lots::className(), ['auction_id' => 'id']);
}

}
