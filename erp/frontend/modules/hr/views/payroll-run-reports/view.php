<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\tabs\TabsX;

use frontend\assets\TimeLineAsset;
TimeLineAsset::register($this); 
use common\models\Status;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayrollApprovalRequests */

$this->title = $model->rpt_desc;
$this->params['breadcrumbs'][] = ['label' => 'Payroll Run Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?php
 if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
   

  
?>

<div class="card">
          <?php if($model->status=='draft') :?>              
     <div class="tool-bar d-flex justify-content-end  mt-3">
               
    <a href="<?=Url::to(['payroll-approval-reports/start-approval','id'=>$model->id]) ?>" class="btn btn-sm btn-info mr-2 start-approval" title="Submit For Approval">Submit For Approval</a>
              </div> 
              
        <?php else: ?> 
        
        <?php endif;?>
                        <div class="card-body">
    <?=$content?>
    </div>
 

  
 
    </div>
        </div>
        </div>

          <?php
      
function getInitial($name){
    
   preg_match('/(?:\w+\. )?(\w+).*?(\w+)(?: \w+\.)?$/', $name, $result);
    return strtoupper($result[1][0]);
}          

$url=Url::to(['payroll-approval-requests/start-approval','id'=>$model->id]); 
$approval_status=$model->status;
$script = <<< JS


var approval_status='{$approval_status}';


 $( document ).ready(function($){

          
 (function(){
   var total='{$totSteps}';
   var completed='{$completed}';
   var percent = (completed/total) * 100;
   $('.progress-bar').css('width', percent+'%').attr('aria-valuenow', percent);   
   
    
   })();
 
 
 $('.tool-bar').on('click', '.start-approval', function () {
   
var url =$(this).attr('href');
  
$('#modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('#modal-action .modal-title').text($(this).attr('title')); 
return false;
 
});



 $('.card-footer').on('click', '.view-workflow-status', function () {
   
var url =$(this).attr('href');
  
$('#modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('#modal-action .modal-title').text($(this).attr('title')); 
return false;
 
});
           
        });
JS;
$this->registerJs($script,$this::POS_END);
?>
