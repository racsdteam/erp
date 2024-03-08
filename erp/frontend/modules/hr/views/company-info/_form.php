<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\CompanyInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'comp_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comp_reg_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
