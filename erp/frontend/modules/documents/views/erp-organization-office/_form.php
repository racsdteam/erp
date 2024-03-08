<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpOrganizationOffice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-organization-office-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'office')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
