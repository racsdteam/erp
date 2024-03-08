<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveApprovalTasks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-approval-tasks-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'wf')->textInput() ?>

    <?= $form->field($model, 'wfStep')->textInput() ?>

    <?= $form->field($model, 'request')->textInput() ?>

    <?= $form->field($model, 'assigned_to')->textInput() ?>

    <?= $form->field($model, 'original_assigned_to')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Completed' => 'Completed', 'Pending' => 'Pending', '' => '', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'assigned')->textInput() ?>

    <?= $form->field($model, 'completed')->textInput() ?>

    <?= $form->field($model, 'outcome')->dropDownList([ 'Approve' => 'Approve', 'Deny' => 'Deny', 'RequestChange' => 'RequestChange', '' => '', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
