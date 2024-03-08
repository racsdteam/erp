<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentRequestForAction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-document-request-for-action-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'document')->textInput() ?>

    <?= $form->field($model, 'action')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'requested_by')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
