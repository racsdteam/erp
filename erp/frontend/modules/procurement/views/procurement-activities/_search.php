<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\ProcurementActivitiesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procurement-activities-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'planId') ?>

    <?= $form->field($model, 'end_user_org_unit') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'procurement_category') ?>

    <?php // echo $form->field($model, 'procurement_method') ?>

    <?php // echo $form->field($model, 'funding_sources') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'updated') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
