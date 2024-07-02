<?php

namespace frontend\modules\procurement\models;

use Yii;
use common\models\User;
use yii\behaviors\TimestampBehavior;
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\ObjectId;
/**
 * This is the model class for collection "tender_lots".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property \MongoDB\BSON\ObjectID|string $tender_id
 * @property mixed $name
 * @property mixed $description
 */
class TenderLots extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['tender', 'tender_lots'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            '_id',
            'title',
            'number',
            'envelope_code',
            'description',
            'tender_id',
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
            [['title', 'number','tender_id','envelope_code', 'description'], 'required']
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
            'tender_id' => 'Tender ID',
            'description' => 'Description',
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
    public function getEnvelopes()
{
    $envelopes =EnvelopeSettings::find()->where(['in','code',$this->envelope_code])->all();
       
    return $envelopes;
}
public function getItems()
{
    $items =TenderItems::find()->where(['lot_id'=>$this->_id])->all();
       
    return $items;
}

public function getDocuments($section_code)
{
    $docs=TenderDocuments::find()->where(['lot_id'=>$this->_id,'section_code'=>$section_code])->all();
       
    return  $docs;
}
public function getStaffs($section_code)
{
    $docs=TenderStaffs::find()->where(['lot_id'=>$this->_id,'section_code'=>$section_code])->all();
       
    return  $docs;
}
}
