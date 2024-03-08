<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpLpoRequestFlow */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-lpo-request-flow-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lpo_request')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
