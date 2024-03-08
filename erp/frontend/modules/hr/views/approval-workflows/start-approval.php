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
 
  $user=Yii::$app->user->identity;
  $steps=$wfModel->approvalSteps;
  
  
 
?>
  
 <div class="card card-warning text-dark ">
        
       
               
           <div class="card-body">
       
       <div class="callout callout-warning">
                  <h5><i class="fas fa-people-arrows"></i> Leave request will be submitted to the following Reviewers/Approvers :  </h5>

                    <div class="d-flex flex-column">
                    <?php  $i=1; $size=count($steps);foreach($steps as $step) : ?>
  <div class="text-blue btn btn-block bg-info btn-sm"><?=$step->name?></div>
  <?php echo  $i < $size ? '<span class="text-center"><i class="fas fa-long-arrow-alt-down text-info"></i></span>' :''; $i++; ?>

           <?php endforeach ;?>
           </div>
                </div>        
             
               
    

                         <?php
    
   
    $form = ActiveForm::begin([
        'id'=>'action-form1', 
    'options' => [
	//	'class' => 'radio',
		
	],
       ]);
?>
<?=$form->field($wfStartForm, 'wfModel')->hiddenInput(['value'=> $wfModel->id])->label(false)?>
<?=$form->field($wfStartForm, 'initiator')->hiddenInput(['value'=>Yii::$app->user->identity->user_id])->label(false)?>
<?=$form->field($wfStartForm, 'entityRecord')->hiddenInput(['value'=> $model->id])->label(false)?>
<?=$form->field($wfStartForm, 'entityType')->hiddenInput(['value'=> $model->formName()])->label(false)?>
<?= $form->field($wfStartForm, 'comment')->textarea(['rows' => '4','placeholder'=>'Optional comment...'])->label("Comment") ?>
 
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
