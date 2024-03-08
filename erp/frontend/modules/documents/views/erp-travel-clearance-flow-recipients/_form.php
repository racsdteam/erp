<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpTravelClearanceFlowRecipients */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-travel-clearance-flow-recipients-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'flow_id')->textInput() ?>

    <?= $form->field($model, 'recipient')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'processing' => 'Processing', 'approved' => 'Approved', 'denied' => 'Denied', 'request_for_action' => 'Request for action', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sender')->textInput() ?>

    <?= $form->field($model, 'is_new')->textInput() ?>

    <?= $form->field($model, 'is_forwarded')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
