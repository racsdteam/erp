<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentFlow */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-document-flow-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'document')->textInput() ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
