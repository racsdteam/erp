<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\ContributionsReportsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contributions-reports-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'contribution') ?>

    <?= $form->field($model, 'pay_period_from') ?>

    <?= $form->field($model, 'pay_period_to') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
