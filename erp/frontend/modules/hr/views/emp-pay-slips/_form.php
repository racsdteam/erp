<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPaySlips */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-pay-slips-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employee')->textInput() ?>

    <?= $form->field($model, 'unit')->textInput() ?>

    <?= $form->field($model, 'position')->textInput() ?>

    <?= $form->field($model, 'pay_period')->textInput() ?>

    <?= $form->field($model, 'basic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gross_pay')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_deduction')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'net_pay')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
