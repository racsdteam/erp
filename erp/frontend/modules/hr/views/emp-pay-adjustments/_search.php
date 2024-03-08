<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPayAdjustmentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-pay-adjustments-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'employee') ?>

    <?= $form->field($model, 'current_pay') ?>

    <?= $form->field($model, 'adjusted_pay') ?>

    <?= $form->field($model, 'effective_date') ?>

    <?php // echo $form->field($model, 'payout_month') ?>

    <?php // echo $form->field($model, 'reason') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
