<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpDocumentVersionAttach */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-document-version-attach-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'version')->textInput() ?>

    <?= $form->field($model, 'attachment')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
