<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpTravelClearanceFlow */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-travel-clearance-flow-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'requisition')->textInput() ?>

    <?= $form->field($model, 'creator')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
