<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\ItemsLocations */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row clearfix">

<div class="<?php if(!$isAjax){echo 'col-lg-10 col-md-10 col-sm-12 col-xs-12 offset-md-1';}else{ echo 'col-lg-12 col-md-12 col-sm-12 col-xs-12';}  ?> ">

 <div class="card card-default">
     
               
           <div class="card-body">

 <?php if($model->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($model, ['encode' => false]) ?>
              </div>
            
            <?php endif?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'loc_code')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
