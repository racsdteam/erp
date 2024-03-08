<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\bootstrap4\ActiveForm;
use yii\bootstrap\ActiveForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use yii\db\Query;




?>
<style>

.sw-theme-arrows > ul.step-anchor > li > a, .sw-theme-arrows > ul.step-anchor > li > a:hover{
    
   color:#bbb !important; 
    
}
</style>

<div class="row clearfix">

<div class="<?php echo $isNewRecord?' col-lg-12 col-md-12 col-sm-12 col-xs-12':'col-lg-8 col-md-8 col-sm-12 col-xs-12 ' ?> ">

 <div class="card card-success">
            
               
           <div class="card-body">

 <?php if($model->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($model, ['encode' => false]) ?>
              </div>
            
            <?php endif?>
            
            


   <?php if (Yii::$app->session->hasFlash('success')){

$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  

   }
  

  
  ?>


<?php  
  $user=Yii::$app->user->identity;
  
  
  ?>


<?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data'],
                                'id'=>'frmDoc', 
                               'enableClientValidation'=>true,
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                              
                               ]); ?>


                  
                 <?= Html::hiddenInput('document', $document) ?>
           <?= $form->field($model, 'uploaded_file')->widget(FileInput::classname(), [
    'options' => ['accept' => 'file/*'], 'bsVersion'=>4,
     'pluginOptions' => [
                                'previewFileType' => 'image',
                                'allowedFileExtensions'=>['pdf','jpg'],
                                'showCaption' => true,
                                'showUpload' => false,
                                'browseClass' => 'btn btn-success',
                                'browseLabel' => ' Browse file',
                                'browseIcon' => '<i class="fa  fa-folder-open-o"></i>',
                                'removeClass' => 'btn btn-danger btn-sm',
                                'removeLabel' => ' Delete',
                                'removeIcon' => '<i class="fa fa-trash"></i>',
                             
                              
                               
                            ]
]);  ?>

 <?= $form->field($model, 'comment')->textarea(['rows' => 6,'class'=>['form-control'],'placeholder'=>'Document Description...']) ?>

 <div class="form-group">
                    <label for="docName">Expires</label>
             <?= $form->field($model, 'expires', ['template' => '
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            
                                <span class="input-group-text">
                                     <i class="fas fa-calendar-alt"></i>
                                </span>
                               
                            </div>{input}{error}{hint}
                        </div>'])->textInput(['autofocus' => true,])
                                ->input('text', ['placeholder'=>'Expires...','class'=>['form-control'],'id'=>"docName"])?>
              
            </div>

       <div class="form-group">
           
          <?= Html::submitButton(
                    $isNewRecord?'Save':'Update',
                    ['class' =>$isNewRecord? 'btn btn-primary float-left':'btn btn-success float-left', 'title' => $submitTitle]
                ) ?>   
           
       </div>   
               
                
                
           


           
<?php ActiveForm::end(); ?>

 

</div>

</div>

 
 </div>

</div>
<?php


$script = <<< JS

$(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
   
  
});

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
     
     console.log(item)
     
    // item.find(".sumPart").val();
});



JS;
$this->registerJs($script);

?>