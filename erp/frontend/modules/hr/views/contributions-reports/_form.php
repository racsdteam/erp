
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\modules\hr\models\CompanyContributions;
use frontend\modules\hr\models\PayGroups;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponents */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="far fa-clock"></i> Report Details</h3>
                       </div>
               
           <div class="card-body">
      
      <?php
          if($model->hasErrors()){
              
               $msgbox=Html::tag('div',Html::button('x',
    ['class'=>'close',' data-dismiss'=>'alert','aria-hidden'=>true]).
    Html::tag('h5','<i class="icon fas fa-ban"></i> Alert!',[]).
    Html::errorSummary($model),
    ['class'=>'alert alert-danger alert-dismissible']);
  
    echo $msgbox;
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
    
     if($model->isNewRecord){
        $model->pay_period_month=date("m", strtotime('m'));
        $model->pay_period_year= date("Y"); 
        
        
     }
    
    $empGroup=ArrayHelper::map(PayGroups::find()->all(), 'id', 'name');
    array_unshift($empGroup,"All");
    $model->pay_group=0;
   
   ?>
     
    
 
    
    <?php $form = ActiveForm::begin(); ?>
    
   <?= $form->field($model, 'description')->textInput(['maxlength' => true])->label("Report Title") ?>
   
    <?= $form->field($model,  'contribution')->dropDownList([ArrayHelper::map(CompanyContributions::find()->all(), 'id', 'description')], ['prompt'=>'Select Contribution',
               'id'=>'ec-id','class'=>['form-control m-select2 ']])->label("Contribution Type") ?> 
               
                <?= $form->field($model, 'pay_group' )
     ->dropDownList( $empGroup, ['prompt'=>'Select  employee group',
               'id'=>'pay-group','class'=>['form-control m-select2 pay-group ']]) ?>  
     
      <div class="row">
          
           <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
           
           <?= $form->field($model, 'pay_period_year',['template' => '
                          {label}
                       <div class="input-group col-sm-12">
                        <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                
                                </div>
                     
                         {input}
                         
                           
                       </div>{error}{hint}
               '])->dropDownList([$years], ['prompt'=>'Select payroll Year',
               'id'=>'pay-year-id','class'=>['form-control m-select ']])->label("Payroll Period Year") ?> 
              
          </div> 
          
          
          <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
           
             <?= $form->field($model, 'pay_period_month',['template' => '
                          {label}
                       <div class="input-group col-sm-12">
                        <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                
                                </div>
                     
                         {input}
                         
                           
                       </div>{error}{hint}
               '])->dropDownList([$months], ['prompt'=>'Select payroll Month',
               'id'=>'pay-month-id','class'=>['form-control m-select ']])->label("Payroll Period Month") ?> 
              
          </div> 
          
          
        
          
          
     </div>
   
   
        
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?'Save':'Update', ['class' =>$model->isNewRecord? 'btn btn-primary':'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>



<?php

$script = <<< JS

 $(document).ready(function(){


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

     //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
     $(".m-select").select2({width:'80%',theme: 'bootstrap4'});
 
     
});

JS;
$this->registerJs($script);

?>



