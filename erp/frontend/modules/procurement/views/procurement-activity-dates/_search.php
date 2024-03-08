<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\ProcurementActivityDatesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procurement-activity-dates-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'activity') ?>

    <?= $form->field($model, 'end_user_requirements_submission') ?>

    <?= $form->field($model, 'tender_preparation') ?>

    <?= $form->field($model, 'tender_publication') ?>

    <?php // echo $form->field($model, 'bids_opening') ?>

    <?php // echo $form->field($model, 'award_notification') ?>

    <?php // echo $form->field($model, 'contract_signing') ?>

    <?php // echo $form->field($model, 'contract_start') ?>

    <?php // echo $form->field($model, 'supervising_firm') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'updated') ?>

    <?php // echo $form->field($model, 'user') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
