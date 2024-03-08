<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\UserHelper;
use frontend\modules\hr\models\LeaveCategory;
use frontend\modules\hr\models\LeaveRequest;

use yii\db\Query;

?>
<style>

</style>




<?php  
 
 
  $wfModel=Yii::$app->wfManager->getWorkflowModel($model,$model->user);
  if($wfModel!=null)
  $steps=$wfModel->wfSteps;
  
  
 
?>
  
 <div class="card card-warning text-dark ">
        
       
               
           <div class="card-body">
               
               <?php if($wfModel!=null && !empty($steps))  : ?>
       
       <div class="callout callout-warning">
                  <h5><i class="fas fa-people-arrows"></i> Payrolls will be submitted to the following Reviewers/Approvers :  </h5>

                    <div class="d-flex flex-column">
                    <?php  $i=1; $size=count($steps);foreach($steps as $step) : ?>
  <div class="text-blue btn btn-block bg-info btn-sm"><?=$step->name?></div>
  <?php echo  $i < $size ? '<span class="text-center"><i class="fas fa-long-arrow-alt-down text-info"></i></span>' :''; $i++; ?>

           <?php endforeach ;?>
           </div>
           
           <?php endif;?>
           
                </div>        
             
               
    
  <?php
    
   
    $form = ActiveForm::begin([
        'id'=>'action-form1', 
    'options' => [
	//	'class' => 'radio',
		
	],
       ]);
?>
<?=$form->field($approvalRequest, 'wf')->hiddenInput(['value'=> $wfModel->id])->label(false)?>
<?= $form->field($approvalRequest, 'comment')->textarea(['rows' => '4','placeholder'=>'Optional comment...'])->label("Comment") ?>
 
<?= Html::submitButton('<i class="fas fa-share"></i> Submit ', ['class' => 'btn bg-warning  text-light ']) ?>


<?php
   ActiveForm::end();

 ?>
</div>                       
  
  
 
              </div>

 




          <?php



$script = <<< JS


 
 $(document).ready(function(){
    
 /*$('#work-form1').on('beforeSubmit', function (e) {
    
   
});
 */
               
var oTable= $('#tbl').dataTable({
      destroy:true,
      ordering: false,
      lengthChange: false,
      info: false,
      searching: false,
      paging: false,
          
          }); 
 
 });
 



JS;
$this->registerJs($script);
?>
