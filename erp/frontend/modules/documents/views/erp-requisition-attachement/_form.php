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

use yii\bootstrap4\ActiveForm;
use dosamigos\tinymce\TinyMce;


/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */
$this->title = 'Add Requisition Attachement';
$this->params['breadcrumbs'][] = $this->title;

?>

<style>

</style>

      
    <div class="card card-default ">
               
           <div class="card-body">
  
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
                                'id'=>'pr-upload-form', 
                               'enableClientValidation'=>true,
                                'action' => ['erp-requisition-attachement/create'],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               ]); ?>      
    <?= $form->field($model, 'pr_id')->hiddenInput(['value'=>$pr_id])->label(false);?>      
        
       
       
  <?= $form->field($model, 'attach_files[]')->widget(FileInput::classname(), [
                                                 'options' => ['accept' => 'file/*','multiple' => true],
                                                 'pluginOptions'=>['allowedFileExtensions'=>['pdf','jpg'],
                                                  'theme'=>'fas',
                                                 'showUpload' => false,
                                                 'uploadUrl' => '/erp-requisition-attachement/create',
                                                 'overwriteInitial'=>false,
                                                 'initialPreviewAsData'=>true,
                                                 'initialPreviewFileType'=>'image',
                                               
                                                  
  ],     
                                                
                                                                                    
  ])?>
                  

<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus-circle"></i> <span> Add</span>' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success submit' : 'btn btn-primary submit']) ?>



                </div> <!--card  accordion   --> 


<?php ActiveForm::end(); ?>            
                     
                      </div><!--card body -->  
           
<?php

$url=Url::to(['erp-requisition-attachement/get-support-docs-by-req','id'=>$pr_id,'stepcontent'=>3]); 


$script = <<< JS


 $("#pr-upload-form").on('beforeSubmit',function(event) {
           
   
   
    var \$form = $(this);
    var formData = new FormData(\$form [0]);// to be able to send file
   
 
    $.ajax({
      
        url: \$form.attr("action"),  //Server script to process data
        type: 'POST',

        // Form data
        data: formData,

       // beforeSend: beforeSendHandler, // its a function which you have to define

        success: function(response) {
          console.log(response)
          if (response.data.success == true) {
                    
                   
                    Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title:response.data.message,
                 showConfirmButton: false,
                 timer: 1500
                  })
  
            
            $.get('$url')

        .done(function (data) {

           
            
            $('#step-3').html(data);
            
          

        })

        .fail(function () {

            console.log("Ajax fail: ");

        });  
            
           }else{


  
                    Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title:response.data.message,
                 showConfirmButton: false,
                 timer: 1500
                  })
  

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
