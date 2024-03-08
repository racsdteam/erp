<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use frontend\modules\hr\models\EmployeeStatuses;
use frontend\modules\hr\models\Employees;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpStatusDetails */
/* @var $form yii\widgets\ActiveForm */
?>



<style>
    .invalid-feedback{display:block;}
    
</style>



                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-bell"></i> Employee Change Status</h3>
                       </div>
               
           <div class="card-body">
               
               <?php
               
   if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   } 
            
   $statuses=ArrayHelper::map(EmployeeStatuses::find()->where(['not in','code',['TERM','SUSP']])->all(), 'code','name');      
               ?>

    <?php $form = ActiveForm::begin(['id'=>'dynamic-form']); ?>
   <?php 
   
   if(!empty($employee) && empty($model->employee))
       $model->employee=$employee;
   if(!empty($model->employee))
   echo  $form->field($model, 'employee')->hiddenInput(['value'=>$model->employee])->label(false); 
   ?>
   

   <?= $form->field($model,  'employee')->dropDownList([ArrayHelper::map(Employees::find()->all(), 'id', function($model){
       
       return $model->first_name.' '.$model->last_name;
   })], ['prompt'=>'Select employee',
               'id'=>'emp-id','class'=>['form-control m-select2 '],'disabled'=>!empty($model->employee)])->label("Employee") ?>  
  <div class="row">
      
      <div class="col-sm-12 col-md-4 col-lg-6">
       
        <?= $form->field($model,  'status')->dropDownList($statuses, ['prompt'=>'Select Status',
               'id'=>'r-id','class'=>['form-control m-select2 ']])->label("Select Status") ?>    
          
      </div>
      
      <div class="col-sm-12 col-md-4 col-lg-6">
          
     <?= $form->field($model, 'effective_date')->textInput(['maxlength' => true,'class'=>['form-control date'],'placeholder'=>'Effective Date...','onChange'=>'
    $("#last-date").val($(this).val()).change();
    ','id'=>'term-date'])->label("Effective Date of Status") ?>     
          
      </div>
      
      
      
      
      
      
  </div>
  
   <?= $form->field($model, 'comment')->textArea(['rows' => '4'])->label("Status Reason")?>
  


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>

<?php

$script = <<< JS

 $(document).ready(function(){


			$('.date').bootstrapMaterialDatePicker
			({
			    //format: 'DD/MM/YYYY',
				time: false,
				clearButton: true
			});

			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});

     //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
     
 
      $('#tbl-attach').DataTable( {
      destroy: true,
	  paging: false,
      lengthChange: false,
      searching: false,
      ordering: false,
      info: false,
      autoWidth: true,
       responsive: true,
      language: {
      emptyTable: " "
    }
       
     /*language : {
        "zeroRecords": " "             
    },*/
     
		
	
	} );
});

JS;
$this->registerJs($script);

?>



