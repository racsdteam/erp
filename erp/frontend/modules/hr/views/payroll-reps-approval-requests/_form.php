<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use frontend\assets\SmartWizardAsset;
use frontend\modules\hr\models\PayrollRunReports;
SmartWizardAsset::register($this); 
use softark\duallistbox\DualListbox;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponents */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    
 /* .transfer-double-content-left {
    display: inline-block;
    width: 350px;
    height: 320px;
    border: 1px solid #eee;
    border-radius: 2px;
    float: left;
}

.transfer-double-content-right {
    display: inline-block;
    width: 350px;
    height: 320px;
    border: 1px solid #eee;
    border-radius: 2px;
}

.transfer-double {
    width: 900px;
   
}*/
</style>


                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="far fa-clock"></i> Payroll Reports Approval Request</h3>
                       </div>
               
           <div class="card-body">
      
     
           <?php if(Yii::$app->session->hasFlash('error')) {
               
               Yii::$app->alert->showError(Yii::$app->session->getFlash('error'),'error');
               
               }
           
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
    
    //---------------current period-------------
    $currentM=date("m", strtotime('m'));
    $currentY=date("Y");
    
    //---------period date range------------------------ 
     $period_start=date('01/m/Y',strtotime('this month'));
     $period_end=date( 't/m/Y' );
     
     
     if($model->isNewRecord){
        $model->pay_period_month=$currentM;
        $model->pay_period_year=  $currentY; 
        
        $model->pay_period_start=$period_start;
        $model->pay_period_end=$period_end;
     }else{
          $model->pay_period_start=$date_format($model->pay_period_start);
          $model->pay_period_end=$date_format($model->pay_period_end);
         
     }
     
      $reports= ArrayHelper::map(PayrollRunReports::findByStatus('draft'), 'id',"rpt_desc") ;
   ?>
     
      

 
    
    <?php $form = ActiveForm::begin(['id'=>'payroll-form']); ?>
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
     
      <div class="row">
          <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
           
              <?= $form->field($model, 'pay_period_start',['template' => '
                          {label}
                       <div class="input-group col-sm-12">
                        <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                
                                </div>
                     
                         {input}
                         
                           
                       </div>{error}{hint}
               '])->textInput(['maxlength' => true,'class'=>['form-control date'],'placeholder'=>'Payroll Period Start...']) ?>
              
          </div> 
         
        <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
           
           <?= $form->field($model, 'pay_period_end',['template' => '
                          {label}
                       <div class="input-group col-sm-12">
                        <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                
                                </div>
                     
                         {input}
                         
                           
                       </div>{error}{hint}
               '])->textInput(['maxlength' => true,'class'=>['form-control date'],'placeholder'=>'Payroll Period End...']) ?>
              
          </div> 
          
          
     </div>
   
     
   <?php
    $options = [
        'multiple' => true,
        'size' => 20,
    ];
    // echo $form->field($model, $attribute)->listBox($items, $options);
    echo $form->field($model, 'reports')->widget(DualListbox::className(),[
        'items' => $reports,
        'options' => $options,
        'clientOptions' => [
            'moveOnSelect' => false,
            'selectedListLabel' => 'Selected Run Reports',
            'nonSelectedListLabel' => 'Available Run Reports',
        ],
    ]);
?>
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

?>
