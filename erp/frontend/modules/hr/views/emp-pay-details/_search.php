<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPayDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-pay-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'employee') ?>

    <?= $form->field($model, 'unit') ?>

    <?= $form->field($model, 'position') ?>

    <?= $form->field($model, 'pay_grade') ?>

    <?php // echo $form->field($model, 'pay_type') ?>

    <?php // echo $form->field($model, 'pay_frequency') ?>

    <?php // echo $form->field($model, 'basic') ?>

    <?php // echo $form->field($model, 'pay_group') ?>

    <?php // echo $form->field($model, 'pay_structure') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
