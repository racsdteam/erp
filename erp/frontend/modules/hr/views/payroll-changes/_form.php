<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\tinymce\TinyMce;
/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayrollChanges */
/* @var $form yii\widgets\ActiveForm */
?>
      <?php
      
      $date_format =function($date){
        
     return  date('d/m/Y', strtotime($date));   
       }; 
      
      $months=array();
     
     for($m=1; $m<=12; $m++){
     
     //--------shorter representation--Jan--    
     //$month_code=date('M', mktime(0, 0, 0, $m, 1)); 
     
     //Numeric representation of a month, with leading zeros
     $month_code=date('m', mktime(0, 0, 0, $m, 1)); 
    
    // A full textual representation of a month, such as January or March
     $month_name= date('F', mktime(0, 0, 0, $m, 1));
      
      $months[$month_code]=$month_name;
     
     }
     
    
     
     $start_range = date('Y');
     $range = range($start_range, $start_range + 10);
     $years=array_combine($range, $range);
    
    //---------period date range------------------------ 
     $period_start=date('01/m/Y',strtotime('this month'));
     $period_end=date( 't/m/Y' );
     
     if($model->isNewRecord){
        $model->pay_period_month=date("m", strtotime('m'));
        $model->pay_period_year= date("Y"); 
     }
   ?>
   
<div class="payroll-changes-form">
<div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="far fa-clock"></i> Payrolls Changes</h3>
                       </div>
               
           <div class="card-body">
    <?php $form = ActiveForm::begin(); ?>
  <div class="row">
        
         <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
           
           <?= $form->field($model, 'pay_period_year')->dropDownList([$years], ['prompt'=>'Select payroll Year',
               'id'=>'pay-year-id','class'=>['form-control m-select2 ']])->label("Payroll Period Year") ?> 
              
          </div> 
          
          
          <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
           
             <?= $form->field($model, 'pay_period_month')->dropDownList([$months], ['prompt'=>'Select payroll Month',
               'id'=>'pay-month-id','class'=>['form-control m-select2 ']])->label("Payroll Period Month") ?> 
              
          </div> 
         
       
          
          
     </div>
     

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        
<?= $form->field($model, 'description')->widget(TinyMce::className(), [
    'options' => ['rows' => 18],
    'language' => 'en',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    ]
]);?>    
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
