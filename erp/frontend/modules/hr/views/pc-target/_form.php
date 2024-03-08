<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PcTarget */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pc-target-form">
       <div class="card" style="color: black">
              <div class="card-header">
                  <?= Html::encode($this->title) ?>
              </div>
          <div class="card-body ">

    <?php $form = ActiveForm::begin(); ?>
    <?php if($position_level!="officer"):?>
   <?= $form->field($model, 'type')->dropDownList([ 'organisation level' => 'Organisation level', 'department level' => 'Department level', 'employee level' => 'Employee level',], ['prompt' => '']) ?>
  <?= $form->field($model, "kpi_weight",['template' => '
                         {label} 
                         
                       <div class="input-group col-sm-12">
                        {input}
                        <div class="input-group-append">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-percent"></i>
                                </span>
                                
                                </div>
                       </div>{error}{hint}
               '])
                 ->textInput(['maxlength' => true,'class'=>['form-control  pull-right','placeholder'=>'target Weight']])?>
   <?php else: ?>
   <?= $form->field($model, 'type')->hiddenInput(['value'=>'Employee level'])->label(false); ?>
   <?php endif; ?>
    <?= $form->field($model, 'output')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'indicator')->textarea(['rows' => 6]) ?>

     
     <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
