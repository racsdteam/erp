<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpClaimFormApproval */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-claim-form-approval-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'claim_form')->textInput() ?>

    <?= $form->field($model, 'approved')->textInput() ?>

    <?= $form->field($model, 'approved_by')->textInput() ?>

    <?= $form->field($model, 'approval_status')->dropDownList([ 'approved' => 'Approved', 'denied' => 'Denied', 'rfa' => 'Rfa', '' => '', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_new')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>