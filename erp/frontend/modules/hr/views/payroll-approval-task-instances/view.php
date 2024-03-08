<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use frontend\modules\hr\models\ApprovalWorkflowActions;
use frontend\modules\hr\models\Payrolls;
use frontend\modules\hr\models\PayrollChanges;
use common\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveApprovalTasks */

$this->title =$model->wfStep->name;

\yii\web\YiiAsset::register($this);
?>

<style>
    
 div.action-bar{
     
  
   position: -webkit-sticky; /* Safari */
  position: sticky;
  top: 0;
  z-index:1000;
 }   
</style>
<div class="payroll-approval-task-instances-view">
  <?php
$user=Yii::$app->user->identity;;

$current_step= $model->wfInst->getCurrentStep();
if($current_step!=null && ($model->assigned_to==$user->user_id || $user->isAdmin())):
$actions=$current_step->getTaskActions($model->action_required);


?>   
    <div class="row mb-2 action-bar ">
                <div class="col-12 pr-3">
                  <?php  foreach($actions as $action): $html=$action->getHtmlAttributes();?>
       <button class='btn <?php echo $html['btnClass'] ?> float-right action' id="<?= $action->code ?>" 
       data-action="<?php echo htmlspecialchars(json_encode($action->attributes)) ?>" 
       data-url="<?= Url::to(["payroll-approval-task-instances/complete"])?>" style="margin-right: 5px;">
           <?php echo $html['icon']?> <?= $action->name ?></button>
       <?php endforeach; ?>
                
               
                </div>
              </div>
 <?php
endif;
?>  

    <?php
    $request=$model->approvalRequest;
    if($request->isSALApproval()){
           
           $appEntity=\yii\helpers\ArrayHelper::filter($request->getPayrolls(), [0]);
           if(($changes=PayrollChanges::findByPayPeriod($request->pay_period_year,$request->pay_period_month))!=null){
            $content1=$this->render('@frontend/modules/hr/views/payroll-changes/pdf',["model"=>$changes,'wf'=>$wf]);
           }else{
             
             $content1=$this->render($appEntity[0]->views['pdf'], [
            'model' =>$appEntity[0],'approval_id'=>$request->id,'wf'=>$wf
        ]);  
               
           }
          }
          
      else if($request->isDCApproval()){
        $appEntity=\yii\helpers\ArrayHelper::filter($request->getReports(), [0]);   
        $content1=$this->render($appEntity[0]->views['pdf'], [
            'model' =>$appEntity[0],'approval_id'=>$request->id,'wf'=>$wf
        ]);   
      } 
    echo  $this->render('@frontend/modules/hr/views/payroll-approval-requests/view',['model' => $request,'content1'=>$content1]);   
      
   
    
    
    ?>
    


</div>
<?php

$content='';
$taskType=json_encode($current_step->task_type);
$isFinal=json_encode(false);

if(!$current_step->isLastStep()){
 $nextStep=$model->wfInst->nextWaitingStep($current_step);
 if($nextStep->isLastStep()) {
     
  $content='Final Approval : '.$nextStep->name; 

    }  
   else{
       
  $content=$nextStep->name;     
   }
   
  
}else{
   $isFinal=json_encode(true); 
}

$users=ArrayHelper::map(User::find()->all(), 'user_id', function($model){
    
     return $model->first_name.' '.$model->last_name;  
});

  $stepList=ArrayHelper::map($model->wfInst->completedSteps,'id',function($step){
  $actor=$step->completedByUser;
   return $actor !=null? $actor->first_name.' '.$actor->last_name: ' ';
    
});

//--------------------------include workflow initiator---------------------------------
$wfInitiator=$model->wfInst->wfInitiator;
$stepList[0]=$wfInitiator->first_name.' '.$wfInitiator->last_name;

$reassignUsers=json_encode( $users);
$returnToSteps=json_encode(  $stepList);

