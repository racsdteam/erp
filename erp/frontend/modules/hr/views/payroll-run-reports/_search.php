<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayrollApprovalReportsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payroll-approval-reports-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'report_title') ?>

    <?= $form->field($model, 'report_categ') ?>

    <?= $form->field($model, 'categ_item') ?>

    <?= $form->field($model, 'pay_period_month') ?>

    <?php // echo $form->field($model, 'pay_period_year') ?>

    <?php // echo $form->field($model, 'pay_group') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
