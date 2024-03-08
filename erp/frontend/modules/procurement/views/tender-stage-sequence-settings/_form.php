<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use softark\duallistbox\DualListbox;
use yii\helpers\ArrayHelper;
use frontend\modules\procurement\models\TenderStageSettings;
/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderStageSequenceSettings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tender-stage-sequence-settings-form">


<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i> Tender Stage Sequency</h3>
                       </div>
               
           <div class="card-body">
    <?php $form = ActiveForm::begin(); ?>
    
    
     <?php
    $options = [
        'multiple' => false,
        'size' => 10,
    ];
    
    echo $form->field($model, 'tender_stage_setting_code')->dropDownList(ArrayHelper::map(TenderStageSettings::find()->all(), 'code', 'name'),['prompt'=>'Select type...','class'=>['form-control select2'],])->label("Tender Methodes");
?>
    <?= $form->field($model, 'sequence_number')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
</div>