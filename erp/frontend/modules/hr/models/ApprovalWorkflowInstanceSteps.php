<?php

namespace frontend\modules\hr\models;

use Yii;
use common\models\user;
use common\models\UserHelper;
use common\models\ErpOrgPositions;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

date_default_timezone_set('Africa/Cairo');
/**
 * This is the model class for table "approval_workflow_instance_steps".
 *
 * @property int $id
 * @property int $stepNode
 * @property int $wfInstance
 * @property string $name
 * @property string $task_type
 * @property string $description
 * @property int $number
 * @property int $assignedTo defined in wf definition
 * @property int $assignedTo_orgUnit
 * @property int $assignedTo_position
 * @property string $status
 * @property string $result
 * @property int $completedBy
 * @property int $completedBy_orgUnit
 * @property int $completedBy_position
 * @property string $created
 * @property string $started_at
 * @property string $completed_at
 */
class ApprovalWorkflowInstanceSteps extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'approval_workflow_instance_steps';
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
            [['stepNode', 'wfInstance', 'name', 'task_type', 'number', 'assignedTo'], 'required'],
            [['stepNode', 'wfInstance', 'number', 'assignedTo','is_last_approval', 'assignedTo_orgUnit', 'assignedTo_position', 'completedBy', 'completedBy_orgUnit', 'completedBy_position'], 'integer'],
            [['description', 'status','task_actions'], 'string'],
            [['created', 'started_at', 'completed_at'], 'safe'],
            [['name', 'task_type'], 'string', 'max' => 255],
            [['isComplete'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stepNode' => 'Step Node',
            'wfInstance' => 'Wf Instance',
            'name' => 'Name',
            'task_type' => 'Task Type',
            'description' => 'Description',
            'number' => 'Number',
            'assignedTo' => 'Assigned To',
            'assignedTo_orgUnit' => 'Assigned To Org Unit',
            'assignedTo_position' => 'Assigned To Position',
            'status' => 'Status',
            'isComplete' => 'IsComplete',
            'completedBy' => 'Completed By',
            'completedBy_orgUnit' => 'Completed By Org Unit',
            'completedBy_position' => 'Completed By Position',
            'created' => 'Created',
            'started_at' => 'Started At',
            'is_last_approval' => "Last Approval",
            'completed_at' => 'Completed At',
        ];
    }
    
