<?php

namespace frontend\modules\hr\models;

use Yii;
use common\models\User;
use common\models\UserHelper;
use common\models\ AssignmentUserResolver;

/**
 * This is the model class for table "approval_workflow_instances".
 *
 * @property int $id
 * @property int $wf_def
 * @property int $initiator
 * @property int $entity_record
 * @property string $entity_type
 * @property string $status
 * @property string $started_at
 * @property string $completed_at
 */
class ApprovalWorkflowInstances extends \yii\db\ActiveRecord
{
    
      const INST_CLASS_MAP=['LeaveRequest'=>'frontend\modules\hr\models\LeaveApprovalInstances',
                       'PayrollApprovalRequests'=>'frontend\modules\hr\models\PayrollApprovalRequestInstances',
                       'PayrollRepsApprovalRequests'=>'frontend\modules\hr\models\PayrollRepsApprovalRequestInstances',
                       'PerformanceContract'=>'frontend\modules\hr\models\PcApprovalRequestInstances',
                       'ProcurementPlans'=>'frontend\modules\procurement\models\ProcurementPlansApprovalInstances',
                       ];
        
                            
     
       const STATUS_IN_PROGRESS = 'in progress';
       const STATUS_RUNNING = 'running';
       const STATUS_COMPLETED = 'completed';
       const STATUS_APPROVED = 'approved';
       const STATUS_REJECTED = 'rejected';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'approval_workflow_instances';
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
            [['wf_def', 'initiator', 'entity_record', 'entity_type'], 'required'],
            [['wf_def', 'initiator', 'entity_record'], 'integer'],
            [['status'], 'string'],
            [['started_at', 'completed_at'], 'safe'],
            [['entity_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wf_def' => 'Wf Class',
            'initiator' => 'Initiator',
            'entity_record' => 'Entity Record',
            'entity_type' => 'Entity Type',
            'status' => 'Status',
            'started_at' => 'Started At',
            'completed_at' => 'Completed At',
        ];
    }
    
 
   
  //--------------step nodes instances------------------------------------------- 
   
  public function getStepInstances(){
    
     return $this->hasMany(ApprovalWorkflowInstanceSteps::class, ['wfInstance' => 'id']); 
       
   }
 //----------------Approval or Review Steps---------------------------------------
   public function getReviewStepInstances(){
    
     return $this->hasMany(ApprovalWorkflowInstanceSteps::class, ['wfInstance' => 'id'])->andOnCondition(['<>', 'task_type','Update'])
     ->orderBy([new \yii\db\Expression('-completed_at ASC'),new \yii\db\Expression('number ASC')]); //appended - sign to sort by null  
       
   }
 
     
  public function firstWaitingStep(){
    
   return ApprovalWorkflowInstanceSteps::find()->where(['wfInstance'=>$this->id,'status'=>'not started'])->andwhere(['<>', 'number',0])->orderBy(['number'=>SORT_ASC])->One();
       
   }
  
   public function nextWaitingStep($prev){
  
  
   return ApprovalWorkflowInstanceSteps::find()->where(['wfInstance'=>$this->id,'status'=>'not started'])->andwhere(['=', 'number',$prev->number+1])->One();   
       
   }
 
  
  public  function getLastStep(){
   
   return ApprovalWorkflowInstanceSteps::find()->where(['wfInstance'=>$this->id])->andwhere(['>', 'number',0])->orderBy(['number'=>SORT_DESC])->One();   
       
   }
   
  public function getCurrentStep(){
       
    return ApprovalWorkflowInstanceSteps::find()->where(['wfInstance'=>$this->id,'status'=>'started'])->One();     
       
     }
     
 
     
     
     
 public function getCompletedSteps(){
    
   return $this->hasMany(ApprovalWorkflowInstanceSteps::class, ['wfInstance' => 'id'])->onCondition(['isComplete' =>true])->andOnCondition(['>', 'number',0]);  
       
   }

 public  function getUpdateStep(){
   
   return ApprovalWorkflowInstanceSteps::find()->where(['wfInstance'=>$this->id,'number'=>0])->One();   
       
   }

    public function getWorkflowDef()
{
    return $this->hasOne(ApprovalWorkflows::className(), ['id' => 'wf_def']);
}

   public function getWfInitiator()
{
    return $this->hasOne(User::className(), ['user_id' => 'initiator']);
}




            /**
* @param array $row
*
* @return ApprovalWorkflowInstances|LeaveApprovalFlowInstances|
*/
public static function instantiate($row)
{

if(!isset(self::INST_CLASS_MAP[$row['entity_type']]))
return new self;

//$className=end( explode( "\\", self::INST_CLASS_MAP[$row['entity_type']] ) );
$className=self::INST_CLASS_MAP[$row['entity_type']];
return new $className();

}




 public function createStepInstances(){
    
    $res=[];
    $res['status']='success';
  
    $stepNodes=$this->workflowDef->steps;
   
    $wfContext= new ApprovalFlowContext();
    $wfContext->setWfInstance($this);
    
    if(!empty($stepNodes)){
     
     
     $transaction = \Yii::$app->db->beginTransaction();
   
    try {
       
       foreach($stepNodes as $node){
    
    $stepNodeInst=new ApprovalWorkflowInstanceSteps();
    $stepNodeInst->stepNode=$node->id;
    $stepNodeInst->wfInstance=$this->id;
    $stepNodeInst->name=$node->name;
    $stepNodeInst->task_type=$node->task_type;
    $stepNodeInst->task_actions=$node->task_actions;
    $stepNodeInst->description=$node->description;
    $stepNodeInst->is_last_approval=$node->is_last_approval;
    $stepNodeInst->number=$node->number;
    $actor=AssignmentUserResolver::resolveUser($node, $wfContext);
   
    if($actor!=null && is_numeric($actor)){
     $stepNodeInst->assignedTo=$actor;
     $stepNodeInst->assignedTo_orgUnit=UserHelper::getOrgUnit($actor)->id;
     $stepNodeInst->assignedTo_position=UserHelper::getPosition($actor)->id;    
    }
   
    if(!$stepNodeInst->save()){
          
         
          $res['status']='error';
          $res['error']=$stepNodeInst->getErrors();
          break;
    }
   
     
     } 
         
        if($res['status']!='success'){
          $transaction->rollBack();
          return $res;  
        } 
        $transaction->commit();
        return $res;
         
    } catch(Exception $e) {
        $transaction->rollback();
    }
     
     
        }
    
      
        
    }
 public function isInProgress(){
  
  return ($this->status == self::STATUS_IN_PROGRESS) || ($this->status == self::STATUS_RUNNING);   
     
 }   
 
 public static function findByEntityRecord($entityRecord,$entityType){
  
  return self::find()->where(['entity_record'=>$entityRecord,'entity_type'=>$entityType])->One();   
     
 }  
 
 
 public function forceApproval($outcome){
     $entityRecord=$this->entityRecord;
            if($outcome=='approved'){
               $entityRecord->status='approved'; 
              }
              elseif($outcome=='rejected'){
                   $entityRecord->status='declined';
              }
        if(!$entityRecord->save(false)){
        
                         $res['status']='error';
                             $res['error']=$entityRecord->getErrors();
                          return $res;
            }
                        
                 $res['status']='success';
                 return $res;
 }
}
