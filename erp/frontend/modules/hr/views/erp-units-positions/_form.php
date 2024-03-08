<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use common\models\ErpOrgPositions;

/* @var $this yii\web\View */
/* @var $model common\models\ErpUnitsPositions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-suitcase"></i> Add New Position to Unit</h3>
                       </div>
               
           <div class="card-body">
       

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'unit_id')->textInput(['readonly'=> true])->label('Unit'); ?>

    <?= $form->field($model, 'position_id')->dropDownList([ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position')], ['prompt'=>'Select Position',
               'id'=>'unit-id','class'=>['form-control m-select2 pos ']])->label('Position') ?> 

    <?= $form->field($model, 'position_count')->textInput()->label("Available Positions ") ?>

    <?= $form->field($model, 'report_to')->dropDownList([ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position')], ['prompt' => '','class'=>['form-control m-select2 ']]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>

<?php

$script = <<< JS

 $(document).ready(function(){


			$('.date').bootstrapMaterialDatePicker
			({
			    format: 'DD/MM/YYYY',
				time: false,
				clearButton: true
			});

			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});

     //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
    
 
     
});

JS;
$this->registerJs($script);

?>

