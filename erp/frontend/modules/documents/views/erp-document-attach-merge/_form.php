<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentAttachMerge */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-document-attach-merge-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'document')->textInput() ?>

    <?= $form->field($model, 'attachement')->textInput() ?>

    <?= $form->field($model, 'visible')->dropDownList([ 0 => '0', 1 => '1', '' => '', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
