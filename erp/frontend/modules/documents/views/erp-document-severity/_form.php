<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentSeverity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-document-severity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'severity')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
