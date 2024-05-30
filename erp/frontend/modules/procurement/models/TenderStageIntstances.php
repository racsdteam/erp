<?php

namespace frontend\modules\procurement\models;

use Yii;
use common\models\User;
use yii\behaviors\TimestampBehavior;
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\ObjectId;
/**
 * This is the model class for collection "tender_stage_intstances".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 */
class TenderStageIntstances extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['tender', 'tender_stage_intstances'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'tender_id',
            'stage_name',
            'stage_code',
            'sequence_number',
            'start_date',
            'end_date',
            'user_id',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title','procurement_method_code',],'string'],
            [['number_lots',],'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
        ];
    }

       /**
     * {@inheritdoc}
     */
    public function safeAttributes()
    {
        return $this->attributes();
    }

        /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->setScenario('default');
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at', // Attribute to store creation timestamp
                'updatedAtAttribute' => 'updated_at', // Attribute to store update timestamp
                 // Set the value to use current UTCDateTime for MongoDB
                 'value' => function () {
                    return new UTCDateTime(); // Return current UTCDateTime instance
                },
            ],
        ];
    }
   // Override the beforeSave() method to convert user_id to ObjectId before saving
   public function beforeSave($insert)
   {
       if ($this->tender_id && !$this->tender_id instanceof ObjectId) {
           $this->tender_id = new ObjectId($this->tender_id);
       }
       return parent::beforeSave($insert);
   }
    public function User()
    {
       
        $_user =User::find()->where(['user_id'=>$this->user_id])->One();
       
        return $_user;
    }
}
