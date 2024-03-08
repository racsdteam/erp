<?php
namespace common\components;


use Yii;
use yii\base\Component;
use yii\data\ActiveDataProvider;
use common\models\ErpOrgUnits;
use common\models\ ErpOrgPositions;
use common\models\ErpPersonsInPosition;
use frontend\modules\hr\models\EmpEmployement;
use frontend\modules\hr\models\Employees;
use frontend\modules\hr\models\ApprovalWorkflows;
use frontend\modules\hr\models\ApprovalProcessSteps;
use frontend\modules\hr\models\ApprovalWorkflowInstances;
use frontend\modules\hr\models\ApprovalProcessInstanceSteps;
use frontend\modules\hr\models\ApprovalProcessResult;
use frontend\modules\hr\models\LeaveApprovalFlowInstances;
use frontend\modules\hr\models\LeaveApprovalComments;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

date_default_timezone_set('Africa/Cairo');

class WorkFlowManager extends Component {
private const LEAVE_INST_CLASS='frontend\modules\hr\models\LeaveApprovalInstances';
private const PAYROLL_APPROVAL_INST_CLASS='frontend\modules\hr\models\PayrollApprovalRequestInstances';
 
public function getWorkflowModel($entityRecord,$requester){
 
 $res=new ApprovalProcessResult(); 
 $errors=[];
 
  $mWfModel=$this->findWorkflowModel($entityRecord,$requester) ;

  return $mWfModel;       
}



protected function findWorkflowModel($entityRecord,$requester){


$models=ApprovalWorkflows::find()->alias('wf')
                        ->select('wf.*')
                        ->innerJoin('comp_business_entities as entity', 'entity.id = wf.entity_type')
                        ->andWhere(['entity.name'=>$entityRecord->formName()])
                        ->orderBy(['wf.priority' => SORT_ASC])
                        ->all();
   if(empty($models)) {
       
       return null; 
     }
    
  
   
   $mWfModel=null;
   
 if(count($models)>1){
    
    foreach($models as $wfModel){
      
      if($wfModel->matchCond($entityRecord,$requester)){
           $mWfModel=$wfModel;
           break;
          
      }
      
    }  
     
 }else{
     
   
  if($models[0]->enable_condition && $models[0]->matchCond($entityRecord,$requester)){
     
    $mWfModel=$models[0];
     
          
     }else{
         
        $mWfModel= $models[0];  
     }  
     
 }
 
 
   
                      

return $mWfModel;
    
    
}


 
public function createWorkflowInstance($request){


$instanceModel=$this->findWorkFlow($request->entityRecord);
if( $instanceModel==null){
      
      $className=$this->findWFClassByEntity($request->entityRecord);
     
      $instanceModel=new $className();
      $instanceModel->wf_name=strtolower($request->entityRecord->formName().'_'.$request->entityRecord->id.'_'.$request->initiator);
      $instanceModel->wf_def=$request->wf;
      $instanceModel->entity_record=$request->entityRecord->id;
      $instanceModel->entity_type= $request->entityRecord->formName();
      $instanceModel->initiator= $request->initiator;
      $instanceModel->save();
     
          }
 
   if($instanceModel!=null){
       
     //------------create wf instance steps-----------------------------
     
     $res= $instanceModel->createStepInstances();  
     
     if($res['status']!='success'){
         
        var_dump("Error initiating approvals!");die();  
     }
    
    
    if(!empty($request->comment))
    {
          $cmtClass=$instanceModel::CMT_CLASS;
          $c=new $cmtClass();
          $c->wfInstance=$instanceModel->id;
          $c->comment=$request->comment;
          $c->user=$request->initiator;
          $c->request=$request->entityRecord->id;
          $c->scope='W';
          $c->save();
    } 
   }
    
   
   return  $instanceModel;
   
    
} 


public  function findWorkFlow($entityRecord){
   
$className=self::findWFClassByEntity($entityRecord); 
$instanceModel=$className::find()->where(['entity_type'=>$entityRecord->formName(),'entity_record'=>$entityRecord->id])->One();
return $instanceModel;
    
}


public  function findWFClassByEntity($entityRecord){
    
 return ApprovalWorkflowInstances::INST_CLASS_MAP[$entityRecord->formName()];   
}




 } 



?>