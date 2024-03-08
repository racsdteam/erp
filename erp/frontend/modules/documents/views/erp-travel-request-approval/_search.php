<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpTravelRequestApprovalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-travel-request-approval-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tr_id') ?>

    <?= $form->field($model, 'approval_status') ?>

    <?= $form->field($model, 'approved_by') ?>

    <?= $form->field($model, 'approved') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'is_new') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
