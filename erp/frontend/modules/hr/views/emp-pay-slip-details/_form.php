<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPaySlipDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-pay-slip-details-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pay_slip')->textInput() ?>

    <?= $form->field($model, 'item_categ')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'item')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
