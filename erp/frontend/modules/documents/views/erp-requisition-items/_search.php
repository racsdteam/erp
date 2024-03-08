<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpRequisitionItemsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-requisition-items-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'designation') ?>

    <?= $form->field($model, 'specs') ?>

    <?= $form->field($model, 'quantity') ?>

    <?= $form->field($model, 'badget_code') ?>

    <?php // echo $form->field($model, 'requisition_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
