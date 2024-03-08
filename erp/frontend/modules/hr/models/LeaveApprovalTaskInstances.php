<?php

namespace frontend\modules\hr\models;


use Yii;
use common\models\User;

/**
 * This is the model class for table "leave_approval_task_instances".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $wfInstance
 * @property int $wfStep
 * @property int $number
 * @property int $assigned_to defined in wf definition
 * @property int $on_behalf_of completed by
 * @property string $outcome
 * @property int $org_unit
 * @property int $position
 * @property string $status
 * @property string $created_at
 * @property string $started_at
 * @property string $completed_at
 */
class LeaveApprovalTaskInstances extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leave_approval_task_instances';
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
            [['description', 'outcome', 'status','action_required'], 'string'],
            [['wfInstance', 'wfStep', 'request'], 'required'],
            [['wfInstance', 'wfStep', 'request', 'assigned_to', 'on_behalf_of'], 'integer'],
            [['created_at', 'started_at', 'completed_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
           
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
            'description' => 'Description',
            'wfInstance' => 'Wf Instance',
            'wfStep' => 'Parent Step',
            'assigned_to' => 'Assigned To',
            'on_behalf_of' => 'Original Assigned To',
            'outcome' => 'Outcome',
             'status' => 'Status',
            'created_at' => 'Created At',
            'started_at' => 'Started At',
            'completed_at' => 'Completed At',
        ];
    }
    
     public function getLeaveRequest()
{
    return $this->hasOne(LeaveRequest::className(), ['id' => 'request']);
}
   public function getWfStep()
{
    return $this->hasOne(ApprovalWorkflowInstanceSteps::className(), ['id' => 'wfStep']);
}

   public function getWfInst()
{
    return $this->hasOne(ApprovalWorkflowInstances::className(), ['id' => 'wfInstance']);
}
  public function getAssignedTo()
{
    return $this->hasOne(User ::className(), ['user_id' => 'assigned_to']);
} 
  public function getDelegator()
{
    return $this->hasOne(User ::className(), ['user_id' => 'on_behalf_of']);
}

 public function getComment()
{
    return LeaveApprovalComments::find(['user' =>$this->assigned_to])->andwhere(['wfStep'=>$this->wfStep])->one();  
} 

 public function complete($varMap){
                $res=[];
                $this->status='completed';
                $this->outcome=$varMap['outcome'];
                $this->completed_at=date('Y-m-d H:i:s');
               if(!$this->save(false)){
                  $res['status']='error';
                  $res['error']=$this->getErrors();
                  return $res;
                   
               }
           
             $commentORreason=($varMap['action']==ApprovalWorkflowActions::RET_CODE || $varMap['action']==ApprovalWorkflowActions::RJT_CODE 
             || $varMap['action']==ApprovalWorkflowActions::RASS_CODE)? $varMap['reason']: $varMap['comment']; 
                  if($commentORreason!=null){
             
            $c=new LeaveApprovalComments();
            $c->wfInstance=$this->wfInstance;
            $c->request=$this->request;
            $c->user=$varMap['completed_by'];
            $c->comment=$commentORreason;
            $c->scope='T';
            $c->wfStep=$this->wfStep;
            if(!$c->save(false)){
            $res['status']='error';
            $res['error']=$c->getErrors();
            return $res;
            }
         }  
         
               $res['status']='success';
               return $res;
    }

public function rollback(){
    
       //---------reset step----------------
       $this->created_at=date('Y-m-d H:i:s');
       $this->is_new=1;
       $this->started_at=null;
       $this->completed=null;
       $this->outcome=null;
       $this->status='pending';
       return $this->save(false);
}

public function isComplete(){
    
    return $this->status=='completed';
}

}
