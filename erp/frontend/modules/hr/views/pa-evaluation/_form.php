<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PaEvaluation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pa-evaluation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pa_id')->textInput() ?>

    <?= $form->field($model, 'emp_id')->textInput() ?>

    <?= $form->field($model, 'emp_pos')->textInput() ?>

    <?= $form->field($model, 'type')->dropDownList([ 'Mid Year Evaluation' => 'Mid Year Evaluation', 'Final Year Evaluation' => 'Final Year Evaluation', '' => '', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'supervisor_1')->textInput() ?>

    <?= $form->field($model, 'supervisor_2')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
