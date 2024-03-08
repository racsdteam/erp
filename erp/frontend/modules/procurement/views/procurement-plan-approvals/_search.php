<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\ProcurementPlanApprovalsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procurement-plan-approvals-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'wfInstance') ?>

    <?= $form->field($model, 'wfStep') ?>

    <?= $form->field($model, 'request') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'assigned_to') ?>

    <?php // echo $form->field($model, 'on_behalf_of') ?>

    <?php // echo $form->field($model, 'assigned_from') ?>

    <?php // echo $form->field($model, 'action_required') ?>

    <?php // echo $form->field($model, 'outcome') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'is_new') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'started_at') ?>

    <?php // echo $form->field($model, 'completed_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
