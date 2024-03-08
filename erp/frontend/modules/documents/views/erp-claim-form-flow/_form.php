<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpClaimFormFlow */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-claim-form-flow-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'claim_form')->textInput() ?>

    <?= $form->field($model, 'creator')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
