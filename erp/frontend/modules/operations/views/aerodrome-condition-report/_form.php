<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\operations\models\AerodromeConditionReport */
/* @var $form yii\widgets\ActiveForm */
date_default_timezone_set('Africa/Cairo');
$aerodromes=ArrayHelper::map($aerodromes, 'aerodrome','aerodrome') ;
$currentDateTime = new DateTime();

?>

<div class="aerodrome-condition-report-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'aerodrome') ->dropDownList($aerodromes,['prompt'=>'Select type...','class'=>['form-control select2'],])
    
    ?>
      <div class="form-group">
             

                <div class="input-group ">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar-alt"></i>
                  </div>
</div>
                <!-- /.input group -->
    
 <?= $form->field($model, 'date')->textInput(['maxlength' => true,'class'=>['form-control datetime pull-right','placeholder'=>'date and time'],'value'=>$currentDateTime->format('Y-m-d H:i:s'),'readonly'=>true]) ?>
             </div>    
    <?= $form->field($model, 'condition_status')
    ->dropDownList(["1"=>"Yes","0"=>"No"],['prompt'=>'Select type...','class'=>['form-control select2'],])
    ->label("Is more than 25% of any runway third surface wet or contaminated? ") ?>

    <?= $form->field($model, 'awareness')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'TWY_condition')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Apron_condition')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'other')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
<?php
$script2 = <<< JS

$(document).ready(function(){

 

 
 //-------------------------=========initialize dates and time widgets================--------------------------------------  
   	    
			$('.datetime').bootstrapMaterialDatePicker
			({
				clearButton: true,
				minDate : new Date(),
			format: 'YYYY-MM-DD',
			time:false
		
			});
   
    $(".Select2").select2({width:'100%'});
    


        });

JS;
$this->registerJs($script2);
?>
