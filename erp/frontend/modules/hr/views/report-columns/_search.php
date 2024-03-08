<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\ReportColumnsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-columns-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'report') ?>

    <?= $form->field($model, 'dataset') ?>

    <?= $form->field($model, 'field') ?>

    <?= $form->field($model, 'display_name') ?>

    <?php // echo $form->field($model, 'display_order') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
