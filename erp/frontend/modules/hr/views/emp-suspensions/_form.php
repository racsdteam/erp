<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\modules\hr\models\Employees;
use frontend\modules\hr\models\TermReasons;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\file\FileInput;
use frontend\modules\hr\models\EmployeeDocsCategories;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpTerminations */
/* @var $form yii\widgets\ActiveForm */
?>



                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i> Suspend Employee</h3>
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

    <?php $form = ActiveForm::begin(['id'=>'dynamic-form']); ?>

   <?= $form->field($model,  'employee')->dropDownList([ArrayHelper::map(Employees::find()->active()->all(), 'id', function($model){
       
       return $model->first_name.' '.$model->last_name;
   })], ['prompt'=>'Select employee',
               'id'=>'emp-id','class'=>['form-control m-select2 ']])->label("Employee") ?> 
    <div class="row">
        
       <div class="col-sm-12 col-md-6 col-lg-6">
         <?= $form->field($model, 'susp_from')->textInput(['maxlength' => true,'class'=>['form-control date'],'placeholder'=>'Suspension Date...']) ?>   
           
       </div> 
        
        <div class="col-sm-12 col-md-6 col-lg-6">
   <?= $form->field($model, 'susp_to')->textInput(['maxlength' => true,'class'=>['form-control date'],'placeholder'=>'Suspend Until...']) ?>         
           
       </div> 
    </div>

   
    
   

   <?= $form->field($model,  'susp_reason')->dropDownList([ArrayHelper::map(TermReasons::find()->all(), 'id','name')], ['prompt'=>'Select Termination Reason',
               'id'=>'r-id','class'=>['form-control m-select2 ']])->label("Suspension Reason") ?>  

    <?= $form->field($model, 'susp_note')->textArea(['rows' => '4'])->label('Comments') ?>


    
     <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 10, // the maximum times, an element can be added (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsAttachment[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'name',
            'category',
            'upload_file',
          
           
        ],
    ]); ?>
    
<div class="table-responsive">
      <table id="tbl-attach" class="table table-condensed" >
        <thead>
            <tr>
              
                <th colspan="3" class="text-left vcenter" >Attachments</th>
                
                <th style="width: 40px; text-align: center"><i class="fas fa-cog"></i></th>
            </tr>
        </thead>
        <tbody class="container-items">
           <?php foreach ($modelsAttachment  as $i => $modelAttachment): ?>
                
                <tr class="item">
                   <td width="25%">
                        
                <?= $form->field($modelAttachment, "[{$i}]category")->dropDownList([ArrayHelper::map(EmployeeDocsCategories::find()->all(), 'code', 'name')], 
               ['prompt'=>'Select  Attachment Category','id'=>'category-id','class'=>['form-control m-select2 ']]) ?>         
                        
                    </td>
                    
                    <td width="25%">
                         
             
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
                <td colspan="3"></td>
                <td class="text-right vcenter"><button type="button" class="add-item btn btn-success btn-xs"><i class="fas fa-plus-circle"></i></button></td>
            </tr>
        </tfoot>
    </table>
  
    
            </div>
   
  <?php DynamicFormWidget::end(); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

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

?>


