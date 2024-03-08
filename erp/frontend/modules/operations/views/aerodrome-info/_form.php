<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\operations\models\AerodromeInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aerodrome-info-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'aerodrome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lower_runway_designator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'initial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'airport_code')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
