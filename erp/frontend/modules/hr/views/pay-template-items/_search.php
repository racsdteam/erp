<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayStructureItemsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pay-structure-items-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pay_structure') ?>

    <?= $form->field($model, 'item') ?>

    <?= $form->field($model, 'item_categ') ?>

    <?= $form->field($model, 'calc_type') ?>

    <?php // echo $form->field($model, 'formula') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
