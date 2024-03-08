<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use frontend\assets\SmartWizardAsset;
use frontend\modules\hr\models\Payrolls;
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

/*-----------------------------force show invalid feedback---------------------------------------------------------------*/
.invalid-feedback {
  display: block;
}

/*--------------------------spacing radio options------------------------------------------------*/
  div.emp-type label, div.pay-type label,div.med-scheme label{  display: inline-block; margin-right: 30px;}
</style>


                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="far fa-clock"></i> Payroll Approval Request Details</h3>
                       </div>
               
           <div class="card-body">
      
     
           <?php if(Yii::$app->session->hasFlash('error')) {
               
               Yii::$app->alert->showError(Yii::$app->session->getFlash('error'),'error');
               
               }
           $payrolls= ArrayHelper::map(Payrolls::getByStatus("completed"), 'id',"name") ;
           $payrolls1= ArrayHelper::map(Payrolls::find()->all(), 'id',"name") ;
            $reports= ArrayHelper::map(PayrollRunReports::findByStatus('draft'), 'id',"rpt_desc") ;
            ?>
  
    
    <?php $form = ActiveForm::begin(['id'=>'payroll-form']); ?>
    
     <?=
                    $form->field($model, 'type')
                        ->radioList(
                            ['SAL'=>'Salary','DC'=>'Deductions/Contributions'],
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
                        )
                    ->label("Approval Request Type");
                    ?>
    
      <?= $form->field($model, 'title')->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'Request Title...']) ?>
    <div class="row">
        
         <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
           
           <?= $form->field($model, 'pay_period_year')->dropDownList(Yii::$app->prlUtil->yearsList(), ['prompt'=>'Select payroll Year',
               'id'=>'pay-year-id','class'=>['form-control m-select2 ']])->label("Period Year") ?> 
              
          </div> 
          
          
          <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
           
             <?= $form->field($model, 'pay_period_month')->dropDownList(Yii::$app->prlUtil->monthsList(), ['prompt'=>'Select payroll Month',
               'id'=>'pay-month-id','class'=>['form-control m-select2 ']])->label("Period Month") ?> 
              
          </div> 
         
        <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
           
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
               '])->textInput(['maxlength' => true,'class'=>['form-control date'],'placeholder'=>'Period Start...'])->label("Period Start") ?>
              
          </div> 
          
           <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
           
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
               '])->textInput(['maxlength' => true,'class'=>['form-control date'],'placeholder'=>'Period End...'])->label("Period End") ?>
              
          </div> 
          
          
     </div>
     
  
   
   <div class="SAL-required type-content"> 
   <?php
    $options = [
        'multiple' => true,
        'size' =>5,
    ];
    
    // echo $form->field($model, $attribute)->listBox($items, $options);
    echo $form->field($model, 'payrolls')->widget(DualListbox::className(),[
        'items' => $payrolls,
        'options' => $options,
        'attribute' => 'payrolls', 
        'selection'=>$model->payrolls,
        'clientOptions' => [
            'moveOnSelect' => false,
            'selectedListLabel' => 'Selected Payrolls',
            'nonSelectedListLabel' => 'Available Payrolls',
            
        ],
    ]);
    ?>
    </div>
    
    <div class="SAL-required DC-required type-content">
    <?php
    echo $form->field($model, 'reports')->widget(DualListbox::className(),[
        'items' => $reports,
        'options' => $options,
        'clientOptions' => [
            'moveOnSelect' => false,
            'selectedListLabel' => 'Selected Reports',
            'nonSelectedListLabel' => 'Available Reports',
        ],
    ]);
?>

</div>
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
$('div.type-content').hide();
toggleContent($('input[name="PayrollApprovalRequests[type]"]:checked').val());

$('input[name="PayrollApprovalRequests[type]"]').click(function() {
        
     toggleContent($(this).val());
        
    });
    
function toggleContent(val){
    
 $('.type-content').not('.'+ val+'-required').hide();
 $('.'+val+'-required').show();   
}    
   
});

JS;
$this->registerJs($script);

$script2 = <<< JS


//------check value validation
function isPOptionChecked (attribute, value) {

return $('input[name="PayrollApprovalRequests[type]"]:checked').val()=='P'

	};

//------check value validation
function isDCOptionChecked (attribute, value) {

return $('input[name="PayrollApprovalRequests[type]"]:checked').val()=='DC'
	};
  
JS;
$this->registerJs($script2,$this::POS_HEAD);

?>
