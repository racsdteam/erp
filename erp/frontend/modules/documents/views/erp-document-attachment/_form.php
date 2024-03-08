<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ErpDocumentAttachType;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii\helpers\Url;

?>

<div class="row clearfix">

<div class="<?php if(!$isAjax){echo 'col-lg-8 col-md-8 col-sm-12 col-xs-12 offset-md-2';}else{ echo 'col-lg-12 col-md-12 col-sm-12 col-xs-12';}  ?> ">

<div class="card card-default ">

 <div class="card-body">

   <?php if (Yii::$app->session->hasFlash('success')){

$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  

   }
  

  
  ?>

 

<?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data'],
                                'id'=>'dynamic-form', 
                               'enableClientValidation'=>true,
                              //'action' => ['mirror-persons/add-person','create_step'=>false],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               ]); ?>


                   
 <input name="ErpDocument[id]" id="attachements" type="hidden" value="<?php echo $id?>">
      
       <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item-row', // required: css class
        'limit' => 10, // the maximum times, an element can be added (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsAttachement[0],
        'formId' => 'dynamic-form',
        'formFields' => [
           // 'type',
            'attach_uploaded_file',
            'attach_title',
           // 'attach_description'
           
        ],
    ]); ?>
    
    
    
    
    
      <table class="table table-condensed">
        <thead>
            <tr>
                <th style="width: 40px; text-align: center"></th>
                <th colspan="2" class="text-center vcenter" >Attachement Title & Upload</th>
                
                <th style="width: 40px; text-align: center">Actions</th>
            </tr>
        </thead>
        <tbody class="container-items">
           <?php foreach ($modelsAttachement  as $i => $modelAttachement): ?>
                <tr class="item-row">
                    <td class="sortable-handle text-center vcenter" style="cursor: move;">
                       <span style="color:black;"><i class="fas fa-arrows-alt"></i></span> 
                    </td>
                    
                     
                   
                    <td colspan="2">
                         
             
                   <?= $form->field($modelAttachement, "[{$i}]attach_title")->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'Attachement Title...']) ?>     
                   
                       <?php
                            // necessary for update action.
                            if (! $modelAttachement->isNewRecord) {
                                echo Html::activeHiddenInput($modelAttachement, "[{$i}]id");
                                
                            $preview1=array();
                            $config_prev1=array();
                         
                           if(file_exists($modelAttachement->attach_upload)){
                               
                                $preview1[]=Yii::$app->request->baseUrl.'/'.$modelAttachement->attach_upload;  
                             }
                            
                             $config1=(object)[type=>"pdf",  caption=>$modelAttachement->attach_title, key=>$modelAttachement->id,
                             'url' => \yii\helpers\Url::toRoute(['erp-document-attachment/remove-attachment','id'=>$modelAttachement->id])
                             ];
                             $config_prev1[]=$config1;
                            }
                        ?> 
                         
                        <?= $form->field($modelAttachement, "[{$i}]attach_uploaded_file")->label("Attachement Upload")->widget(FileInput::classname(), [
                            'options' => [
                                'multiple' => false,
                                'accept' => 'file/*',
                                'class' => 'optionvalue-img'
                            ],
                            
                            'pluginOptions' => [
                                 'theme'=>'fas',
                                'previewFileType' => 'image',
                                'allowedFileExtensions'=>['pdf','jpg'],
                                'showCaption' => true,
                                'showUpload' => false,
                                'browseClass' => 'btn btn-success',
                                'browseLabel' => ' Browse file(s)',
                                'browseIcon' => '<i class="far fa-folder-open"></i>',
                                'removeClass' => 'btn btn-danger btn-sm',
                                'removeLabel' => ' Delete',
                                'removeIcon' => '<i class="fas fa-trash-alt"></i>',
                                'previewSettings' => [
                                    'image' => ['width' => '138px', 'height' => 'auto']
                                ],
                               'initialPreview'=>!empty($preview1)?$preview1:[],
                                                 'overwriteInitial'=>true,
                                                 'initialPreviewAsData'=>true,
                                                 'initialPreviewFileType'=>'image',
                                                 'initialPreviewConfig' =>$config_prev1,
                                                 'purifyHtml'=>true,
                                                 'uploadAsync'=>false,
                               
                            ]
                        ]) ?>
                       
                    </td>
                    <td class="text-center vcenter">
                        <button type="button" class="remove-item btn btn-danger btn-xs"><i class="fas fa-minus-circle"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td><button type="button" class="add-item btn btn-success btn-sm"><i class="fas fa-plus-circle"></i></button></td>
            </tr>
        </tfoot>
    </table>

    
    <?php DynamicFormWidget::end(); ?>



<?= Html::submitButton(' <i class="far fa-save"></i> Save', ['class' =>'btn btn-success btn-lg']) ?>


<?php ActiveForm::end(); ?>

</div>

 </div>

 </div>
 
 
 </div>



          <?php
$url2=Url::to(['erp-document/fetch-tab','id'=>$id,'active-step'=>0]);            
$script = <<< JS

$(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
    console.log("beforeInsert");
   

      
});



$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
    
    
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    console.log("Deleted item!");
});

$(".dynamicform_wrapper").on("limitReached", function(e, item) {
    alert("Limit reached");
});

$('#dynamic-form').on('beforeSubmit', function(event) {
    
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
          
         
     
          
           if(response['success']==true){
          
          

             Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title:response['message'],
                 showConfirmButton: false,
                 timer: 1500
                  })
           
          
                  
                 if('$context'=='view'){
                     
                     location.reload();
                 }else if('$context'=='wizard'){
                    
                      $.get('$url2')

        .done(function (data) {

            console.log(data);
            
            $('#step-1').html(data);
            
          

        })

        .fail(function () {

            console.log("Ajax fail: ");

        });               
                                                 
                 
               
                return true;
                 }
            
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
 }else{
     
     return true;
 } 
    
});

JS;
$this->registerJs($script);
?>

