<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayStructureAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pay-structure-assignment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pay_structure')->textInput() ?>

    <?= $form->field($model, 'pay_level')->textInput() ?>

    <?= $form->field($model, 'employee')->textInput() ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
