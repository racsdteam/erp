<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PcReportOther */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pc-report-other-form">
       <div class="card" style="color: black">
              <div class="card-header">
                  <?= Html::encode($this->title) ?>
              </div>
          <div class="card-body ">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_name')->textInput(['maxlength' => true]) ?>
   <?= $form->field($model, 'status')->dropDownList([ 'green' => 'Green', 'yellow' => 'Yellow', 'red' => 'Red',], ['prompt' => 'Select status','class'=>['select2']]) ?>
 <div class="form-group">
             

                <div class="input-group">
                 
                  <div class="input-group-addon">
                
                    <i class="fa fa-calendar-alt"></i>
                  </div>
</div>
                           <!-- /.input group -->
                  <?= $form->field($model, 'start_date')->textInput(['maxlength' => true,'class'=>['form-control date pull-right','placeholder'=>'Starting date...']]) ?>
                
                
              </div>  
               <div class="form-group">
             

                <div class="input-group">
                 
                  <div class="input-group-addon">
                
                    <i class="fa fa-calendar-alt"></i>
                  </div>
</div>
                           <!-- /.input group -->
                  <?= $form->field($model, 'end_date')->textInput(['maxlength' => true,'class'=>['form-control date pull-right','placeholder'=>'Ending date...']]) ?>
                
                
              </div>  
    <?= $form->field($model, 'project_description')->widget(TinyMce::className(), [
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

    <?= $form->field($model, 'completed_work')->widget(TinyMce::className(), [
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
]); ?>

 
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
				maxDate : new Date(),
				disabledDays: [6,7],
			});
			 $(function () {
   
    $(".select2").select2({width:'100%'});
    
 });

        });

JS;
$this->registerJs($script2);
?>
