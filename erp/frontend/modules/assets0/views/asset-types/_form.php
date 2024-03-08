<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\file\FileInput;
use kartik\color\ColorInput;
/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmployementStatus */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    
div.invalid-feedback{
    display:block;
}    
    
</style>
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="far fa-lightbulb"></i>  Add Asset Type</h3>
                       </div>
               
           <div class="card-body">
               

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
        
        <div class="col-sm-12 col-md-4 col-lg-4">
            
              <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        
        <div class="col-sm-12 col-md-4 col-lg-4">
            
              <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
        
        <div class="col-sm-12 col-md-4 col-lg-4">
            
              <?= $form->field($model, 'color')->widget(ColorInput::classname(), [
    'options' => ['placeholder' => 'Select color ...'],
]);  ?>
        </div>
    </div>
    
           

   <?= $form->field($model, 'description')->textArea(['rows' => '4']) ?>
   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?'Save':'Update', ['class' =>$model->isNewRecord? 'btn btn-success' : 'btn btn-primary' ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>