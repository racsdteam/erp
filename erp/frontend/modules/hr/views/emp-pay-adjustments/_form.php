<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPayAdjustments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-pay-adjustments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employee')->textInput() ?>

    <?= $form->field($model, 'current_pay')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'adjusted_pay')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'effective_date')->textInput() ?>

    <?= $form->field($model, 'payout_month')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reason')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
