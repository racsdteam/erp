<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
$this->title="VOLUNTARY AND CONFIDENTIAL REPORTING FORM";
$this->context->layout='public';

/* @var $this yii\web\View */
/* @var $model frontend\modules\sms\models\Events */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .custom-checkbox{margin-right:15px;}
    .input-group > .select2-container--bootstrap4 {
    width: auto important!;
    flex: 1 1 auto important!;
}

.input-group > .select2-container--bootstrap4 .select2-selection--single {
    height: 100% important!;
    line-height: inherit important!;
    padding: 0.5rem 1rem important!;
}

    
</style>
<blockquote class="blockquote text-center">
<h1 class=""> <u><?= Html::encode($this->title) ?></u></h1>
<footer class="blockquote-footer">SMS Form 001</footer>
</blockquote>
<div class="row clearfix justify-content-center">

             <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 md-offset-2">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i>  <?= Html::encode($this->title) ?></h3>
                
            </div>
                      
                
               
           <div class="card-body">
          
                 
           <?php $form = ActiveForm::begin(); ?>
           <?=
                    $form->field($model_event, 'category_code')
                        ->radioList(
                            ArrayHelper::map($event_categories, 'code', 'category'),
                            [
                                'item' => function($index, $label, $name, $checked, $value) {
                                     $isChecked=$checked? 'checked':'';
                                     $return = '<div class="icheck-primary emp-type d-inline">';
                                   
                                    $return .= '<input type="radio" id="radio-' . $index . '"   name="' . $name . '" value="' . $value . '" tabindex="3" '.$isChecked.'>';
                                    $return.='<label for="radio-' . $index . '">'.$label.' </label>';
                                    
                                    $return .= '</div>';

                                    return $return;
                                }
                            ]
                        );
                    ?>
                    
  

    <?= $form->field($model_event, 'place')->textInput(['maxlength' => true]) ?>

      <div class="form-group">
             

                <div class="input-group ">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar-alt"></i>
                  </div>
</div>
                <!-- /.input group -->
              
                  <?= $form->field($model_event, 'date')->textInput(['maxlength' => true,'class'=>['form-control datetime pull-right','placeholder'=>'date and time']]) ?>
             </div>    
    <?= $form->field($model_event, 'time')->textInput() ?>

    <?= $form->field($model_event, 'description')->textarea(['rows' => 6]) ?>




  <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i>Aircraft Details</h3>
                
            </div>
                      
                
               
           <div class="card-body">
          

  

    <?= $form->field($model_event_aircraft_details, 'call_sign')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model_event_aircraft_details, 'AC_type')->textInput() ?>

    <?= $form->field($model_event_aircraft_details, 'AC_registration')->textInput() ?>

    <?= $form->field($model_event_aircraft_details, 'AC_operator')->textInput() ?>

</div>
</div>

 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i>Report Information </h3><br>
                             <p class="text-danger">Not madatory </p>
                
            </div>
                      
                
               
           <div class="card-body">
          

  

    <?= $form->field($model_event_reporter, 'name')->textInput(['maxlength' => true]) ?>
     <?= $form->field($model_event_reporter, 'email')->textInput() ?>
    <?= $form->field($model_event_reporter, 'phone')->textInput() ?>

</div>
</div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

  

</div>
</div>
</div>
<?php
$script2 = <<< JS

$(document).ready(function(){

 

 
 //-------------------------=========initialize dates and time widgets================--------------------------------------  
   	    
			$('.datetime').bootstrapMaterialDatePicker
			({
			    time: true,
				clearButton: true,
				maxDate : new Date(),
			format: 'YYYY-MM-DD HH:mm:ss'
			});
   
    $(".Select2").select2({width:'100%'});
    


        });

JS;
$this->registerJs($script2);
?>

