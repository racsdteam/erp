<?php

namespace frontend\modules\hr\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "payroll_reps_approval_task_instances".
 *
 * @property int $id
 * @property int $wfInstance
 * @property int $wfStep
 * @property int $request
 * @property string $name
 * @property string $description
 * @property int $assigned_to actual assignee
 * @property int $on_behalf_of
 * @property int $assigned_from
 * @property string $action_required
 * @property string $outcome
 * @property string $status
 * @property int $is_new
 * @property string $created_at
 * @property string $started_at
 * @property string $completed_at
 */
class PayrollRepsApprovalTaskInstances extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_reps_approval_task_instances';
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
            [['wfInstance', 'wfStep', 'request'], 'required'],
            [['wfInstance', 'wfStep', 'request', 'assigned_to', 'on_behalf_of', 'assigned_from', 'is_new'], 'integer'],
            [['description', 'action_required', 'outcome', 'status'], 'string'],
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
            'wfInstance' => 'Wf Instance',
            'wfStep' => 'Wf Step',
            'request' => 'Request',
            'name' => 'Name',
            'description' => 'Description',
            'assigned_to' => 'Assigned To',
            'on_behalf_of' => 'On Behalf Of',
            'assigned_from' => 'Assigned From',
            'action_required' => 'Action Required',
            'outcome' => 'Outcome',
            'status' => 'Status',
            'is_new' => 'Is New',
            'created_at' => 'Created At',
            'started_at' => 'Started At',
            'completed_at' => 'Completed At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PayrollApprovalTaskInstancesQuery the active query used by this AR class.
     */
public static function find()
    {
        return new PayrollRepsApprovalTaskInstancesQuery(get_called_class());
    }
     public function getApprovalRequest()
{
    return $this->hasOne(PayrollRepsApprovalRequests::className(), ['id' => 'request']);
}
   public function getWfStep()
{
    return $this->hasOne(ApprovalWorkflowInstanceSteps::className(), ['id' => 'wfStep']);
}

 public function getWfStep0()
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
    return PayrollRepsApprovalComments::find(['user' =>$this->assigned_to])->andwhere(['wfStep'=>$this->wfStep])->one();  
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
             
            $c=new PayrollRepsApprovalComments();
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
