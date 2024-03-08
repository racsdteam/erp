<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\hr\models\PcTarget;
use frontend\modules\hr\models\PcEvaluation;
use frontend\modules\hr\models\PerformanceContract;
use yii\helpers\ArrayHelper;
use dosamigos\tinymce\TinyMce;
/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PcTargetAchievedResult */
/* @var $form yii\widgets\ActiveForm */

$pc_evaluation=PcEvaluation::find()->where(["id"=>$evaluation_id])->one();
$pc_info=PerformanceContract::find()->where(["id"=>$pc_evaluation->pa_id])->one();
$pc_tagerts=ArrayHelper::map(PcTarget::find()->where(['pa_id'=>$pc_info->id])->all(), 'id','output');

?>

<div class="pc-target-achieved-result-form">
       <div class="card" style="color: black">
              <div class="card-header">
                  <?= Html::encode($this->title) ?>
              </div>
          <div class="card-body ">
              
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'target_id')->dropDownList($pc_tagerts, ['prompt' => 'Select Targert Output','class'=>['select2']])->label("Target Output") ?>
 <?= $form->field($model, 'status')->dropDownList([ 'red' => 'Red', 'yellow' => 'Yellow', 'green' => 'Green', ], ['prompt' => 'Select Current status','class'=>['select2']])->label("Current status") ?>
    <?= $form->field($model, 'deliverable')->widget(TinyMce::className(), [
    'options' => ['rows' => 5],
    'language' => 'en',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    ]
]);?>

    <?= $form->field($model, 'indicator')->widget(TinyMce::className(), [
    'options' => ['rows' => 5],
    'language' => 'en',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    ]
]);?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
<?php
$script2 = <<< JS

$(document).ready(function(){
 //-------------------------=========initialize dates and time widgets================--------------------------------------  
   	    
			$('.date').bootstrapMaterialDatePicker
			({
				time: false,
				clearButton: true,
				minDate : new Date(),
				disabledDays: [6,7],
			});
			 $(function () {
   
    $(".select2").select2({width:'100%'});
    
 });

        });

JS;
$this->registerJs($script2);
?>
