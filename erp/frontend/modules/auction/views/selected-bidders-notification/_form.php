<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\SelectedBiddersNotification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="selected-bidders-notification-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bidder')->textInput() ?>

    <?= $form->field($model, 'lot_id')->textInput() ?>

    <?= $form->field($model, 'notified')->textInput() ?>

    <?= $form->field($model, 'notifier')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
