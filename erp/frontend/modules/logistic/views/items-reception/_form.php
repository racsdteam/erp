<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ItemsReception */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="items-reception-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'item')->textInput() ?>

    <?= $form->field($model, 'item_qty')->textInput() ?>

    <?= $form->field($model, 'item_unit_price')->textInput() ?>

    <?= $form->field($model, 'item_currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_price')->textInput() ?>

    <?= $form->field($model, 'vat_included')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_id')->textInput() ?>

    <?= $form->field($model, 'dfile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'itm_desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'recv_date')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
