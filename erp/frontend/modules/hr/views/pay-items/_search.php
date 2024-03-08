<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pay-components-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'edCode') ?>

    <?= $form->field($model, 'edDesc') ?>

    <?= $form->field($model, 'edType') ?>

    <?= $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'display_order') ?>

    <?php // echo $form->field($model, 'affect_net_salary') ?>

    <?php // echo $form->field($model, 'base') ?>

    <?php // echo $form->field($model, 'recurringEd') ?>

    <?php // echo $form->field($model, 'adhocEd') ?>

    <?php // echo $form->field($model, 'variableEd') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
