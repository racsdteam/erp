<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PassengerManifest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="passenger-manifest-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'check_in_sequence_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'compartment_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_of_flight')->textInput() ?>

    <?= $form->field($model, 'flight_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'from_city_airport_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'operating_carrier_pnr_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Operating_carrier_designator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passenger_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passenger_fn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passenger_ln')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passenger_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recorded')->textInput() ?>

    <?= $form->field($model, 'seat_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to_city_airport_code')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
