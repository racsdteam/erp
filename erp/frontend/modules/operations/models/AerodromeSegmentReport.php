<?php

namespace frontend\modules\operations\models;

use Yii;

/**
 * This is the model class for table "aerodrome_segment_report".
 *
 * @property int $id
 * @property int $report_id
 * @property double $assessed_depth
 * @property double $coverage_percentage
 * @property int $rubber_deposit_status
 * @property string $timestamp
 */
class AerodromeSegmentReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aerodrome_segment_report';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db6');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['report_id', 'assessed_depth', 'coverage_percentage', 'rubber_deposit_status','segment_id'], 'required'],
            [['report_id', 'rubber_deposit_status','segment_id'], 'integer'],
            [['assessed_depth'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'report_id' => 'Report ID',
            'assessed_depth' => 'Assessed Depth',
            'coverage_percentage' => 'Coverage Percentage',
            'rubber_deposit_status' => 'Rubber Deposit Status',
            'timestamp' => 'Timestamp',
        ];
    }
         public function getSegment()
    {
        return $this->hasOne(AerodromeSegment::class, ['id' => 'segment_id']);
    }
    
    public function getRunwayCondition($water_depth,$coverage,$contaminantion_status){
         if($water_depth >= 4)
       {
          $code=2;
       }
       elseif($water_depth < 4 && $coverage != "NR" )
       {
           if($contaminantion_status){
                $code=3;
           }
           else{
             $code=5;  
           }
       }
       else{
         $code=6;   
       }
       $condition= AerodromeConditionType::find()->where (["code"=>$code])->one();
       
       return $condition;
    }
}
