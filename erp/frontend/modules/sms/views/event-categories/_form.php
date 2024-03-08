<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sms\models\EventCategories */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .custom-checkbox{margin-right:15px;}
    .input-group > .select2-container--bootstrap4 {
    width: auto important!;
    flex: 1 1 auto important!;
}

.input-group > .select2-container--bootstrap4 .select2-selection--single {
    height: 100% important!;
    line-height: inherit important!;
    padding: 0.5rem 1rem important!;
}

    
</style>
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i>  <?= Html::encode($this->title) ?></h3>
                       </div>
               
           <div class="card-body">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'is_aircraft_related')->radioList([1 => 'yes', 0 => 'No'])->label('This Event Category Include Aircraft'); ?> 


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