$approvalConfirmUrl=Url::to(['payroll-approval-requests/confirm-approval']);
$requestId=$request->id;
$actorId=Yii::$app->user->identity->user_id;
$script = <<< JS

$( document ).ready(function($){

var isFinal=$isFinal;
var taskType=$taskType;


 
 $('.action').on('click',async function(){
   
   //---------check if approval step and approver has signed all documents--------------
   
   
   if(taskType=='Approval'){
   
   var res=await confirmApproval($requestId,$actorId);
   if(res.status!=='success'){
       
      Swal.fire({
  title: '<strong>'+res.data.msg+'</strong>',
  icon: 'warning',
  html:res.data.content,
  
  
})
      
      return;
   }
            
          
   }
     
   const url=$(this).attr('data-url');
   const action = JSON .parse($(this).attr('data-action'));
   var config={};
   //---------------common configs-----------------------
   config.title = action.name ;
   config.focusConfirm=false;
   config.confirmButtonText=action.name;
   config.cancelButtonText= 'Cancel';
   config.showCancelButton=true;
   var html='';
   var title='';
   var ids=[];
   
   switch(action.code){
       case 'APRV':
       case 'REV':
       
        config.confirmButtonColor='#28A745'; 
        if(!isFinal)    
         html+='<span style="font-size:16px;" class="text-blue"><i class="fas fa-long-arrow-alt-right"></i> {$content}</span>';
         html+= '<textarea autofocus aria-label="Write comment if required..."  placeholder="Write comment if required... " \\
                 class="swal2-textarea" id="swal2-textarea" style="display: flex;"></textarea>';
        config.html=html;         
        ids.push({'name':'comment','id':'swal2-textarea'}) ;     
                 break;
            case 'VF':
       
        config.confirmButtonColor='#28A745'; 
        if(!isFinal)    
         html+='<span style="font-size:16px;" class="text-blue"><i class="fas fa-long-arrow-alt-right"></i> {$content}</span>';
         html+= '<textarea autofocus aria-label="Write comment if required..."  placeholder="Write comment if required... " \\
                 class="swal2-textarea" id="swal2-textarea" style="display: flex;"></textarea>';
        config.html=html;         
        ids.push({'name':'comment','id':'swal2-textarea'}) ;     
                 break;
                     case 'CTF':
       
        config.confirmButtonColor='#28A745'; 
        if(!isFinal)    
         html+='<span style="font-size:16px;" class="text-blue"><i class="fas fa-long-arrow-alt-right"></i> {$content}</span>';
         html+= '<textarea autofocus aria-label="Write comment if required..."  placeholder="Write comment if required... " \\
                 class="swal2-textarea" id="swal2-textarea" style="display: flex;"></textarea>';
        config.html=html;         
        ids.push({'name':'comment','id':'swal2-textarea'}) ;     
                 break;
   case 'RET':
       
    var arrSteps=$returnToSteps; 
    var options = "";
    var optionTag1="<option  disabled selected>" + ' Send Back To' + "</option>";
     options = options.concat(optionTag1);
     $.each(arrSteps,function(key,value){
    
     var optionTag = "<option value=\"" +key + "\">" + value + "</option>";
      options = options.concat(optionTag);
});
     html+='<span class="text-warning"><i class="fas fa-undo"></i>  The request will be returned for Edit !</span>';
     html+= '<select id ="swal2-select" class="swal2-select" style="display: flex;width:100%">'+ options +'</select>';
     html+= '<textarea autofocus aria-label="Type the reason for returning back..."  placeholder="Type the reason for returning back... " \\
                 class="swal2-textarea" id="swal2-textarea" style="display: flex;"></textarea>';
   config.html=html;             
   config.confirmButtonColor='#FFC107'; 
   ids.push({'name':'return_step_id','id':'swal2-select'}) ; 
   ids.push({'name':'reason','id':'swal2-textarea'}) ; 
   
       break;
   case 'RJT':
    config.confirmButtonColor='#d33'; 
     html+='<span class="text-red"><i class="fas fa-exclamation-triangle"></i> The request will be rejected !</span>'; 
     html+= '<textarea autofocus aria-label="Type the reason for rejection..."  placeholder="Type the reason for rejection... " \\
               class="swal2-textarea" id="swal2-textarea" style="display: flex;"></textarea>';
    config.html=html;           
    ids.push({'name':'reason','id':'swal2-textarea'}) ;  
    break;
    
    case 'RASS':
    var arrUsers=$reassignUsers; 
    var options = "";
    var optionTag1="<option  disabled selected>" + ' Reassign  To' + "</option>";
     options = options.concat(optionTag1);
     $.each(arrUsers,function(key,value){
    
     var optionTag = "<option value=\"" +key + "\">" + value + "</option>";
      options = options.concat(optionTag);
});
        html+='<span class="text-warning"><i class="fas fa-share"></i> The request will be reassigned !</span>';
        html+= '<select id ="swal2-select" class="swal2-select" style="display: flex;width:100%">'+ options +'</select>';
        html+= '<textarea autofocus aria-label="Type the reason for reassign..."  placeholder="Type the reason for reassign... " \\
               class="swal2-textarea" id="swal2-textarea" style="display: flex;"></textarea>';
       config.html=html;
     
     ids.push({'name':'user_id','id':'swal2-select'}) ; 
     ids.push({'name':'reason','id':'swal2-textarea'}) ;   
      
        break;
    
     case 'ARC':
       
        config.confirmButtonColor='#28A745'; 
        if(!isFinal)    
         title+='Do you want to Archive It?';
         config.title=title;         
           
                 break;    
        
   default:
   config.confirmButtonColor='#3085d6';     
       
   }
   config.preConfirm = () => {
   var formValues={};
   $.each(ids, function(key, item){
        formValues[item.name]=document.getElementById(item.id).value;
       
           
        });
if(action.code==='RFE' && (!formValues.return_step_id || !formValues.reason)){
     
      Swal.showValidationMessage('Please select send back to and write reason for sending back !')
 } 
 if(action.code==='RJT' && (!formValues.reason)){

      Swal.showValidationMessage('Please write reason for rejection !')
 }
 
 if(action.code==='RASS' && (!formValues.user_id || !formValues.reason)){
     
      Swal.showValidationMessage('Please select reassign to and write reason for reassigning !')
 }
    return formValues
  }
  const { value: formValues }= await Swal.fire(config);
  
  if (formValues){
      
      formValues.requestId=$model->id;
      formValues.action=action.code;
   
    
 $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data:  formValues
            })
            .done(function(res) {
               
               if(res.status=='success'){
                   
                  Swal.fire({
  position: 'center',
  icon: 'success',
  title: 'Action Completed Successfully !',
  showConfirmButton:true,
  timer: 9000
}) 
window.history.back();
                 }else{
                     
                   Swal.fire({
  position: 'center',
  icon: 'error',
  text:res.error,
  showConfirmButton:true,
  timer: 9000
})                 
                 }
            })
            .fail(function(xhr, status, error) {
                 var errorMessage = xhr.status + ': ' + xhr.statusText;
                 console.log(errorMessage);
            });  
        
   
  }

 
 });  
 

function confirmApproval(requestId,actorId){
    
     return new Promise((resolve, reject) => {
 
      $.ajax({
                url: '{$approvalConfirmUrl}',
                type: 'get',
                dataType: 'json',
                data: {requestId:requestId ,actorId:actorId}
            })
            .done(function(res) {
               
               resolve(res);
             
            })
            .fail(function(xhr, status, error) {
                 var errorMessage = xhr.status + ': ' + xhr.statusText;
                 reject(errorMessage );
            }); 
  })
}
 
 
        });
JS;
$this->registerJs($script,$this::POS_END);
?>