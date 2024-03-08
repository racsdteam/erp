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
    
</style>
   <div class="card card-default text-dark">
        
                     
               
           <div class="card-body">
               
            <?php
            
            
            
             
             $payLevels=ArrayHelper::map(PayLevels::find()->all(), 'id',function($level){
                        
                        return 'Level-'.$level->number." : ".$level->description;
                        
                    }) ;
                    
            $payTypes=ArrayHelper::map(PayTypes::find()->all(), 'code','name') ;
            
  
            ?>


                        <div class="row">
                          
                          <div class="col-sm-12">
                   <label for="pay-freq-id">Current Pay Type</label> 
                                  <?=
                   Html::radioList('pay_type',$currentPay->pay_type,
                            $payTypes,
                            [
                                'item' => function($index, $label, $name, $checked, $value) {
                                     $isChecked=$checked? 'checked':'';
                                     $isDisabled=$checked ? '' :'disabled';
                                     $return = '<div class="icheck-primary pay-type d-inline">';
                                   
                        $return .= '<input type="radio" id="pay-type-radio-' . $index . '"   name="' . $name . '" value="' . $value . '"  '. $isDisabled.'  tabindex="3" '.$isChecked.'>';
                                    $return.='<label for="pay-type-radio-' . $index . '">'.$label.' </label>';
                                    
                                    $return .= '</div>';

                                    return $return;
                                },
                                'disabled'=> true
                            ]
                        )
                    ;
                    ?>
                          </div>  
                            
                        </div>
                        
         
   <div class="row">
            
     
       <div class="col-sm-12 col-md-4 col-lg-4">
        <?php $currentPay->pay_frequency='M'; ?>
        
           
 <label for="pay-freq-id">Current Pay Frequency</label>
    
     <?= Html::dropDownList('pay_frequency', $currentPay->pay_frequency, [ArrayHelper::map(PayFrequency::find()->all(), 'code', 'name')], ['id'=>'pay-freq-id','class'=>'form-control','disabled'=> true,

   'options' => []
]) ?>

     
       
   
    
       
   </div> 
                
 <div class="col-sm-12 col-md-4 col-lg-4">
     
                
 <label for="pay-group-id">Current Pay Group</label>
    
<?= Html::dropDownList('pay_group', $currentPay->pay_group, [ArrayHelper::map(PayGroups::find()->all(), 'code', 'name')], 
['id'=>'pay-group-id','class'=>'form-control','disabled'=> true,
'onchange'=>'
				$.post( "'.Yii::$app->urlManager->createUrl('/hr/pay-groups/pay-template?code=').'"+$(this).val(), function( data ) {
				  $( "#pay-tmpl" ).val(data.code).change();
				});
			'
]) ?>
        
      
        
</div>
   
   
  
                
            <div class="col-sm-12 col-md-4 col-lg-4">
  
                
 <label for="pay-tmpl">Current Pay Template</label>
    
     <?= Html::dropDownList('pay_tmpl', $currentPay->pay_tmpl, [ArrayHelper::map(PayTemplates::find()->all(), 'code','name')], 
     ['id'=>'pay-tmpl','class'=>'form-control','disabled'=> true,

   'options' => []
]) ?>       
            
      
   
    
       
   </div>       
            </div>                  
                   
                        
                      <div class="row ">
                        
                         <div class="col-sm-12 col-md-6 col-lg-6">
                       
                        <label for="pay-level">Current Pay Level</label>
    
     <?= Html::dropDownList('pay_tmpl', $currentPay->pay_level, $payLevels, 
     ['id'=>'pay-level','class'=>'form-control','disabled'=> true,

   'options' => []
]) ?>       
              
                         
                  
                             
                         </div>
                        
                         <div class="col-sm-12 col-md-6 col-lg-6">
                             <label for="base-pay">Current Base Pay</label>
                           
                             <?= Html::input('text', 'base_pay', $currentPay->base_pay, ['class' => ['form-control  input-format'], 'disabled'=> true,'id'=>'base-pay']) ?>
                             
                              
                             
                         </div>
             
             
            
                       
                    </div>
              
 

</div>
</div>


