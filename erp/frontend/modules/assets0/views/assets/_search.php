<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\massets\models\AssetsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="assets-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'manufacturer') ?>

    <?= $form->field($model, 'model') ?>

    <?php // echo $form->field($model, 'serialNo') ?>

    <?php // echo $form->field($model, 'tagNo') ?>

    <?php // echo $form->field($model, 'acq_date') ?>

    <?php // echo $form->field($model, 'ass_cond') ?>

    <?php // echo $form->field($model, 'life_span') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
