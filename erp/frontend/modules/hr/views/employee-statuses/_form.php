<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmployementStatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="far fa-lightbulb"></i>  Add New Employement Status</h3>
                       </div>
               
           <div class="card-body">
               

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
        
        <div class="col-sm-12 col-md-6 col-lg-6">
            
              <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        
        <div class="col-sm-12 col-md-6 col-lg-6">
            
              <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

   <?= $form->field($model, 'description')->textArea(['rows' => '4']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?'Save':'Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>