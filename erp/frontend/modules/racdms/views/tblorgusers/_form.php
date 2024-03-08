<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\racdms\models\Tblorgusers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tblorgusers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userID')->textInput() ?>

    <?= $form->field($model, 'orgID')->textInput() ?>

    <?= $form->field($model, 'posID')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
