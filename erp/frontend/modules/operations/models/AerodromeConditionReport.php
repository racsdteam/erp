<?php

namespace frontend\modules\operations\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "aerodrome_condition_report".
 *
 * @property int $id
 * @property string $aerodrome
 * @property int $condition_status
 * @property string $awareness
 * @property string $TWY_condition
 * @property string $Apron_condition
 * @property string $other
 * @property string $date
 * @property string $timestamp
 */
class AerodromeConditionReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
     const NOT_SHARED = "not shared";
     const SHARED = "shared";
    public static function tableName()
    {
        return 'aerodrome_condition_report';
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
            [['aerodrome', 'condition_status',  'date'], 'required'],
            [['condition_status'], 'integer'],
            [['awareness'], 'string'],
            [['aerodrome'], 'string', 'max' => 4],
            [['TWY_condition', 'Apron_condition', 'other'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aerodrome' => 'Aerodrome',
            'condition_status' => 'Condition Status',
            'awareness' => 'Awareness',
            'TWY_condition' => 'Twy Condition',
            'Apron_condition' => 'Apron Condition',
            'other' => 'Other',
            'date' => 'Date',
            'timestamp' => 'Timestamp',
        ];
    }
    
       public function getSegmentreports()
    {
        return $this->hasMany(AerodromeSegmentReport::class, ['report_id' => 'id']);
    }
        public function getAerodromeinfo()
    {
        return $this->hasOne(AerodromeInfo::class, ['aerodrome' => 'aerodrome']);
    }
             public function User()
{
   
    $_user =User::find()->where(['user_id'=>$this->user_id])->One();
   
    return $_user;
}
}
