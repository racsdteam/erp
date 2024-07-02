<?php

namespace frontend\modules\procurement\models;

use Yii;
use common\models\User;
use yii\behaviors\TimestampBehavior;
use MongoDB\BSON\UTCDateTime;

/**
 * This is the model class for collection "tenders".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 */
class Tenders extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $uploaded_file1;
    public $uploaded_file2;
    public $uploaded_file3;
    const STATUS_TYPE_DRAFT='Draft';//--active
    const STATUS_TYPE_SUBM='Submited';//--notactive employee
    const STATUS_TYPE_IN_PROG='In Progress';//--notactive
    const STATUS_TYPE_APP='Approved';//--termited
    const STATUS_TYPE_CANCELED='Canceled';//--retired
    const STATUS_TYPE_COMP='Completed';//--laid off


    public static function collectionName()
    {
        return ['tender', 'tenders'];
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
            'procurement_activity_id',
            'procurement_method_code',
            'procurement_category_code',
            'end_users',
            'funding_source_code',
            'currencies',
            'number_lots',
            'bid_security_amount',
            'tender_document',
            'alternative_bid_status',
            'final_destination',
            'manufactures_authorization_status',
            'bid_validity_periode',
            'tender_doc_charges_amount',
            'tender_doc_charges_status',
            'dao',
            'rfq',
            'rfp',
            'user_id',
            'created_at',
            'updated_at',
            'status'
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
            [['uploaded_file1'], 'file'],
            [['uploaded_file2'], 'file'],
            [['uploaded_file3'], 'file'],
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

    public function User()
    {
       
        $_user =User::find()->where(['user_id'=>$this->user_id])->One();
       
        return $_user;
    }
    public function getLots()
{
 return TenderLots::find()->where(['tender_id'=>$this->_id]) ->orderBy(['number' => SORT_ASC])->all();
}

public function getStages()
{
 return TenderStages::find()
 ->where(["and",['like','procurement_methods_code',$this->procurement_method_code],['like','procurement_categories_code',$this->procurement_category_code]])
 ->orderBy(["id" => SORT_DESC])
 ->one();
}
public function getStageInstances()
{
 return TenderStageIntstances::find()->where(['tender_id'=>$this->_id]) ->orderBy(['sequence_number' => SORT_ASC])->all();
}
public function generateNumner()
{
 return Yii::$app->procUtil->generateTenderCode($this->procurement_method_code,$this->procurement_category_code);
}

public function isTenderInProgress(){
$checkNotStarted= TenderStageIntstances::find()
 ->where(["<>",'status',TenderStageIntstances::STATUS_TYPE_NOT_START])
 ->orderBy(["id" => SORT_DESC])
 ->one();
if($checkNotStarted==null){
    return true;
}
return false;
}

}
