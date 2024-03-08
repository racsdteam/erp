<?php
namespace frontend\modules\hr\models;

use Yii;
use common\models\User;
use common\models\UserHelper;

date_default_timezone_set('Africa/Cairo');
/**
 * This is the model class for table "approval_workflow_instances".
 *
 * @property int $id
 * @property int $wf_class
 * @property int $initiator
 * @property int $entity_record
 * @property string $entity_type
 * @property string $status
 * @property string $started_at
 * @property string $completed_at
 */
class PayrollRepsApprovalRequestInstances  extends ApprovalWorkflowInstances
{
    
    const ENTITY_TYPE = 'PayrollRepsApprovalRequests';
    
    const TASK_CLASS='frontend\modules\hr\models\PayrollRepsApprovalTaskInstances';
    const CMT_CLASS='frontend\modules\hr\models\PayrollReportsApprovalComments';
    const TASK_SBM_EMAIL='payrollReportsSubmit-html';
    
    public $errors=[];
        
 
   
    public function run(){
      $res=[];
     if($this->isRunning())
     return true;   
     $this->status='running';
     $this->started_at=date('Y-m-d H:i:s');
     
        if(!$this->save(false)){
            
          $res['status']='error';
          $res['error']=$this->getErrors();
          return $res;
          }   
    
     
      $res=$this->createStartTaskInstance();
      return $res; 
   
   
    
    }
   
   protected function createStartTaskInstance(){
    
    $res=[];
    $cxtParams=[];
    $firstStep=$this->firstWaitingStep();
    //----------------------------------------start first step-----------------------
    return $this->activateStep($firstStep);   
   } 
 
   public function completeStep($varMap){
     $res=[];
     $completeStep= ApprovalWorkflowInstanceSteps::findById($varMap['wfStep']);
     if(!$completeStep->isCurrentStep()){
       $res['status']='error';
       $res['error']=sprintf(" Step ( %s) is not Current Step !", $completeStep->name);
       return $res;  
     }
     
     
   
         $res=$completeStep->complete($varMap);
         if($res['status']!='success'){
           return $res;
            }
           
            if($completeStep->is_last_approval)
            {
                
            $this->forceApproval($varMap['outcome']);
         $this->entityRecord->trigger(PayrollRepsApprovalRequests::EVENT_REQUEST_APPROVAL);
           
            }
            
         if($completeStep->isLastStep()  || $varMap['outcome']=='rejected'){
             
            return  $this->complete($varMap['outcome']);   
           }
         
        $nextStep=  $this->nextWaitingStep($completeStep);
        
        return $this->activateStep($nextStep,$varMap['wfStep']);
        
  
       
         
        
      
     }

   public function activateStep($step,...$cxtParams){
    
    $started=$step->start();
    if(!$started){
           $res['status']='error';
           $res['error']=sprintf("Could not start step (%s)",  $step->name);
           return $res;  
        }
    $taskInstance=$step->createTaskInstance(self::TASK_CLASS);
    
    $fromStep=count($cxtParams) > 0 ? $cxtParams[0] : null;
    
    $res=$step->performAssignment($taskInstance,$fromStep);  
    return $res;
       
   }
  
   public function returnForEdit($varMap) {
     $res=[];
     $currentStep=ApprovalWorkflowInstanceSteps::findById($varMap['wfStep']);
     if($currentStep==null){
       $res['status']='error';
       $res['error']=sprintf(" Invalid Current Step Id : ( %s)  !",$varMap['wfStep']);
       return $res;  
     }
     $currentStep->setStatus('change requested');//update user approval status
       
    if($varMap['return_step_id']==0) {
     $updateStep=$this->getUpdateStep();
     if(!$updateStep->start()){
           $res['status']='error';
           $res['error']=sprintf("Could not start step (%s)",  $updateStep->name);
           return $res;  
        }
     return $this->activateStep($updateStep,$varMap['wfStep']);   
     
      }
     $returnStep=ApprovalWorkflowInstanceSteps::findById($varMap['return_step_id']);
    
     $varMap['taskClass']='frontend\modules\hr\models\PayrollRepsApprovalRequestInstances';
     return $returnStep->rollback($varMap);
   }   
     
   
   protected function complete($outcome){
     
    $res=[];   
    $this->status=$outcome;
    $this->completed_at=date('Y-m-d H:i:s');
    if(!$this->save(false)){
        
      $res['status']='error';
      $res['error']=$this->getErrors();
      return $res;
    }
    
    $entityRecord=$this->entityRecord;
    if($entityRecord->status!='approved')
    {
    if($outcome=='approved'){
      $entityRecord->status='approved'; 
    }else if($outcome=='rejected')
    $entityRecord->status='declined';
    
    if(!$entityRecord->save(false)){
        
      $res['status']='error';
      $res['error']=$entityRecord->getErrors();
       return $res;
    }
   
         $entityRecord->trigger(PayrollRepsApprovalRequests::EVENT_REQUEST_APPROVAL); 
    }
    $res['status']='success';
    return $res;
   
   }
   


public function isRunning(){
    
    return $this->status=='running';
}
   
/**
* @return CarQuery
*/
public static function find()
{
return new ApprovalWorkflowInstancesQuery(get_called_class(), ['where' =>
['entity_type' => self::ENTITY_TYPE]]);
}




/**
* @param bool $insert
*
* @return bool
*/
public function beforeSave($insert)
{
$this->entity_type = self::ENTITY_TYPE;
return parent::beforeSave($insert);
}

    public function getEntityRecord()
{
    return $this->hasOne(PayrollRepsApprovalRequests::className(), ['id' =>'entity_record']);
}

  public function getComments()
{
    
    return $this->hasMany(PayrollRepsApprovalComments ::className(),['wfInstance' => 'id'])->orderBy(['timestamp'=>SORT_DESC]) ;
}

public function getTaskClass(){
    
    return self::TASK_CLASS;
}

public function getCMTClass(){
    
    return self::CMT_CLASS;
}

public function getSubEmailTemp(){
    
    return self::TASK_SBM_EMAIL;
}


}

