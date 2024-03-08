<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ErpDocumentAttachType;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii\db\Query;

?>

<div class="row clearfix">

<div class="<?php if(!$isAjax){echo 'col-lg-8 col-md-8 col-sm-12 col-xs-12 col-md-offset-2';}else{ echo 'col-lg-12 col-md-12 col-sm-12 col-xs-12';}  ?> ">

<div class="box box-default color-palette-box">
 
 <div class="box-body">

   <?php if (Yii::$app->session->hasFlash('success')){

$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  

   }
  

  
  ?>

  <?php 

$query3 = new Query;
         $query3	->select([
             'attch_ver_upload.*'
             
         ])->from('erp_attachment_version as attch_ver ')->join('INNER JOIN', 'erp_attachment_version_upload as attch_ver_upload',
             'attch_ver.id=attch_ver_upload.attach_version')->where(['attch_ver.attachment' =>$model->id])->orderBy([
                 'version_number' => SORT_DESC,
                 
               ]);	;

         $command3 = $query3->createCommand();
         $rows3= $command3->queryAll();
     

  
       
                          $attachpreviewurl=array();
                         $attachpreviewext=array();
  
                         if($rows3[0]['attach_upload']!=''){
                            
                            $attachpreviewurl[]=Yii::$app->request->baseUrl . '/' .$rows3[0]['attach_upload'];  
                         
                          //get the extesnion 
                            $file_name=$rows3[0]['attach_upload'];
                           
                            $array = explode('.',$file_name);
                             $extension = end($array); 
                             
                             if($extension=='pdf'){
                                  
                              $attachpreviewext[]=['type' =>'pdf', 'downloadUrl'=>false];    
                             }elseif($extension=='jpg'){
                                 
                              $attachpreviewext[]=['type' =>'image', 'downloadUrl'=>false]; 
                               
                             }
 
                         }
                           
                   
                                        
                                        ?>

<div class="guest-chickin-form">

<?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data'],
                                'id'=>'update-form', 
                               'enableClientValidation'=>true,
                              //'action' => ['mirror-persons/add-person','create_step'=>false],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               ]); ?>

 
   
 

    <div class="panel panel-default">
         
         <div class="panel-heading">
    
            <h4>
                <i class="glyphicon  glyphicon-duplicate"></i> Attachement Details
               
                
            </h4>
        </div>
        <div class="panel-body">

            <div class="container-items"><!-- widgetBody -->
           
          

                        
                        <div class="row">
                           
<div class="col-sm-12">
<div class="input-group">
                <span class="input-group-addon"><i class="fa fa-sticky-note-o"></i></span>
                <?= $form->field($model, "attach_title")->textInput(['maxlength' => true,'class'=>['form-control','placeholder'=>'Attachement Title...']]) ?>
              </div>

</div>

<div class="col-sm-12">



                                
                                 <div class="col-sm-12">
  
  <?= $form->field($model, 'attach_uploaded_file')->widget(FileInput::classname(), [
                                                 'options' => ['accept' => 'file/*'],
                                                 'pluginOptions'=>['allowedFileExtensions'=>['pdf','jpg'],'showUpload' => false,
                                                 'initialPreview'=>$rows3[0]['attach_upload']!=''? $attachpreviewurl:[],
                                                 'overwriteInitial'=>true,'initialPreviewAsData'=>true,
                                                 'initialPreviewFileType'=>'image',
                                                 'initialPreviewConfig' =>$attachpreviewext,
                                                  
  ],     
                                                
                                                                                    
  ])?>
                        
                                     </div>
                                
                                
                                </div>

                     

                      
                  
            </div>

            <div class="form-group">
<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-paperclip"></i> <span>Attach</span>' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
        </div>
    </div><!-- .panel -->
  

             





<?php ActiveForm::end(); ?>

</div>

 </div>

 </div>
 
 
 </div>

</div>

          <?php
            
$script = <<< JS

$('#update-form').on('beforeSubmit', function(event) {
    
 if('{$isAjax}'){
     
 
    
     var \$form = $(this);
    var formData = new FormData(\$form [0]);// to be able to send file
    ///\$form.attr("action")
   
    console.log(formData);
    $.ajax({
      
        url: \$form.attr("action"),  //Server script to process data
        type: 'POST',

        // Form data
        data: formData,

       // beforeSend: beforeSendHandler, // its a function which you have to define

        success: function(response) {
          
         console.log(response);
         
     
          
           if(response['success']==true){
          
          

            showSuccessMessage(response['message']);
            location.reload();
          
          
            
           }else{


       
            showErrorMessage(response['message']);
           

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
 }else{
     
     return true;
 } 
    
});
JS;
$this->registerJs($script);
?>

