<?php

namespace frontend\modules\procurement\models;

use Yii;

/**
 * This is the model class for table "procurement_plans".
 *
 * @property int $id
 * @property string $name
 * @property string $fiscal_year
 * @property string $status
 * @property int $user
 * @property string $created_at
 * @property string $updated_at
 */
class ProcurementPlans extends \yii\db\ActiveRecord
{
    
     const STATUS_TYPE_PLAN='Planning';//--active
     const STATUS_TYPE_PEND_APP='Pending Approval';//--notactive employee
     const STATUS_TYPE_IN_PROG='In Progress';//--notactive
     const STATUS_TYPE_PUB='Published';//--new hire
     const STATUS_TYPE_APP='Approved';//--termited
     const STATUS_TYPE_CANCELED='Canceled';//--retired
     const STATUS_TYPE_COMP='Completed';//--laid off
     
     const EVENT_REQUEST_APPROVAL ="procurement_plan_approved";
    const EVENT_REQUEST_SUBMISSION ="procurement_plan_submitted";
    
    public function init(){
    $this->on(self::EVENT_REQUEST_APPROVAL, [$this, 'onApproval']);
    $this->on(self::EVENT_REQUEST_SUBMISSION, [$this, 'onSubmission']);
   }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'procurement_plans';
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
            [['name', 'fiscal_year', 'user'], 'required'],
            [['status'], 'string'],
            [['user'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 500],
            [['fiscal_year'], 'string', 'max' => 255],
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
            'fiscal_year' => 'Fiscal Year',
            'status' => 'Status',
            'user' => 'Created By',
            'created_at' => 'Date Created',
            'updated_at' => 'Date Updated',
        ];
    }
    
    
    public  static function badgeStyle($status){
         $style=''; 
         switch($status){
                   
                       case  self::STATUS_TYPE_PLAN:
                       case  self::STATUS_TYPE_PEND_APP:
                          
                          $style='badge badge-danger';
                          break;
                         case self::STATUS_TYPE_IN_PROG :
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
    
public function beforeSave($insert) {
     
    
    $this->updated_at=date('Y-m-d H:i:s');

    return parent::beforeSave($insert);
}    
    
      public function beforeValidate()
{
    if (parent::beforeValidate()) {
        
         if(empty($this->user))
         $this->user=Yii::$app->user->identity->user_id; 
        
        
        return true;
    }
    return false;
}


    public function getUser0()
{
    return $this->hasOne(\common\models\User::className(), ['user_id' => 'user']);
}

public function getActivities()
{
 return $this->hasMany(ProcurementActivities::className(), ['planId' => 'id']);
}
public static function  findActivitiesByCategory($category)
    {
       return $this->hasMany(ProcurementActivities::className(), ['planId' => 'id'])
            ->andWhere(['procurement_category' => $category]);
    }
public function getYear(){
    
   $fyear=explode("-",$this->fiscal_year); 
   return $fyear[1];
}
   
 public function findWfInstance()
{
    return \frontend\modules\hr\models\ApprovalWorkflowInstances::findByEntityRecord($this->id,$this->formName());
} 
  
  
  function onApproval(){
     
    if(ucfirst($this->status)=="Approved")
    {
        
        foreach($this->activities as $activity):
            $activity->status="Approved";
             $activity->save(false);
              
             
        endforeach;
        
        
        
    }
}

function onSubmission(){
  
       if($this->status=='Pending Approval'){
       
        foreach($this->activities  as $activity):
            $activity->status="Pending Approval";
             $activity->save(false);
             
        endforeach;
        
        
} 
    
}

}
