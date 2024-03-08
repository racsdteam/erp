<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpStatutoryDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-statutory-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'employee') ?>

    <?= $form->field($model, 'rama_pay') ?>

    <?= $form->field($model, 'rama_no') ?>

    <?= $form->field($model, 'mmi_pay') ?>

    <?php // echo $form->field($model, 'mmi_no') ?>

    <?php // echo $form->field($model, 'pension_pay') ?>

    <?php // echo $form->field($model, 'pension_no') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
