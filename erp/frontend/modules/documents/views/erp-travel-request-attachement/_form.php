<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;

use yii\db\Query;
use kartik\detail\DetailView;
use common\models\ErpRequisitionAttachMerge;
use common\models\ErpRequisitionRequestForAction;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpRequisitionFlow;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\file\FileInput;
use common\models\ErpMemoSupportingDocType;

use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;


/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */
$this->title = 'Add Travel Request Attachement';
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
                                'id'=>'upload-form', 
                               'enableClientValidation'=>true,
                                'action' => ['erp-travel-request-attachement/create'],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               ]); ?>      
    <?= $form->field($model, 'tr_id')->hiddenInput(['value'=>$tr_id])->label(false);?>      
        
       
  <?= $form->field($model, 'attach_files')->widget(FileInput::classname(), [
                                                 'options' => ['accept' => 'file/*'],
                                                 'pluginOptions'=>['allowedFileExtensions'=>['pdf','jpg'],'showUpload' => false,
                                                 //'initialPreview'=>$model->attachement!=''? $docpreviewurl:[],
                                                 'overwriteInitial'=>true,'initialPreviewAsData'=>true,
                                                 'initialPreviewFileType'=>'image',
                                                 //'initialPreviewConfig' =>$docpreviewext,
                                                  
  ],     
                                                
                                                                                    
  ])?>
                  

<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-paperclip"></i> <span>Attach</span>' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success submit' : 'btn btn-primary submit']) ?>



                </div> <!--box  accordion   --> 


<?php ActiveForm::end(); ?>            
                     
                      </div><!--box body -->  
           
<?php
$url=Url::to(['erp-persons-in-position/populate-names']); 
$currentContext=$context;

$script = <<< JS

console.log('{$currentContext}');

 $("#upload-form").on('beforeSubmit',function(event) {
           
   
    
    var \$form = $(this);
    var formData = new FormData(\$form [0]);// to be able to send file
   
   
    console.log(formData);
    $.ajax({
      
        url: \$form.attr("action"),  //Server script to process data
        type: 'POST',

        // Form data
        data: formData,

       // beforeSend: beforeSendHandler, // its a function which you have to define

        success: function(response) {
          
         console.log(response);
         
     
          if (response.data.success == true) {
                    showSuccessMessage(response.data.message);
                 
                 
                 if('$currentContext'=='view'){
                     
                     location.reload();
                 }else if('$currentContext'=='wizard'){
                     
                     
                       $('#smartwizard').smartWizard("reset");
                
               
                return true;
                 }
                 
              
          
          
            
           }else{



            showErrorMessage(response.data.message);

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
