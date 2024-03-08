<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpTermAttachments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-term-attachments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'term')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fileName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dir')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fileType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mimeType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
