<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\CompStatutoryDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comp-statutory-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'rama_pay') ?>

    <?= $form->field($model, 'rama_no') ?>

    <?= $form->field($model, 'pension_pay') ?>

    <?= $form->field($model, 'pension_no') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
