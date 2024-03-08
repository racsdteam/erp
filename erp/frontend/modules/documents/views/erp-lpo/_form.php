

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use common\models\ErpLpoType;


/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */
$this->title = 'PO Issuing';
$this->params['breadcrumbs'][] = $this->title;

?>

<style>

</style>

   <div class="row clearfix">

<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 offset-md-1">
    
       
    <div class="card card-default ">
             <div class="card-header ">
   <h3 class="card-title"><i class="fab  fa-opencart"></i> Issue Purchase Order </h3>
 </div>  
           <div class="card-body">
  
           <?php if (Yii::$app->session->hasFlash('success')): ?>
  
           <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-thumbs-o-up"></i></h4>
                <?php  echo Yii::$app->session->getFlash('success')  ?>
              </div>

<?php endif; ?>

<?php if($model->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($model, ['encode' => false]) ?>
              </div>
            
            <?php endif?>
            
           <!----------------------------------------------------------------->
    
  
   
   <?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data'],
                                'id'=>'upload-form', 
                               'enableClientValidation'=>true,
                                //'action' => ['erp-travel-request-attachement/create'],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               ]); ?>      
   
     
     <?= $form->field($model, 'lpo_request_id')->hiddenInput(['value'=>$lpo_request_id ])->label(false);?>
     
       
  
    
    <?php $items=ArrayHelper::map(ErpLpoType::find()->all(), 'code', 'type'); ?>
                    <?= $form->field($model, 'type')
        ->dropDownList(
            $items,           // Flat array ('id'=>'label')
            ['prompt'=>'Purchase Order Type ...','class'=>['form-control m-select2'],'disabled'=>isset($model->type)]    // options
        )->label("Purchase Order Type");?>
    
   <?php if(isset($model->type)){ ?>    
   
   <?= $form->field($model, 'type')->hiddenInput(['value'=>$model->type ])->label(false);?>
   
   <?php }?>
   
     
                <?= $form->field($model, 'lpo_number')->textInput(['maxlength' => true,'class'=>['form-control','placeholder'=>'LPO Number...']]) ?>
             
     
     <?= $form->field($model, 'description')->textarea(['rows' => '3']) ?>
     
     
     <?php
     
     if(!$model->isNewRecord ){
         
     $preview[]=Yii::$app->request->baseUrl."/".$model->lpo_upload;
                             $config=(object)['type'=>"pdf",  'caption'=>$model->file_name, 'key'=>$model->id ,
                             'url' => \yii\helpers\Url::toRoute(['erp-lpo/delete-attachement','id'=>$model->id]),
                             'downloadUrl'=>Yii::$app->request->baseUrl."/".$model->lpo_upload];
                             $config_prev[]=$config;
     }
     
     ?>
     
     <?= $form->field($model, 'uploaded_file[]')->widget(FileInput::classname(), [
                                                 'options' => ['accept' => 'file/*','multiple'=>true],
                                                 'pluginOptions'=>[
                                                     'theme'=>'fas',
                                                     'allowedFileExtensions'=>['pdf','jpg'],
                                                      'showUpload' => false,
                                                      'uploadUrl' => '/erp-lpo/create',
                                                       'initialPreview'=>!empty($preview)?$preview:[],
                                                       'overwriteInitial'=>true,
                                                       'initialPreviewAsData'=>true,
                                                       'initialPreviewFileType'=>'image',
                                                       'initialPreviewConfig'=>$config_prev,
                                                   
                                                   
                                                  
  ],     
                                                
                                                                                    
  ])?>        

<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-paperclip"></i> <span>Save</span>' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success submit' : 'btn btn-primary submit']) ?>



                </div> <!--card  accordion   --> 


<?php ActiveForm::end(); ?>            
                     
                      </div><!--card body -->  
           
<?php



$script = <<< JS

$( document ).ready(function() {
 
  $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
 
});


JS;
$this->registerJs($script);

?>


