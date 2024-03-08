<?php

namespace frontend\modules\procurement\models;

use Yii;

/**
 * This is the model class for table "procurement_activity_dates".
 *
 * @property int $id
 * @property int $activity
 * @property string $date_type
 * @property string $planned_date
 * @property string $actual_date
 * @property int $sequence
 * @property string $created
 * @property string $updated
 * @property int $user
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
            [['activity', 'date_type','planned_date',  'user'], 'required'],
            [['activity', 'sequence', 'user'], 'integer'],
            [['planned_date', 'actual_date', 'created', 'updated'], 'safe'],
            [['date_type'], 'string', 'max' => 11],
        /*    [['planned_date'], 'required', 
        
        'when' => function ($model)//----------validation on server side
        {
        return $model->applicable ==1;
        }, 
        'whenClient' => 'isApplicable' //-----------valiadtion function on client side
    
    ],*/
          
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
            'date_type' => 'Date Type ID',
            'planned_date' => 'Planned Date',
            'actual_date' => 'Actual Date',
            'sequence' => 'Sequence',
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
    
     public function getDateType()
    {
        return $this->hasOne(ProcurementDateTypes::className(), ['code' => 'date_type']);
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
