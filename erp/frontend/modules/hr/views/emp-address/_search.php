<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpAddressSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-address-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'employee') ?>

    <?= $form->field($model, 'country') ?>

    <?= $form->field($model, 'province') ?>

    <?= $form->field($model, 'district') ?>

    <?php // echo $form->field($model, 'sector') ?>

    <?php // echo $form->field($model, 'village') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'address') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
