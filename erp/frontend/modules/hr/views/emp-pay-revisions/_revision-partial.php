<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use frontend\modules\hr\models\ EmpTypes;
use frontend\modules\hr\models\ EmploymentType;
use frontend\modules\hr\models\ EmploymentStatus;
use frontend\modules\hr\models\ PayGroups;
use frontend\modules\hr\models\ PayLevels;
use frontend\modules\hr\models\Payfrequency;
use frontend\modules\hr\models\Locations;
use frontend\modules\hr\models\PayTemplates;
use frontend\modules\hr\models\Employees;
use frontend\modules\hr\models\PayTypes;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpOrgLevels;
use kartik\depdrop\DepDrop;


?>
<style>
    
 div.emp-type label, div.pay-type label,div.med-scheme label{  display: inline-block; margin-right: 30px;}    
 #pay-revision-form .field-heading{border-bottom: 1px solid rgba(0,0,0,.125);}
 
 div.invalid-feedback{
     
   display:block;  
 }
    
</style>
   <div class="card card-default text-dark">
        
                     
               
           <div class="card-body">
               
            <?php
              
              $employment=$employee->employmentDetails;
              
              $payLevels=ArrayHelper::map(PayLevels::find()->all(), 'id',function($level){
                        
                        return 'Level-'.$level->number." : ".$level->description;
                        
                    }) ;
                    
            $payTypes=ArrayHelper::map(PayTypes::find()->all(), 'code','name') ;
   
     $months=array();
    
     
     for($m=1; $m<=12; $m++){
 
     //Numeric representation of a month, with leading zeros
     $month_code=date('m', mktime(0, 0, 0, $m, 1)); 
    
    // A full textual representation of a month, such as January or March
     $month_name= date('F', mktime(0, 0, 0, $m, 1));
      
     $months[$month_code."-".date("Y")]=$month_name.' '.date("Y");
     
     }
     
     
     
     

            ?>


           <?= $form->field($newPay, 'employee')->hiddenInput(['value'=>$employee->id])->label(false); ?>
           <?= $form->field($newPay, 'org_unit')->hiddenInput(['value'=>$employment->orgUnitDetails->id])->label(false); ?>
           <?= $form->field($newPay, 'position')->hiddenInput(['value'=> $employment->positionDetails->id])->label(false); ?>
           
 
                        <div class="row">
                          
                          <div class="col-sm-12">
                           
                                  <?=
                    $form->field($newPay, 'pay_type')
                        ->radioList(
                            $payTypes,
                            [
                                'item' => function($index, $label, $name, $checked, $value) {
                                     $isChecked=$checked? 'checked':'';
                                   
                                     $return = '<div class="icheck-primary pay-type d-inline">';
                                   
                        $return .= '<input type="radio" id="pay-type-new-radio-' . $index . '"   name="' . $name . '" value="' . $value . '"   tabindex="3" '.$isChecked.'>';
                                    $return.='<label for="pay-type-new-radio-' . $index . '">'.$label.' </label>';
                                    
                                    $return .= '</div>';

                                    return $return;
                                },
                                'disabled'=> true
                            ]
                        )->label("New Pay Type")
                    ;
                    ?>
                          </div>  
                            
                        </div>
                        
         
   <div class="row">
        
       <div class="col-sm-12 col-md-4  col-lg-4">
        <?php $newPay->pay_frequency='M'; ?>
     
      <?= $form->field($newPay, 'pay_frequency' )
     ->dropDownList([ArrayHelper::map(PayFrequency::find()->all(), 'code', 'name')], ['prompt'=>'Select  pay frequency', 
               'id'=>'new-pay-type','class'=>['form-control m-select2 pay-type ']])->label("New Pay Frequency") ?>    
   
    
       
   </div>
   
    
                
 <div class="col-sm-12 col-md-4 col-lg-4">
        
        <?= $form->field($newPay, 'pay_group' )
     ->dropDownList([ArrayHelper::map(PayGroups::find()->all(), 'code', 'name')], ['prompt'=>'Select  pay group', 
               'id'=>'new-pay-group','class'=>['form-control m-select2 pay-group '],'onchange'=>'
				$.post( "'.Yii::$app->urlManager->createUrl('/hr/pay-groups/pay-template?code=').'"+$(this).val(), function( data ) {
				  
				  $( "#new-pay-tmpl" ).val(data.code).change();
				});
			'])->label('New Pay Group') ?>  
        
</div>
   
   
  
                
            <div class="col-sm-12 col-md-4 col-lg-4">
    <?php 
            
           $PayTemplates=ArrayHelper::map(PayTemplates::find()->all(), 'code','name') ; 
            
            ?>    
     <?= $form->field($newPay, 'pay_tmpl' )
     ->dropDownList($PayTemplates, ['prompt'=>'Select  pay structure',
               'id'=>'new-pay-tmpl','class'=>['form-control m-select2 pay-grade ']])->label('New Pay Template') ?>     
   
    
       
   </div>       
            </div>                  
                   
   
    
                      <div class="row ">
          
                      <div class="col-sm-12 col-md-8 col-lg-8">
            <?= $form->field($newPay, 'pay_level' ,['options' => ['class' => 'form-group flex-grow-1']])
     ->dropDownList($payLevels, ['prompt'=>'Select  pay grade',
               'id'=>'new-pay-grade','class'=>['form-control m-select2 pay-grade  '],'onchange'=>'
				$.post( "'.Yii::$app->urlManager->createUrl('/hr/pay-levels/basic-sal?id=').'"+$(this).val(), function( data ) {
				  $( "#new-base-pay" ).val(data.bs);
				});
			'])->label("New Pay Level") ?> 
			
     </div>    
                         
                         <div class="col-sm-12 col-md-4 col-lg-4">
                             
                            <?= $form->field($newPay, 'base_pay')->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Amount...','id'=>'new-base-pay','class'=>['form-control']])->label("New Base Pay") ?>     
                             
                         </div>
             
             
            
                       
                    </div>
              
 
 
     
  
  <div class="row">
 <div class="col-sm-12 col-md-4 col-lg-4">
              
              <?= $form->field($model, 'revision_date')->textInput(['maxlength' => false,'class'=>['form-control date'],'placeholder'=>'Revision Date...'])->label('Revision Date')?> 
            
              
                

   
          </div>  
          
          
  <div class="col-sm-12 col-md-4 col-lg-4">
              
              <?= $form->field($model, 'effective_date')->textInput(['maxlength' => false,'class'=>['form-control date'],'placeholder'=>'effective from...','onchange'=>'
			 var dt=new Date($(this).val());
			 var yr=dt.toLocaleDateString("en-US", {year: "numeric"});
			 var m=dt.toLocaleDateString("en-US", {month: "2-digit"});
			 $("#pay-month-id").val(m+"-"+yr).change();
			'])->label('Effective From')?> 
            
              
                

   
          </div>         
 
  <div class="col-sm-12 col-md-4 col-lg-4">
              
               <?= $form->field($model, 'payout_ym')->dropDownList($months, ['prompt'=>'Select Payout Month',
               'id'=>'pay-month-id','class'=>['form-control m-select2 ']])->label("Payout Month") ?> 
            
              
                

   
          </div>            
                      
                    </div>    
      
                
     
           <?= $form->field($model, 'reason')->textArea(['rows' => '3']) ?>  
            
           
   
              
                 
               


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?'Save':'Update', ['class' => $model->isNewRecord?'btn btn-success':'btn btn-primary']) ?>
    </div>

   

</div>
</div>

<?php

$script = <<< JS


$(function() {
   
   revisionTypeSelect($("#revision-type").val()) ;
});


        
JS;
$this->registerJs($script);

$script2 = <<< JS



function revisionTypeSelect (value) {
       
       if(value!=='') {
    
  $('.input-value').not('.'+ value).prop("disabled",true);
 
  $('.'+ value).prop("disabled",false);


 
}        
       
	};
	

          

JS;
$this->registerJs($script2,$this::POS_HEAD);

?>


