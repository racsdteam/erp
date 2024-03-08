<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\ReportColumns */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-columns-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'report')->textInput() ?>

    <?= $form->field($model, 'dataset')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'field')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'display_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'display_order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
