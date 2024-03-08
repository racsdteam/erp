<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeavePublicHoliday */
/* @var $form yii\widgets\ActiveForm */
?>
<?php if (Yii::$app->session->hasFlash('error')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('error');

  echo '<script type="text/javascript">';
  echo 'swal(
  "Error!",
  "'.$msg.'",
  "error");';
  echo '</script>';
  
  
  ?>
    <?php endif; ?>
<div class="leave-public-holiday-form">
<div class="row">

             <div class="col-md-8 offset-md-2 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i> <?= Html::encode($this->title) ?> </h3>
                       </div>
           <div class="card-body ">            
    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
             

                <div class="input-group">
                  
                  <div class="input-group-addon">
                    <i class="fa fa-calendar-alt"></i>
                  </div>
</div>
                    <!-- /.input group -->
                  <?= $form->field($model, 'holiday_date')->textInput(['maxlength' => true,'class'=>['form-control date pull-right','placeholder'=>'Ending date...']]) ?>
                
                
              </div>  
    <?= $form->field($model, 'holiday_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'yearly_repeat_status')->dropDownList([ 'yes' => 'Yes', 'no' => 'No',], ['prompt' => 'Select Status']) ?>

 <?= $form->field($model, 'holiday_type')->dropDownList([ 'Local holiday' => 'Local holiday', 'International holiday' =>'International holiday',], ['prompt' => 'Select Type']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
</div>
<?php
$script2 = <<< JS

 


$(document).ready(function(){

 

 
 //-------------------------=========initialize dates and time widgets================--------------------------------------  
   	    
			$('.date').bootstrapMaterialDatePicker
			({
				time: false,
				clearButton: true
			});

			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});
			
			
			 $(function () {
   
    $(".Select2").select2({width:'100%'});
    
 });
       
        });

JS;
$this->registerJs($script2);
?>
