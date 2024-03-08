<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PcEvaluation */
/* @var $form yii\widgets\ActiveForm */

$performance_contracts_array=ArrayHelper::map($performance_contracts,"id","financial_year");

?>

<div class="pc-evaluation-form">
<div class="row clearfix">

             <div class="col-lg-8 col-md-8 offset-md-2 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i> <?= Html::encode($this->title) ?> </h3>
                       </div>
    <?php $form = ActiveForm::begin(); ?>
   <div class="card-body">
     <?= $form->field($model, 'pa_id')
        ->dropDownList($performance_contracts_array,['prompt'=>'Select type...','class'=>['form-control select2']])->label("Select Imihigo Financial Year")?>
     <?= $form->field($model, 'evaluation_period')
        ->dropDownList(["Mid Year Evaluation"=>"Mid Year Evaluation","Final Year Evaluation"=>"Final Year Evaluation",],['prompt'=>'Select type...','class'=>['form-control select2']])?>

     
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
</div>
</div>
</div>
</div>