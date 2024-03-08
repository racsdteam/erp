<?php

namespace frontend\modules\procurement\models;

use Yii;

/**
 * This is the model class for table "procurement_activity_dates".
 *
 * @property int $id
 * @property int $activity
 * @property string $end_user_requirements_submission
 * @property string $tender_preparation
 * @property string $tender_publication
 * @property string $bids_opening
 * @property string $award_notification
 * @property string $contract_signing
 * @property string $contract_start
 * @property string $supervising_firm
 * @property string $created
 * @property string $updated
 * @property int $user
 *
 * @property ProcurementActivities $activity0
 */
class ProcurementActivityDates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'procurement_activity_dates';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db8');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activity', 'end_user_requirements_submission', 'tender_preparation', 'tender_publication', 'bids_opening', 'award_notification', 'contract_signing', 'contract_start', 'user'], 'required'],
            [['activity', 'user'], 'integer'],
            [['end_user_requirements_submission', 'tender_preparation', 'tender_publication', 'bids_opening', 'award_notification', 'contract_signing', 'contract_start', 'supervising_firm', 'created', 'updated'], 'safe'],
            [['activity'], 'exist', 'skipOnError' => true, 'targetClass' => ProcurementActivities::className(), 'targetAttribute' => ['activity' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity' => 'Activity',
            'end_user_requirements_submission' => 'Requisition and Submisision of ToR/Technical Specs from end user',
            'tender_preparation' => 'Planned Tender Document Preparation Date',
            'tender_publication' => 'Planned Publication Date',
            'bids_opening' => 'Planned Bids Opening Date',
            'award_notification' => 'Planned Provisional Notification Date',
            'contract_signing' => 'Planned Contract Signing Date',
            'supervising_firm' => 'Recrutment of the Supervising Firm',
            'contract_start' => 'Planned Contract Management Start Date',
           
            'created' => 'Created',
            'updated' => 'Updated',
            'user' => 'User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity0()
    {
        return $this->hasOne(ProcurementActivities::className(), ['id' => 'activity']);
    }
    
   public function beforeSave($insert) {
     
     foreach ($this->attributes() as $attribute) {
          
        if(Yii::$app->procUtil->isValidDate($this->{$attribute},'d/m/Y')){
             
            $this->{$attribute}=Yii::$app->procUtil->dateFormat($this->{$attribute},'d/m/Y','Y-m-d');
    
        }
     }
    $this->updated=date('Y-m-d H:i:s');
    return parent::beforeSave($insert);
} 

public function afterFind(){

    parent::afterFind();
foreach ($this->attributes() as $attribute) {
          
        if(Yii::$app->procUtil->isValidDate($this->{$attribute},'Y-m-d')){
             
            $this->{$attribute}=Yii::$app->procUtil->dateFormat($this->{$attribute},'Y-m-d','d/m/Y');
    
        }
}
}
}
