<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\color\ColorInput;
/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderStageSettings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tender-stage-settings-form">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i> Tender process stage Form</h3>
                       </div>
               
           <div class="card-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
     <?= $form->field($model, 'in_charge')->dropDownList(["ITC"=>"ITC","PROCUREMNET"=>"PROCUREMNET","BIDDER"=>"BIDDER",], ['prompt'=>'Select In Charge',
               'class'=>['form-control m-select2 ']])->label("In Charge") ?> 

    <?= $form->field($model, 'min_period')->textInput() ?>

    <?= $form->field($model, 'max_period')->textInput() ?>
    

    <?= $form->field($model, 'stage_outcome')->textInput(['maxlength' => true]) ?>
 
    
    <?= $form->field($model, 'color_code')->widget(ColorInput::classname(), [
    'options' => ['placeholder' => 'Select color ...'],
      ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
</div>
