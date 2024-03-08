<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\ProcurementPlanApprovalComments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procurement-plan-approval-comments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'wfInstance')->textInput() ?>

    <?= $form->field($model, 'wfStep')->textInput() ?>

    <?= $form->field($model, 'request')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'scope')->dropDownList([ 'W' => 'W', 'T' => 'T', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
