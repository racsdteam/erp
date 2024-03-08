<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpSuspensionsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-suspensions-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'employee') ?>

    <?= $form->field($model, 'susp_from') ?>

    <?= $form->field($model, 'susp_to') ?>

    <?= $form->field($model, 'last_day') ?>

    <?php // echo $form->field($model, 'susp_reason') ?>

    <?php // echo $form->field($model, 'susp_note') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
