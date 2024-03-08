<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveApprovalFlow */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-approval-flow-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'request')->textInput() ?>

    <?= $form->field($model, 'originator')->textInput() ?>

    <?= $form->field($model, 'approver')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'processing' => 'Processing', 'done' => 'Done', 'pending' => 'Pending', 'returned' => 'Returned', 'completed' => 'Completed', 'archived' => 'Archived', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_new')->textInput() ?>

    <?= $form->field($model, 'is_copy')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
