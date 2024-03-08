<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use frontend\modules\hr\models\PayItemCategories;
use frontend\modules\hr\models\StatutoryDeductions;
use yii\bootstrap4\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponents */
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
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-money-bill-alt"></i>  New Payroll Item</h3>
                       </div>
               
           <div class="card-body">
      
      <?php
      
       if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
      ?>
      
               
    <?php $itemCategories=ArrayHelper::map(PayItemCategories::find()->all(), 'code', 'name');
    
    $statutoryDeductions=ArrayHelper::map(StatutoryDeductions::find()->all(), 'abbr',function($model){
        
        return $model->abbr.' - '.$model->description; 
    });
    
    $taxOptions=['1'=>'Subject To Paye','0'=>'Not Subject to Paye'];
    ?>
    
    <?php $form = ActiveForm::begin(); ?>
    
      <div class="row">
                  
                  <div class="col-sm-12 col-md-6 col-lg-8">
                     
                     <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>  
                      
                  </div>
                  
                   <div class="col-sm-12 col-md-6 col-lg-4">
                       
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>            
                   
                   </div>
                  
                  </div>

    <div class="row">
                  
                  <div class="col-sm-12 col-md-6 col-lg-8">
                     
                     <?= $form->field($model, 'report_name')->textInput(['maxlength' => true]) ?>  
                      
                  </div>
                  
                   <div class="col-sm-12 col-md-6 col-lg-4">
                       
          <?= $form->field($model,  'category')->dropDownList($itemCategories, ['prompt'=>'Select  category',
               'id'=>'pay-categ','class'=>['form-control m-select2 ']])->label("Category") ?>           
            
            
           
                   </div>
                  
                  </div>
                  
                  
  <div id="SD" class="categ-type SD">
  
  <?= $form->field($model,  'statutory_type')->dropDownList($statutoryDeductions, ['prompt'=>'Select  statutory Deduction Type',
               'id'=>'statutory-type','class'=>['form-control m-select2 ']])->label("Statutory Deduction Type") ?>     
      
  </div>  
    
  <div id="SC" class="categ-type SC">
  
  <?= $form->field($model,  'statutory_type')->dropDownList($statutoryDeductions, ['prompt'=>'Select  statutory Deduction Type',
               'id'=>'statutory-type','class'=>['form-control m-select2 ']])->label("Statutory Deduction Type") ?>     
      
  </div>
  <div class="row">
  
   <div class="col-sm-12 col-md-6 col-lg-6">
       
       
    
    
   <?= $form->field($model, 'subj_to_paye')->inline()->radioList($taxOptions,[
                      
                      
                    'template' => "{label}\n<div class='col-md-12 radio'>{input}</div>\n{hint}\n{error}",
                    'labelOptions' => [ 'class' => '' ],
                    'uncheckValue' => null
                    ])->label("Taxe Type/Earnings");
                    
                    
?>   
      
 
   </div>
   
    <div class="col-sm-12 col-md-6 col-lg-6">
      
     
    
    
   <?= $form->field($model, 'pre_tax')->inline()->radioList(['1'=>'Pre Tax Deduction','0'=>'Post Tax Deduction'],[
                      
                      
                    'template' => "{label}\n<div class='col-md-12 radio'>{input}</div>\n{hint}\n{error}",
                    'labelOptions' => [ 'class' => '' ],
                    'uncheckValue' => null
                    ])->label("Taxe Type/Deductions");
                    
                    
?>   
      
   </div>
  
  </div>
   
           
            
  
     
   
      <?php



$processingTypes=['fixed'=>'Fixed','variable'=>'Variable'];

$payTypes=['REG'=>'Part of Regular Pay ','SUP'=>'Pay Supplement ','OTH'=>'Other'];


?> 
  
     <div class="row">
    
    
     <div class="col-sm-12 col-md-8 col-lg-8">
                   
                    <?php 
   
   
 
    echo $form->field($model, 'pay_type')->inline()->radioList($payTypes,[
                      
                      
                    'template' => "{label}\n<div class='col-md-12 radio'>{input}</div>\n{hint}\n{error}",
                    'labelOptions' => [ 'class' => '' ],
                    'uncheckValue' => null
                    ])->label("Payment Type");?> 
                    
           
                  </div>
 
 
  <div class="col-sm-12 col-md-4 col-lg-4">
                   
                    <?php 
   
   
 
    echo $form->field($model, 'proc_type')->inline()->radioList($processingTypes,[
                      
                      
                    'template' => "{label}\n<div class='col-md-12 radio'>{input}</div>\n{hint}\n{error}",
                    'labelOptions' => [ 'class' => '' ],
                    'uncheckValue' => null
                    ])->label("Processing Type");?> 
                    
           
                  </div>
         
                      
        
    </div> 
 
 <div class="row">
 
  <div class="col-sm-12 col-md-4 col-lg-4">
        
        <?= $form->field($model, 'rama_payable')->checkbox(array('label'=>''))
			->label('RSSB/RAMA Payable'); ?>  
    </div> 
    
     <div class="col-sm-12 col-md-4 col-lg-4">
         <?= $form->field($model, 'mmi_payable')->checkbox(array('label'=>''))
			->label('MMI Payable'); ?>	
        
    </div> 
    
     <div class="col-sm-12 col-md-4 col-lg-4">
        
       <?= $form->field($model, 'pensionable')->checkbox(array('label'=>''))
			->label('RSSB/Pension & Maternity Leave Payable '); ?>   
    </div> 
     
  
     
  </div>   
    
  <div class="row">
      
  	
    <div class="col-sm-12 col-md-4 col-lg-4">
        
         <?= $form->field($model, 'cbhi_payable')->checkbox(array('label'=>''))
			->label('CBHI Payable '); ?> 
        
    </div>
    
     <div class="col-sm-12 col-md-4 col-lg-4">
        <?= $form->field($model, 'inkunga_payable')->checkbox(array('label'=>''))
			->label('INKUNGA Payable'); ?> 
        
    </div>
    
   	
     
      
  </div>

<?= $form->field($model, 'visible_on_payslip')->checkbox(array('label'=>''))
			->label('Display On PaySlip'); ?> 
   
	   <?= $form->field($model, 'active')->checkbox(array('label'=>''))
			->label('Active'); ?>  			
			
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>



<?php

$script = <<< JS

 $(document).ready(function(){

 //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
     $(".categ-type").hide();
    
    toggleInputs($('#pay-categ').val());
    
     
    $('#pay-categ').on('change', function() {
      
      toggleInputs($(this).val());

       }); 
   
function toggleInputs(optValue){
  if(optValue!=='') {
  
  $('.categ-type').not('.'+ optValue).hide().find('input:text,input:hidden, select').prop("disabled",true);    
  $('.'+ optValue).show().find('input:text,input:hidden, select').prop("disabled",false);   
   /*if(['SD','D'].includes(optValue)){
   if($('.tax-type-e').is(':visible')){
      $('.tax-type-e').hide().find('input:text,input:hidden, select').prop("disabled",true);  
   }
  
   $('.tax-type-d').show().find('input:text,input:hidden, select').prop("disabled",false);   
     }
     
   if(['E','BASE','LPSM'].includes(optValue)){
  if($('.tax-type-e').is(':visible')){
      $('.tax-type-d').hide().find('input:text,input:hidden, select').prop("disabled",true);  
   }
  $('.tax-type-e').show().find('input:text,input:hidden, select').prop("disabled",false);   
     }*/
}
  
}
     
});

JS;
$this->registerJs($script);

?>
