<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\modules\hr\models\PayItemCategories;
use frontend\modules\hr\models\PayItems;
use frontend\modules\hr\models\Employees;
use yii\bootstrap4\ActiveForm;
use frontend\modules\hr\models\PayGroups;


/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponents */
/* @var $form yii\widgets\ActiveForm */
?>

<style>

</style>


                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="far fa-clock"></i> Copy Data From Previous Payroll</h3>
                       </div>
               
           <div class="card-body">
      
     
           <?php if(Yii::$app->session->hasFlash('error')) {
               
               Yii::$app->alert->showError(Yii::$app->session->getFlash('error'),'error');
               
               }
           
            ?>
      
     
   
     
      <?php
    
     
   
   
   ?>
     
      

 
    
    <?php $form = ActiveForm::begin(['id'=>'payroll-copy-form']); ?>
    

			
	<?= $form->field($copyModel, 'prevPayroll')->dropDownList([], ['prompt'=>'Select Previous Payroll To Copy',
               'id'=>'prev','class'=>['form-control  m-select2 ']])->label("Select Previous Payroll") ?>		
        
     <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?'Save':'Update', ['class' => $model->isNewRecord ?'btn btn-success':'btn btn-primary']) ?>
    </div>    
            
      <?php ActiveForm::end(); ?>      
            
            </div>
            
  
    
   
        
   

    


</div>





<?php

       

$script = <<< JS

 $(document).ready(function(){

  //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
     $(".m-select").select2({width:'80%',theme: 'bootstrap4'});
     
     $('.date').bootstrapMaterialDatePicker
			({
			    format: 'DD/MM/YYYY',
				time: false,
				clearButton: true
			});

			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});

   
});

JS;
$this->registerJs($script);

$script2 = <<< JS

//------check value validation
function isCopyOptionChecked (attribute, value) {

return $('input:checkbox[name="ApprovalWorkflows[enable_condition]"]').is(':checked');
	};

 function isConditionEnabled (attribute, value) {

return $('input:checkbox[name="ApprovalWorkflows[enable_condition]"]').is(':checked');
	};   

JS;
$this->registerJs($script2,$this::POS_HEAD);
?>


