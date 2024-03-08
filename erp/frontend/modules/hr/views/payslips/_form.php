<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\Payslips */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payslips-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employee')->textInput() ?>

    <?= $form->field($model, 'base_pay')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_period')->textInput() ?>

    <?= $form->field($model, 'org_unit')->textInput() ?>

    <?= $form->field($model, 'position')->textInput() ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
