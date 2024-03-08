
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\modules\hr\models\ReportTemplates;
use frontend\modules\hr\models\PayGroups;
use yii\bootstrap4\ActiveForm;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use softark\duallistbox\DualListbox;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponents */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    
    /*-----------------------------force show invalid feedback---------------------------------------------------------------*/
.invalid-feedback {
  display: block;
}

</style>
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-chart-bar"></i> New Report</h3>
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
   
     
      <?php
      
      $date_format =function($date){
        
     return  date('d/m/Y', strtotime($date));   
       }; 
   
       $months=array();
     
     for($m=1; $m<=12; $m++){
     
   
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
        $model->period_month=date("m", strtotime('m'));
        $model->period_year= date("Y"); 
        
        
     }
    
   
   
   
   $reportCategList=ArrayHelper::map(ReportTemplates::find()->all(),'code', 'name');
    
  
   ?>
     
    
 
    
    <?php $form = ActiveForm::begin(['id'=>'dynamic-form']); ?>
   
    <?= $form->field($model, 'rpt_desc')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model,  'rpt_type')->dropDownList($reportCategList, ['prompt'=>'Select Report Type',
               'id'=>'cat-id','class'=>['form-control m-select2 ']])->label("Report Type") ?> 
               
                <div class="rpt-params PAYE">
           
             <?= $form->field($model, 'pay_basis')->inline()->radioList(['SAL'=>'Salary','ALLOW'=>'Allowance','SUP'=>'Supplemental'],[
                      
                      
                    'template' => "{label}\n<div class='col-md-12 radio'>{input}</div>\n{hint}\n{error}",
                    'labelOptions' => [ 'class' => '' ],
                    'uncheckValue' => null
                    ])->label("PAYE deducted from ");?>
              
          </div> 
          
          
            <div class="rpt-params BL">
           
             <?= $form->field($model, 'list_type')->inline()->radioList(['SAL'=>'Salary','BON'=>'Bonus','LPSM'=>'LumpSum'],[
                      
                      
                    'template' => "{label}\n<div class='col-md-12 radio'>{input}</div>\n{hint}\n{error}",
                    'labelOptions' => [ 'class' => '' ],
                    'uncheckValue' => null
                    ])->label("Narration ");?>
              
          </div> 

 <?php
    $options = [
        'multiple' => true,
        'size' => 10,
    ];
    
    echo $form->field($model, 'pay_group0')->widget(DualListbox::className(),[
        'items' => ArrayHelper::map(PayGroups::find()->all(), 'code', 'name'),
        'options' => $options,
        'clientOptions' => [
            'moveOnSelect' => false,
            'selectedListLabel' => 'Selected Employees Pay Group(s)',
            'nonSelectedListLabel' => 'Available Employees Pay Groups',
        ],
    ])->label("Employees Pay Groups");
?>
   
     
      <div class="row">
          
           <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
           
           <?= $form->field($model, 'period_year',['template' => '
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
           
             <?= $form->field($model, 'period_month',['template' => '
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
   
     <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 10, // the maximum times, an element can be added (default 999)
        'min' =>0, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsAttachment[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'title',
            'upload_file',
          
           
        ],
    ]); ?>
    
<div class="table-responsive">
      <table id="tbl-attach" class="table table-condensed" >
        <thead>
            <tr>
              
                <th colspan="2" class="text-left vcenter" >Attachments</th>
                
                <th style="width: 40px; text-align: center"><i class="fas fa-cog"></i></th>
            </tr>
        </thead>
        <tbody class="container-items">
           <?php foreach ($modelsAttachment  as $i => $modelAttachment): ?>
                
                <tr class="item">
                
                    
                    <td width="40%">
                         
             
                   <?= $form->field($modelAttachment, "[{$i}]title")->textInput(['maxlength' => true,'class'=>['form-control','placeholder'=>'Title...']]) ?>     
                   
                       <?php
                            // necessary for update action.
                            if (! $modelAttachment->isNewRecord) {
                                echo Html::activeHiddenInput($modelAttachment, "[{$i}]id");
                       
                            }
                        ?> 
            
                    </td>
                    
                 
                    
                    <td>
                        
                      <?= $form->field($modelAttachment, "[{$i}]upload_file")->label("Attachement Upload")->widget(FileInput::classname(), [
                            'options' => [
                                'multiple' => false,
                                'accept' => 'file/*',
                               
                            ],
                           
                           'pluginOptions' => [
        'showPreview' => false,
        'showCaption' => true,
        'showRemove' => true,
        'showUpload' => false
    ]
                        ])->label("File Upload") ?>   
                        
                        
                    </td>
                    <td class="text-right vcenter">
                        <button type="button" class="remove-item btn btn-danger btn-xs"><i class="fas fa-minus-circle"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"></td>
                <td class="text-right vcenter"><button type="button" class="add-item btn btn-success btn-xs"><i class="fas fa-plus-circle"></i></button></td>
            </tr>
        </tfoot>
    </table>
  
    
            </div>
   
  <?php DynamicFormWidget::end(); ?>
        
    
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
     
     
 
$('.rpt-params').hide();
toggleInputs($('#cat-id').val());
 
 $('#cat-id').on('change.yii',function(){

 toggleInputs($(this).val());

});

function toggleInputs(optValue){
 
  if(optValue!=='') {
 
 $('.rpt-params').not('.'+ optValue).hide().find('input:text,input:hidden, select').prop("disabled",true);
 
  $('.'+ optValue).show().find('input:text,input:hidden, select').prop("disabled",false);
  
}
  
}


      $('#tbl-attach').DataTable( {
      destroy: true,
	  paging: false,
      lengthChange: false,
      searching: false,
      ordering: false,
      info: false,
      autoWidth: true,
       responsive: true,
      language: {
      emptyTable: " "
    }
       
     /*language : {
        "zeroRecords": " "             
    },*/
     
		
	
	} );

});
JS;
$this->registerJs($script);

$script2 = <<< JS


//------basic salary validation
function reportTypeSelect (attribute, value) {
        return $('input:radio[name="PayrollApprovalReports[rpt_type]"]:checked').val()=='PAYE';
	};
	
    

JS;
$this->registerJs($script2,$this::POS_HEAD);

?>



