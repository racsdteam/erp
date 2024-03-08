<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayrollsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payrolls-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'pay_group') ?>

    <?= $form->field($model, 'pay_month') ?>

    <?= $form->field($model, 'pay_year') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
