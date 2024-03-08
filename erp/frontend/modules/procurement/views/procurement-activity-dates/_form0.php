<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\ProcurementActivityDates */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procurement-activity-dates-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'activity')->textInput() ?>

    <?= $form->field($model, 'end_user_requirements_submission')->textInput() ?>

    <?= $form->field($model, 'tender_preparation')->textInput() ?>

    <?= $form->field($model, 'tender_publication')->textInput() ?>

    <?= $form->field($model, 'bids_opening')->textInput() ?>

    <?= $form->field($model, 'award_notification')->textInput() ?>

    <?= $form->field($model, 'contract_signing')->textInput() ?>

    <?= $form->field($model, 'contract_start')->textInput() ?>

    <?= $form->field($model, 'supervising_firm')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'updated')->textInput() ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
