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
$this->title = 'Memo Supporting Doc(s) ';
$this->params['breadcrumbs'][] = $this->title;

?>

<style>

#erplporequest-severity label{
  margin-left:15px;
  padding:10px;
  color:black;
} 

#erplporequest-severity label input{
  margin-left:15px;
  padding:10px;
  color:black;
}

/*----------------------kv buttons-------------------------------------*/
.kv-action-delete{
display:none;

}
.file-preview{
    
    height:auto;
}

#tinymce .mceContentBody {

   font-family: Tahoma, Verdana, Segoe, sans-serif !important;
   font-size:16px;
}

div.form-group label{
    
    color:black;
    font-size:16px;
}
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
                                'id'=>'data-form', 
                               'enableClientValidation'=>true,
                              //'action' => ['mirror-persons/add-person','create_step'=>false],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               ]); ?>      
        
    <?= $form->field($model, 'memo')->hiddenInput(['value'=>$memo])->label(false);?>      
        
       
   <?= $form->field($model, 'doc_uploaded_files')->widget(FileInput::classname(), [
                                                 'options' => ['accept' => 'file/*'],
                                                 'pluginOptions'=>['allowedFileExtensions'=>['pdf','jpg'],'showUpload' => false,
                                                  'theme'=>'fas',
                                                 //'initialPreview'=>$model->attachement!=''? $docpreviewurl:[],
                                                 'overwriteInitial'=>true,'initialPreviewAsData'=>true,
                                                 'initialPreviewFileType'=>'image',
                                                 //'initialPreviewConfig' =>$docpreviewext,
                                                  
  ],     
                                                
                                                                                    
  ])?>
 
          <div class="form-group">
<?= Html::submitButton($model->isNewRecord ? '<i class="far fa-save"></i> Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success submit' : 'btn btn-primary submit']) ?>
</div>

<?php ActiveForm::end(); ?>            
                     
                      </div><!--card body -->  
            </div><!-- card wrapper  -->
          
           

 <!--modal -->           
 

<?php
$url=Url::to(['erp-memo-supporting-doc/get-support-docs-by-memo','id'=>$memo,'stepcontent'=>$stepcontent]); 

$script = <<< JS



$('#data-form').on('beforeSubmit', function(event) {
    
     var \$form = $(this);
    var formData = new FormData(\$form [0]);// to be able to send file
    ///\$form.attr("action")
   
   
    $.ajax({
      
        url: \$form.attr("action"),  //Server script to process data
        type: 'POST',

        // Form data
        data: formData,

       // beforeSend: beforeSendHandler, // its a function which you have to define

        success: function(response) {
          
        
           if(response['flag']==true){
          
          
             
                    Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title:response['message'],
                 showConfirmButton: false,
                 timer: 1500
                  })
  
            
          
            $.get('$url')

        .done(function (data) {

           
        $('#step-{$stepcontent}').html(data);
            
         

        })

        .fail(function () {

            console.log("Ajax fail: ");

        });       
               
            
           }else{


       
             Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title:response['message'],
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
