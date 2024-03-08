<?php

namespace frontend\modules\hr\models;

use Yii;
use yii\helpers\Json;
use common\models\UserHelper;

/**
 * This is the model class for table "approval_Workflows".
 *
 * @property int $id
 * @property string $name
 * @property int $entity_type
 * @property int $active
 * @property int $user
 * @property string $timestamp
 */
class ApprovalWorkflows extends \yii\db\ActiveRecord
{
      public $conditionModel;
     
      
      
          public function init()
{

$this->conditionModel = new ApprovalCondModel();

}
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'approval_workflows';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db4');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'entity_type','priority', 'user'], 'required'],
            [['entity_type','enable_condition', 'active','priority', 'user'], 'integer'],
            [['timestamp'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['conditions'], 'string'],
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
            'entity_type' => 'entity_type',
            'active' => 'Active',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
    public function getEntityType()
{
    return $this->hasOne(CompBusinessEntities::className(), ['id' => 'entity_type']);
}
    public function getSteps()
{
    return $this->hasMany(ApprovalWorkflowSteps::className(), ['wf_def' => 'id'])->orderBy(['number'=>SORT_ASC]);
}

    public function getWfSteps()
{
    return $this->hasMany(ApprovalWorkflowSteps::className(), ['wf_def' => 'id'])->orderBy(['number'=>SORT_ASC])->andOnCondition(['<>', 'task_type','Update']);
}


public function lastStep (){
    
 return ApprovalWorkflowSteps::find()->where(['wf_def'=>$this->id])->orderBy(['number'=>SORT_DESC])->One();   
    
} 


public function firstStep(){
    
 return ApprovalWorkflowSteps::find()->where(['wf_def'=>$this->id])->andwhere(['>', 'number',0])->orderBy(['number'=>SORT_ASC])->One();   
    
} 
 
public  function initCondition(){

if($this->conditions!=null){
    
 $jsondata = Json::decode( $this->conditions );
 $this->conditionModel->setAttributes( $jsondata);

}

}

public function matchCond($entityRecord,$requester){


//--------no condition set----------------------------
 if($this->conditions==null)
  
  return true;
  
  $this->initCondition();
  
  
$condType=$this->conditionModel->type;

if($condType=='POS'){
    $pos=UserHelper::getPositionInfo($requester) ; 
   if (in_array($pos['position_code'], $this->conditionModel->value)) {
      $condSet=$matchCond=true;

      }  
    
}
 else if($condType=='JOB_ROLE'){
    $pos=UserHelper::getPositionInfo($requester) ; 
   if (in_array($pos['job_role'], $this->conditionModel->value)) {
    $condSet=$matchCond=true;
     }  
    
}
else if($condType=='ORG_UNIT'){
    $orgUnit=UserHelper::getOrgUnitInfo($requester) ;
    if (in_array($orgUnit['unit_code'], $this->conditionModel->value)) {
    $condSet=$matchCond=true;
     }  
    
}
 else if($condType=='FIELD_VAL'){
  
   $condSet=$matchCond=true; 
}
else{
   $condSet=$matchCond=false;
     }
 
 
 return $condSet && $matchCond;
    
}

 public function getInstanceById($requestId){
//----------------------------get Approval instance----------------------------------------

return  ApprovalProcessInstances::find()->where(['process'=>$this->id,'request'=>$requestId])->One();

}

}
