<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ErpMemoAnnotations */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="erp-memo-annotations-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'doc')->textInput() ?>

    <?= $form->field($model, 'annotation')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'author')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
