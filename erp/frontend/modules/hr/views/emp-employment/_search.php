<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpEmployementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-employement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'employee') ?>

    <?= $form->field($model, 'unit') ?>

    <?= $form->field($model, 'position') ?>

    <?= $form->field($model, 'pay_type') ?>

    <?php // echo $form->field($model, 'pay_group') ?>

    <?php // echo $form->field($model, 'pay_grade') ?>

    <?php // echo $form->field($model, 'hire_date') ?>

    <?php // echo $form->field($model, 'termination_date') ?>

    <?php // echo $form->field($model, 'employement_type') ?>

    <?php // echo $form->field($model, 'supervisor') ?>

    <?php // echo $form->field($model, 'work_location') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
