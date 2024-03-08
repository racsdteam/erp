<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use frontend\modules\hr\models\EmployeeDocsCategories;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpDocuments */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .invalid-feedback{
        display: block;
    }
</style>
<div class="emp-documents-form">
       <div class="card" style="color: black">
              <div class="card-header">
                  <?= Html::encode($this->title) ?>
              </div>
          <div class="card-body ">
    <?php $form = ActiveForm::begin(); ?>
   <?= $form->field($model, 'category',['template' => '
                       
                       <div class="input-group col-sm-12">
                       <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-globe-europe"></i>
                                </span>
                                
                                </div>
                       {input}
                       </div>{error}{hint}
               '])->dropDownList([ArrayHelper::map(EmployeeDocsCategories::find()->all(), 'code', 'name')], 
               ['prompt'=>'Select  Document Category','id'=>'category-id','class'=>['form-control m-select country-class']]) ?> 
    <?= $form->field($model, 'document')->textInput()->label("Document Name") ?>

    <?= $form->field($model, 'details')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'upload_file')->widget(FileInput::classname(), [
                                                 'options' => [
                                                     'accept' => 'application/pdf,',
                                                      'multiple' =>false
                                                    ],
                                                 'pluginOptions'=>[
                                                 'allowedFileExtensions'=>['pdf','PDF'],
                                                 'theme'=>'fas',
                                                 'showUpload' => false,
                                                 'browseClass' => 'btn btn-warning',
                                                 'cancelClass' => 'btn btn-danger',
                                                 'overwriteInitial'=>false,
                                                 'initialPreviewAsData'=>true,
                                                 'initialPreviewFileType'=>'image',
                                               
                                                  
  ],     
                                                
                                                                                    
  ])?>
   

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
</div>

