<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Tbldocumentcontent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbldocumentcontent-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'document')->textInput() ?>

    <?= $form->field($model, 'version')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'createdBy')->textInput() ?>

    <?= $form->field($model, 'dir')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'orgFileName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fileType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mimeType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fileSize')->textInput() ?>

    <?= $form->field($model, 'checksum')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
