<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPaySlipsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-pay-slips-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'employee') ?>

    <?= $form->field($model, 'unit') ?>

    <?= $form->field($model, 'position') ?>

    <?= $form->field($model, 'pay_period') ?>

    <?php // echo $form->field($model, 'basic') ?>

    <?php // echo $form->field($model, 'gross_pay') ?>

    <?php // echo $form->field($model, 'total_deduction') ?>

    <?php // echo $form->field($model, 'net_pay') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
