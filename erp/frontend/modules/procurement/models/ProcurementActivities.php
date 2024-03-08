<?php

namespace frontend\modules\procurement\models;

use Yii;

/**
 * This is the model class for table "procurement_activities".
 *
 * @property int $id
 * @property int $planId
 * @property int $end_user_org_unit
 * @property string $code
 * @property string $description
 * @property string $procurement_category
 * @property string $procurement_method
 * @property string $funding_source
 * @property string $status
 * @property int $user
 * @property string $created
 * @property string $updated
 *
 * @property ProcurementActivityDates[] $procurementActivityDates
 */
class ProcurementActivities extends \yii\db\ActiveRecord
{
     const STATUS_TYPE_PLAN='Planning';//--active
     const STATUS_TYPE_PEND='Pending Approval';//--notactive employee
     const STATUS_TYPE_APP='Approved';//--termited
     const STATUS_TYPE_TEND='Tendering';//--notactive
     const STATUS_TYPE_PUB='Published';//--new hire
     const STATUS_TYPE_CANCELED='Canceled';//--retired
     const STATUS_TYPE_COMP='Completed';//--laid off
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'procurement_activities';
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
            [['planId', 'end_user_org_unit', 'code', 'description', 'procurement_category', 'procurement_method','estimate_cost', 'funding_source', 'user'], 'required'],
            [['planId', 'end_user_org_unit', 'user'], 'integer'],
            [['description', 'status'], 'string'],
            [['created', 'updated'], 'safe'],
            [['code', 'funding_source','estimate_cost'], 'string', 'max' => 255],
            [['procurement_category', 'procurement_method'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'planId' => 'Plan ID',
            'end_user_org_unit' => 'End User Org Unit',
            'code' => 'Code',
            'description' => 'Description',
            'procurement_category' => 'Procurement Category',
            'procurement_method' => 'Procurement Method',
            'estimate_cost'=>'Estimated  cost (Frw)',
            'funding_source' => 'Source of Funds',
            'status' => 'Status',
            'user' => 'User',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcurementActivityDates()
    {
        return $this->hasMany(ProcurementActivityDates::className(), ['activity' => 'id']);
    }
  
      public function getProcurementPlan()
{
    return $this->hasOne(ProcurementPlans::className(), ['id' => 'planId']);
}
  
       public function getProcurementCategory()
{
    return $this->hasOne(ProcurementCategories::className(), ['code' => 'procurement_category']);
}

      public function getProcurementMethod()
{
    return $this->hasOne(ProcurementMethods::className(), ['code' => 'procurement_method']);
}
 
 
      public function getFundingSource()
{
    return $this->hasOne(FundingSources::className(), ['code' => 'funding_source']);
}
    
    public function getUser0()
{
    return $this->hasOne(\common\models\User::className(), ['user_id' => 'user']);
}

public function beforeSave($insert) {
     
    
    $this->updated=date('Y-m-d H:i:s');

    return parent::beforeSave($insert);
}


   public  static function badgeStyle($status){
         $style=''; 
         switch($status){
                   
                       case  self::STATUS_TYPE_PLAN:
                          
                          $style='badge badge-danger';
                          break;
                         case self::STATUS_TYPE_PEND :
                          $style='badge badge-warning';
                         break;
                       
                         case self::STATUS_TYPE_PUB :
                          $style='badge badge-info';
                         break;
                         
                         case self::STATUS_TYPE_APP :
                         case self::STATUS_TYPE_COMP :     
                          $style='badge badge-success';
                         break;
                          
                          
                         case self::STATUS_TYPE_CANCELED :
                         
                         $style='badge badge-danger';
                        
                         break;
                        
                         default:
                         $style='badge badge-secondary';
                       
                        
                }
              
                return  $style;
    }
}
