<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPayRemoval */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-pay-removal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employee')->textInput() ?>

    <?= $form->field($model, 'pay_structure')->textInput() ?>

    <?= $form->field($model, 'pay_structure_item')->textInput() ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
