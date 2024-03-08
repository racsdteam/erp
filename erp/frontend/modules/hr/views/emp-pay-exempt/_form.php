<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPayExempt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-pay-exempt-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employee')->textInput() ?>

    <?= $form->field($model, 'pay_id')->textInput() ?>

    <?= $form->field($model, 'tmpl_item')->textInput() ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <?= $form->field($model, 'state')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
