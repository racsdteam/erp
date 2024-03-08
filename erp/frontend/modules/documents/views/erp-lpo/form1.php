

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use common\models\ErpLpoType;


/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */
$this->title = 'PO Issuing';
$this->params['breadcrumbs'][] = $this->title;

?>

<style>

</style>

      
    <div class="box box-default color-palette-box">
             <div class="box-header with-border">
   <h3 class="box-title"><i class="fa  fa-opencart"></i> Issue Purchase Order </h3>
 </div>  
           <div class="box-body">
  
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
            ['prompt'=>'Purchase Order Type ...','class'=>['form-control Select2'],'disabled'=>isset($model->type)]    // options
        )->label("Purchase Order Type");?>
    
   <?php if(isset($model->type)){ ?>    
   
   <?= $form->field($model, 'type')->hiddenInput(['value'=>$model->type ])->label(false);?>
   
   <?php }?>
   
     
                <?= $form->field($model, 'lpo_number')->textInput(['maxlength' => true,'class'=>['form-control','placeholder'=>'LPO Number...']]) ?>
             
     
     <?= $form->field($model, 'description')->textarea(['rows' => '3']) ?>
     
     
     <?php
     
     $po_preview_url=array();
     $image='';
     if(!$model->isNewRecord ){
         
      $po_preview_url[]=Yii::$app->request->baseUrl .'/'.$model->lpo_upload;    
      $image.=Yii::$app->request->baseUrl .'/'.$model->lpo_upload;   
     }
     
     ?>
     <?= $form->field($model, 'uploaded_file')->widget(FileInput::classname(), [
                                                 'options' => ['accept' => 'file/*'],
                                                 'pluginOptions'=>[
                                                  'allowedFileExtensions'=>['pdf','jpg','png'],
                                                  'showUpload' => false,
                                                   'showRemove' => true,
                                                  'initialPreview'=>[
                
            ],
                                                 'overwriteInitial'=>true,
                                                 'initialPreviewAsData'=>true,
                                                 'initialPreviewFileType'=>'image',
                                                 'initialPreviewConfig' =>['type'=>'pdf','key'=>1],
                                                 'initialCaption'=> $model->file_name,
                                                  
  ],     
                                                
                                                                                    
  ])?>
                  

<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-paperclip"></i> <span>Save</span>' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success submit' : 'btn btn-primary submit']) ?>



                </div> <!--box  accordion   --> 


<?php ActiveForm::end(); ?>            
                     
                      </div><!--box body -->  
           
<?php
$url=Url::to(['erp-persons-in-position/populate-names']); 
$currentContext=$context;

$script = <<< JS

$( document ).ready(function() {
  $('.Select2').select2({width:'100%'})
   $(".select2-type").select2({
    containerCssClass : "show-hide"
});
$(".show-hide").parent().parent().hide();
});


JS;
$this->registerJs($script);

?>


