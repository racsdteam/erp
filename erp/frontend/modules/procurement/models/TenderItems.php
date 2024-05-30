<?php

namespace frontend\modules\procurement\models;

use Yii;
use common\models\User;
use yii\behaviors\TimestampBehavior;
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\ObjectId;
/**
 * This is the model class for collection "tender_items".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $name
 * @property mixed $lot_id
 * @property mixed $description
 * @property mixed $type
 * @property mixed $unite
 * @property mixed $quantity
 * @property mixed $user_id
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class TenderItems extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['tender', 'tender_items'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'name',
            'lot_id',
            'description',
            'type',
            'unite',
            'quantity',
            'user_id',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'lot_id', 'description', 'type', 'unite', 'quantity', 'user_id', 'created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'name' => 'Name',
            'lot_id' => 'Lot ID',
            'description' => 'Description',
            'type' => 'Type',
            'unite' => 'Unite',
            'quantity' => 'Quantity',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
           if ($this->lot_id && !$this->lot_id instanceof ObjectId) {
               $this->lot_id = new ObjectId($this->lot_id);
           }
           return parent::beforeSave($insert);
       }

    public function User()
    {
       
        $_user =User::find()->where(['user_id'=>$this->user_id])->One();
       
        return $_user;
    }
}
