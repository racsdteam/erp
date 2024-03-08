<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use frontend\modules\hr\models\ApprovalWorkflowActions;
use common\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveApprovalTasks */

$this->title =$model->wfStep->name;
$this->params['breadcrumbs'][] = ['label' => 'Leave Approval Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
<div class="leave-approval-tasks-view">
  <?php
$user=Yii::$app->user->identity;;
$approvable=$model->leaveRequest;
$current_step= $model->wfInst->getCurrentStep();

if($current_step!=null && ($model->assigned_to==$user->user_id || $user->isAdmin())):
$actions=$current_step->getTaskActions();


?>   
    <div class="row mb-2 action-bar ">
                <div class="col-12 pr-3">
                  <?php  foreach($actions as $action): $html=$action->getHtmlAttributes();?>
       <button class='btn <?php echo $html['btnClass'] ?> float-right action' id="<?= $action->code ?>" 
       data-action="<?php echo htmlspecialchars(json_encode($action->attributes)) ?>" 
       data-url="<?= Url::to(["leave-approval-task-instances/complete"])?>" style="margin-right: 5px;">
           <?php echo $html['icon']?> <?= $action->name ?></button>
       <?php endforeach; ?>
                
               
                </div>
              </div>
 <?php
endif;
?>  

    <?php
    
  $content1=$this->render($approvable->view($approvable->className()::VIEW_TYPE_PDF), [
            'model' =>$approvable,
        ]);  
  echo  $this->render($approvable->view($approvable->className()::VIEW_TYPE_VIEWER),['model' =>$approvable,'content1'=>$content1]); 
    
    
    ?>
    


</div>
<?php

$content='';
$isFinal=json_encode(false);
if($current_step!=null && !$current_step->isLastStep()){
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

$script = <<< JS

$( document ).ready(function($){

var isFinal=$isFinal;

 
 $('.action').on('click',async function(){
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
               console.log(res);
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
 

 
 
        });
JS;
$this->registerJs($script,$this::POS_END);
?>