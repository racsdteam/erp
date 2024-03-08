<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpBanks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-banks-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_account')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_branch')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employee')->textInput() ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
