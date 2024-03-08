<?php

namespace frontend\modules\hr\models;

use Yii;
use yii\helpers\Json;
use common\models\ErpPersonsInPosition;
use common\models\UserHelper;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "approval_Workflow_steps".
 *
 * @property int $id
 * @property string $name
 * @property int $number
 * @property int $active
 */
class ApprovalWorkflowSteps extends \yii\db\ActiveRecord
{
    
    public $assignmentModel;
    public $conditionModel;
    public $outcomes;
   
 
 
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'approval_workflow_steps';
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
            [['name','task_type', 'number','assignment_type','wf_def','user'], 'required'],
            [['number','wf_def', 'active','user'], 'integer'],
            
            [['name'], 'string', 'max' => 255],
            [['description','assignment_type','task_name','task_type','task_desc','task_actions'], 'string'],
            [['timestamp','outcomes'], 'safe'],
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
            'type'=>'Step Type',
            'number' => 'number',
            'active' => 'Active',
            'outcomes'=>'Actions'
        ];
    }
    
    //-------called after construct--initialized-----------------   
    public function init()
{

$this->assignmentModel = new StepAssignmentModel();
$this->conditionModel = new ApprovalCondModel();

parent::init();

}


public function initDefaultValues(){
    
    $this->initWorkflow();
    $this->initNumber();
    
}

public function initWorkflow(){

$wfId=ArrayHelper::getValue($_GET, 'wfId');

if($wfId !=null)

$this->wf_def=$wfId;


}
 public  function initNumber(){

$lastStep=$this->wfDef->lastStep();

if($lastStep !=null) 
    
$this->number= $lastStep->number+1;    

else

$this->number= 1;     
    
  
}   

public  function initAssignmentType(){

if($this->is_json($this->assignment_type )){
   $jsondata = Json::decode($this->assignment_type );
$this->assignmentModel->setAttributes($jsondata); 
}


}

public function initActions(){
if($this->is_json($this->task_actions))
 $this->outcomes=Json::decode( $this->task_actions ); 
}


public  function initCondition(){
if($this->is_json($this->conditions )){
    
    $jsondata = Json::decode( $this->conditions );
$this->conditionModel->setAttributes($jsondata );
}

}


   public function getWfDef()
{
    return $this->hasOne(ApprovalWorkflows::className(), ['id' => 'wf_def']);
}

public function getTaskActions(){
 
 $codes=Json::decode( $this->task_actions );  
 return ApprovalWorkflowActions::find()->where(['in', 'code', $codes])->orderBy(['display_order' => SORT_DESC])->all();
    
}

public function getAssignmentType(){
$this->initAssignmentType();
return $this->assignmentModel;
    
}

function is_json($string,$return_data = false) {
	  $data = json_decode($string);
     return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
}

}
