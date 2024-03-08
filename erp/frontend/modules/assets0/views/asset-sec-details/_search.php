<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\assets0\models\AssetSecDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asset-sec-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'asset') ?>

    <?= $form->field($model, 'category') ?>

    <?= $form->field($model, 'product') ?>

    <?= $form->field($model, 'product_code') ?>

    <?php // echo $form->field($model, 'vendor') ?>

    <?php // echo $form->field($model, 'enabled') ?>

    <?php // echo $form->field($model, 'install_date') ?>

    <?php // echo $form->field($model, 'up_to_date') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
