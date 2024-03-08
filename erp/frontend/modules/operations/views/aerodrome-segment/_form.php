<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\modules\operations\models\AerodromeInfo;

/* @var $this yii\web\View */
/* @var $model frontend\modules\operations\models\AerodromeSegment */
/* @var $form yii\widgets\ActiveForm */

$aerodromes=ArrayHelper::map(AerodromeInfo::find()->all(), 'aerodrome','aerodrome') ;
?>

<div class="aerodrome-segment-form">

    <?php $form = ActiveForm::begin(); ?>
     <?= $form->field($model, 'aerodrome')->dropDownList($aerodromes,['prompt'=>'Select type...','class'=>['form-control select2'],])?>
    <?= $form->field($model, 'segment_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'sequence_number')->textInput() ?>

  


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script2 = <<< JS

$(document).ready(function(){
    $(".Select2").select2({width:'100%'});
        });

JS;
$this->registerJs($script2);
?>
