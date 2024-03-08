<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TbldocumentcontentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbldocumentcontent-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'document') ?>

    <?= $form->field($model, 'version') ?>

    <?= $form->field($model, 'comment') ?>

    <?= $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'createdBy') ?>

    <?php // echo $form->field($model, 'dir') ?>

    <?php // echo $form->field($model, 'orgFileName') ?>

    <?php // echo $form->field($model, 'fileType') ?>

    <?php // echo $form->field($model, 'mimeType') ?>

    <?php // echo $form->field($model, 'fileSize') ?>

    <?php // echo $form->field($model, 'checksum') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
