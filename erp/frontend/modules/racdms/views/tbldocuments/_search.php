<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TbldocumentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbldocuments-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'comment') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'expires') ?>

    <?php // echo $form->field($model, 'owner') ?>

    <?php // echo $form->field($model, 'folder') ?>

    <?php // echo $form->field($model, 'folderList') ?>

    <?php // echo $form->field($model, 'inheritAccess') ?>

    <?php // echo $form->field($model, 'defaultAccess') ?>

    <?php // echo $form->field($model, 'locked') ?>

    <?php // echo $form->field($model, 'keywords') ?>

    <?php // echo $form->field($model, 'sequence') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
