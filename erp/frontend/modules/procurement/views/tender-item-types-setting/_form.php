<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderItemTypesSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tender-item-types-setting-form">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i> Tender Item Types Setting</h3>
                       </div>
               
           <div class="card-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    </div>
</div>
</div>
</div>
</div>
