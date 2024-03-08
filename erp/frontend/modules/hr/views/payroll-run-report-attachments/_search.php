<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayrollRunReportAttachmentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payroll-run-report-attachments-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'term') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'category') ?>

    <?= $form->field($model, 'fileName') ?>

    <?php // echo $form->field($model, 'dir') ?>

    <?php // echo $form->field($model, 'fileType') ?>

    <?php // echo $form->field($model, 'mimeType') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
