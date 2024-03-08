<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use yii\db\Query;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpRequisitionFlow;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */
$this->title = 'Import Items From Excel';
$this->params['breadcrumbs'][] = $this->title;

?>

<style>

</style>

      
    <div class="box box-default color-palette-box">
               
           <div class="box-body">
  
           <?php if (Yii::$app->session->hasFlash('success')): ?>
  
           <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-thumbs-o-up"></i></h4>
                <?php  echo Yii::$app->session->getFlash('success')  ?>
              </div>

<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('failure')): ?>
 
 <div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                 <?php  echo Yii::$app->session->getFlash('failure')  ?>
               </div>
 
 
         <?php endif; ?> 
   
   <?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data'],
                                'id'=>'excel-upload', 
                               'enableClientValidation'=>true,
                                'action' => ['erp-requisition-items/excel-import'],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               ]); ?>  
                               
                                    <?php
                    
                              
                             $config=(object)['type'=>"office",  'caption'=>'Requisition.xlsx', 'key'=>1];
                             $config_prev[]=$config;
                        
                    
                    
                   
                    
                    ?>
       
         <?= $form->field($model, 'excel_file')->widget(FileInput::classname(), [
                                                 'options' => ['accept' => 'file/*','multiple' => false],
                                                 'pluginOptions'=>['allowedFileExtensions'=>['xlsx', 'xls'],
                                                 'showUpload' => false,
                                                 'uploadUrl' => '/erp-requisition-item/excel-import',
                                                 'overwriteInitial'=>false,
                                                 'initialPreviewAsData'=>true,
                                                 'initialPreviewFileType'=>'image',
                                                 'initialPreviewConfig'=>$config_prev,
                                               
                                                  
  ],     
                                                
                                                                                    
  ])?>
                  

<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-upload"></i> <span>Upload</span>' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success submit' : 'btn btn-primary submit']) ?>



                </div> <!--box  accordion   --> 


<?php ActiveForm::end(); ?>            
                     
                      </div><!--box body -->  
           
<?php




$script = <<< JS


 $("#excel-upload").on('beforeSubmit',function(event) {
           
   
    
    var \$form = $(this);
    var formData = new FormData(\$form [0]);// to be able to send file
   
 
    $.ajax({
      
        url: \$form.attr("action"),  //Server script to process data
        type: 'POST',

        // Form data
        data: formData,

       // beforeSend: beforeSendHandler, // its a function which you have to define

        success: function(data) {
          
          if(data && data.length)
          
          console.log(data)
          
          for (var key in data) {
              
           
     /*event.preventDefault();*/
    jQuery(".dynamicform_wrapper2").triggerHandler("beforeInsert", [jQuery(this)]);
    jQuery(".dynamicform_wrapper2").yiiDynamicForm("addItem", dynamicform_fe58d1c6, event, jQuery(this));
      $('#erprequisitionitems-'+i+'-designation ').val(data[0]);
              
            
          }
        
            
            
        },

        error: function(){
            alert('ERROR at PHP side!!');
        },


        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false,
       
    });

  
return false;//prevent the modal from exiting  
      
        });

JS;
$this->registerJs($script);

?>
