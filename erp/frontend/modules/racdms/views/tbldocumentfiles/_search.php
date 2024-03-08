<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TbldocumentfilesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbldocumentfiles-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'document') ?>

    <?= $form->field($model, 'userID') ?>

    <?= $form->field($model, 'comment') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'dir') ?>

    <?php // echo $form->field($model, 'orgFileName') ?>

    <?php // echo $form->field($model, 'fileType') ?>

    <?php // echo $form->field($model, 'mimeType') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
