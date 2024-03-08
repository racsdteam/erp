<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpLpoRequestFlowRecipients */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-lpo-request-flow-recipients-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'flow_id')->textInput() ?>

    <?= $form->field($model, 'recipient')->textInput() ?>

    <?= $form->field($model, 'sender')->textInput() ?>

    <?= $form->field($model, 'is_new')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'processing' => 'Processing', 'done' => 'Done', '' => '', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
