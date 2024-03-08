<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-category-form">
<div class="row">

             <div class="col-md-8 offset-md-2 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i> <?= Html::encode($this->title) ?> </h3>
                       </div>
    <?php $form = ActiveForm::begin(); ?>
       <div class="card-body">
    <?= $form->field($model, 'leave_category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'leave_number_days')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'leave_annual_request_frequency')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
</div>