public function getWfStepNode(){
    
 return $this->hasOne(ApprovalWorkflowSteps::class, ['id' => 'stepNode']); 
       
   }
   
   public function getWfInst(){
    
     return $this->hasOne(ApprovalWorkflowInstances::class, ['id' => 'wfInstance']); 
       
   }
   
    public function getAssignedToUser(){
    
     return $this->hasOne(User::class, ['user_id' => 'assignedTo']); 
       
   }
   
   public function getAssignedToPosition(){
    
     return $this->hasOne(ErpOrgPositions::class, ['id' => 'assignedTo_position']); 
       
   }
   
    public function getCompletedByUser(){
    
     return $this->hasOne(User::class, ['user_id' => 'completedBy']); 
       
   }
   
   public function getCompletedByPosition(){
    
     return $this->hasOne(ErpOrgPositions::class, ['id' => 'completedBy_position']); 
       
   }
   public function isLastStep(){
       
       return $this->number==$this->wfInst->getLastStep()->number;
   }
   
    public function isCurrentStep(){
       
       return $this->number==$this->wfInst->getCurrentStep()->number;
   }

   
      public function getTaskActions($action){
 if($action=='FYI'){
 
  $codes=ApprovalWorkflowActions::ARC_CODE;   
     
 }else{
     
    $codes=Json::decode( $this->task_actions );    
  }

  return ApprovalWorkflowActions::find()->where(['in', 'code', $codes])->orderBy(['display_order' => SORT_DESC])->all();
    
}

 
 public function getDependentTasks($taskClass){
 
  return $taskClass::find()->where(['wfStep' =>$this->id])->orderBy(['created_at' => SORT_DESC])->all();
    
}


   
   public function start(){
         $this->status='started';
         $this->started_at=date('Y-m-d H:i:s');
         return   $this->save(false);
   }
   
   public function rollback($varMap){
     
       //---------reset step----------------
       $this->started_at=date('Y-m-d H:i:s');
       $this->completed=null;
       $this->result='pending';
       $this->completedBy=null;
       $this->completedBy=null;
       $this->completedBy_position=null;
       $this->save(false);
     // -------------reset assigned user task created for this step------------------
    $dependentTasks=$this->getDependentTasks($varMap['taskClass']) ;
    if(!empty($dependentTasks)){
        foreach($dependentTasks as $task){
            $task->rollback();
        }
    }
     
   }
   public function setStatus($status){
          $res=[];
          $this->status=$status;
        if(! $this->save(false)){
            $res['status']='error';
            $res['error']= $this->getErrors();
            return $res;
            }   
        $res['status']='success';
        return $res;
   }
   public function complete($varMap){
         $res=[];
         
         $this->isComplete=true;
         $this->status=$varMap['outcome'];
         $this->completed_at=date('Y-m-d H:i:s');
         $this->completedBy=$varMap['completed_by'];
         $this->completedBy_orgUnit=\common\models\UserHelper::getOrgUnit($varMap['completed_by'])->id;
         $this->completedBy_position=\common\models\UserHelper::getPosition($varMap['completed_by'])->id;
         if(!$this->save(false)){
            $res['status']='error';
            $res['error']=$this->getErrors();
            return $res;
            }
            
            $res['status']='success';
            return $res;
   }
 public function createTaskInstance($taskClass){
     $res=[];
    
     if($taskClass==null){
        $res['status']='error';
        $res['error']='Invalid Task Class';
        return $res;
     }
     
     $taskInstance=new  $taskClass();
     $taskInstance->name=$this->wfStepNode->task_name;
     $taskInstance->description=$this->wfStepNode->task_desc;
     $taskInstance->action_required=$this->wfStepNode->task_type;
     $taskInstance->wfInstance=$this->wfInst->id;
     $taskInstance->wfStep=$this->id;
     $taskInstance->request=$this->wfInst->entity_record;
     return   $taskInstance->save() ?  $taskInstance : null;
      
      
  }
 
 public function getTaskInstances($taskClass){
  
   return $taskClass::find()->where(['wfStep'=>$this->id])->all();  
      
  }
 
 public function performAssignment($taskInstance,...$cxtParams){
    
    $res=[];
    $errors=[];
    $toCopy=[];
    $tasks=[];
   
     
    if($taskInstance==null){
      $res['status']='error';
      $res['error']=sprintf("Could not create task for  step (%s)",   $this->name);
      return $res;   
    }
    
    if($this->assignedTo==null){
              $res['status']='error';
              $res['error']=sprintf("Invalid assigned user : leave approval instance( %s) step (%s)",$this->wfInst->wf_name, $this->name);
              return $res;
      }
      
      //------------set default assignment------------------------------
     $assignedTo=$this->assignedTo;
     
      //------------------------------------------------------find interim--------------------------------
      $interim=$this->assignedToUser->findInterim();
      if($interim!=null){
      
      $assignedTo=$interim->person_in_interim;
      $taskInstance->on_behalf_of=$this->assignedTo;
      $toCopy[]=$this->assignedTo;
          
      }
      
    //-------------------------------------find PA--------------------------------------------------------------  
      $pa=$this->assignedToPosition->getPA();
      
      if($pa!=null){
      
       $_pa=UserHelper::findUserByPosition($pa->id);
       if($_pa!=null){
       $futureApproval=$this->findFutureApproval($_pa); 
       if(empty($futureApproval))
       $toCopy[]=$_pa;
          
       }
       
       }
      $taskInstance->assigned_to=$assignedTo;
      $taskInstance->assigned_from=count($cxtParams) > 0 ? $cxtParams[0] : null;
      $taskInstance->save(false);
      $tasks[]=$taskInstance; 
      
     
      if(!empty( $toCopy)){
      foreach($toCopy as $key=>$_user){
      $copy = clone $taskInstance;
      $copy->isNewRecord = true;
      $copy->id=null;
      $copy->assigned_to=$_user; 
      $copy->action_required='FYI';
      if(!$copy->save(false)){
          $errors[]=$copy->getErrors();
              break;
        }
     $tasks[]=$copy;    
      }
      
 }
   
   if(!empty($errors))
   {
     $res['status']='error'; 
     $res['error']=$errors[0];
     return $res;
       
   }
     
//------------notify---------------------------------- 
foreach($tasks as $task){
    
    $this->createNotification($task);
    
}
         $res['status']='success';
         return $res;
     
 }
 
public function findFutureApproval($assignee){
    
    self::find()->where(['assignedTo'=>$assignee])->andwhere(['<>','task_type','FYI'])->One();
} 


public function createNotification($task){

$assignee=$task->assignedTo;
$flag= Yii::$app->mailer->compose( ['html' =>$this->wfInst::TASK_SBM_EMAIL],
    [
        'task'=>$task
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$assignee->email=>$assignee->first_name.' '.$assignee->last_name])
->setSubject('ERP Notification')
//->setTextBody('You Can Change Login Password After Sign in')
->send();

return $flag;   
    
    
}
public static function findById($id){
    
 return self::findOne($id);    
}
  
}
