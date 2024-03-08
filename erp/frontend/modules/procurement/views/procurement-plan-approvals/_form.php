<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\ProcurementPlanApprovals */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procurement-plan-approvals-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'wfInstance')->textInput() ?>

    <?= $form->field($model, 'wfStep')->textInput() ?>

    <?= $form->field($model, 'request')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'assigned_to')->textInput() ?>

    <?= $form->field($model, 'on_behalf_of')->textInput() ?>

    <?= $form->field($model, 'assigned_from')->textInput() ?>

    <?= $form->field($model, 'action_required')->dropDownList([ 'Approval' => 'Approval', 'Review' => 'Review', 'FYI' => 'FYI', 'Update' => 'Update', 'Stamping' => 'Stamping', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'outcome')->dropDownList([ 'approved' => 'Approved', 'rejected' => 'Rejected', 'reassigned' => 'Reassigned', 'reviewed' => 'Reviewed', 'change requested' => 'Change requested', 'resubmitted' => 'Resubmitted', 'verified' => 'Verified', 'Certified' => 'Certified', 'stamped' => 'Stamped', 'archived' => 'Archived', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'pending' => 'Pending', 'completed' => 'Completed', 'acknowledged' => 'Acknowledged', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'is_new')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'started_at')->textInput() ?>

    <?= $form->field($model, 'completed_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
