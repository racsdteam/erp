<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\bootstrap4\ActiveForm;
use yii\bootstrap\ActiveForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;

?>
<style>

.sw-theme-arrows > ul.step-anchor > li > a, .sw-theme-arrows > ul.step-anchor > li > a:hover{
    
   color:#bbb !important; 
    
}
</style>

<div class="row clearfix">

<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12  ">

 <div class="card">
           
               
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
                                'id'=>'frmFile', 
                               'enableClientValidation'=>true,
                             
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                              
                               ]); ?>


                  
                 <?= Html::hiddenInput('documentid',$documentid) ?>
                 
                 <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'Attachement Name...']) ?>
              
                 <?= $form->field($model, 'comment')->textarea(['rows' => 6,'class'=>['form-control'],'placeholder'=>'Attachement Description...']) ?>
               
             
          
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



       <div class="form-group">
           
          <?= Html::submitButton(
                    'Save',
                    ['class' => 'btn btn-success float-left', 'title' => $submitTitle]
                ) ?>   
           
       </div>   
               
                
                
           


           
<?php ActiveForm::end(); ?>

 

</div>

</div>

 
 </div>

</div>
<?php


$script = <<< JS





JS;
$this->registerJs($script);

?>