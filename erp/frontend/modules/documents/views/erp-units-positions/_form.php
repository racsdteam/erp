<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpUnitsPositions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-units-positions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'unit_id')->textInput() ?>

    <?= $form->field($model, 'position_id')->textInput() ?>

    <?= $form->field($model, 'position_count')->textInput() ?>

    <?= $form->field($model, 'position_status')->dropDownList([ 'director' => 'Director', 'manager' => 'Manager', 'worker' => 'Worker', '' => '', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
