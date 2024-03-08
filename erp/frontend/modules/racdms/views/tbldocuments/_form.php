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

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

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
                               'action'=>['tblfolders/add-document'],
                               'method' => 'post',
                              
                               ]); ?>


                  
                 <?= Html::hiddenInput('folderid', $folderid) ?>
                 
                 <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'Document Name...']) ?>
              
                 <?= $form->field($model, 'comment')->textarea(['rows' => 6,'class'=>['form-control'],'placeholder'=>'Document Description...']) ?>
               
             
          
               <?= $form->field($model, 'uploaded_file')->widget(FileInput::classname(), [
    'options' => ['accept' => 'file/*'], 'bsVersion'=>4,
     'pluginOptions' => [
                                'previewFileType' => 'image',
                                'allowedFileExtensions'=>['pdf','jpg'],
                                'showCaption' => true,
                                'showUpload' => false,
                                'browseClass' => 'btn btn-warning',
                                'browseLabel' => ' Browse file',
                                'browseIcon' => '<i class="fa  fa-folder-open-o"></i>',
                                'removeClass' => 'btn btn-danger btn-sm',
                                'removeLabel' => ' Delete',
                                'removeIcon' => '<i class="fa fa-trash"></i>',
                             
                              
                               
                            ]
]);  ?>

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
                    $isNewRecord?'<i class="fas fa-upload"></i> Save':' Update',
                    ['class' =>$isNewRecord? 'btn btn-warning float-left':'btn btn-success float-left', 'title' => $submitTitle]
                ) ?>   
           
       </div>   
               
                
                
           


           
<?php ActiveForm::end(); ?>

 


 
 </div>

</div>
<?php


$script = <<< JS



JS;
$this->registerJs($script);

?>