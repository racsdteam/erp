<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpContact */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-contact-form">
       <div class="card" style="color: black">
              <div class="card-header">
                  <?= Html::encode($this->title) ?>
              </div>
          <div class="card-body ">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'work_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'work_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'personal_email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
