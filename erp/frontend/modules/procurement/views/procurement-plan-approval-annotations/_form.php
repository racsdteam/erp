<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\ProcurementPlanApprovalAnnotations */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procurement-plan-approval-annotations-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'doc')->textInput() ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'annotation')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'annotation_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
