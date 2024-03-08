<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;

use yii\db\Query;
use kartik\detail\DetailView;

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;

use wbraganca\dynamicform\DynamicFormWidget;
use kartik\file\FileInput;

use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;


/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */
$this->title = 'Add New Attachement';
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
         
       <?php  extract($params)?>
       
      
   
   <?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data'],
                                'id'=>'r-upload-form', 
                               'enableClientValidation'=>true,
                                
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               ]); ?>      
    <?= $form->field($model, 'request_id')->hiddenInput(['value'=>$request_id])->label(false);?>      
        
    <?= Html::hiddenInput('currUrl', $currentUrl) ?> 
    <?= Html::hiddenInput('stepNumber',$stepNumber) ?> 
   
       
  <?= $form->field($model, 'doc_uploaded_files[]')->widget(FileInput::classname(), [
                                                 'options' => ['accept' => 'file/*','multiple' => true],
                                                 'pluginOptions'=>['allowedFileExtensions'=>['pdf','jpg'],
                                                 'theme'=>'fas',
                                                 'showUpload' => false,
                                                 'uploadUrl' => '/erp-lpo-request-supporting-doc/create',
                                                 'overwriteInitial'=>false,
                                                 'initialPreviewAsData'=>true,
                                                 'initialPreviewFileType'=>'image',
                                               
                                                  
  ],     
                                                
                                                                                    
  ])?>
                  

<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-save"></i> <span> Save</span>' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success submit' : 'btn btn-primary submit']) ?>



                </div> <!--card  accordion   --> 


<?php ActiveForm::end(); ?>            
                     
                      </div><!--card body -->  
           
<?php




$script = <<< JS


           
   

JS;
$this->registerJs($script);

?>
