<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\massets\models\AssetAllocationsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asset-allocations-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'asset') ?>

    <?= $form->field($model, 'ass_cond') ?>

    <?= $form->field($model, 'org_unit') ?>

    <?= $form->field($model, 'owner') ?>

    <?php // echo $form->field($model, 'allocation_date') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
