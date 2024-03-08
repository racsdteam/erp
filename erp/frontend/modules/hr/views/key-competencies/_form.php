<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\KeyCompetencies */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="key-competencies-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Competency')->textInput() ?>

    <?= $form->field($model, 'type')->dropDownList([ 'Core competences' => 'Core competences', 'Functional Competences' => 'Functional Competences', '' => '', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive', '' => '', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
