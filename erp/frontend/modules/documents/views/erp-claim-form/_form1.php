<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\ErpClaimForm */
/* @var $form yii\widgets\ActiveForm */
use common\models\User;
use kartik\select2\Select2;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
?>

<div class="erp-claim-form-form">
<div class="well row clearfix">

<div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12 ">

 <div class="box box-default color-palette-box">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-tag"></i> Claim Form info.</h3>
                </div>
           <div class="box-body">
     
      <?php $form = ActiveForm::begin(); ?>         
     
     <?php if(isset($t)):?>
   
    <?= $form->field($model, 'tavel_clearance')->hiddenInput(['value'=>$t])->label(false);?>
   
   
   
      <?php endif;?>
    
     
     <?= $form->field($model, 'purpose')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currancy_type')->dropDownList([ 'USD' => 'USD', 'Frw' => 'Frw', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'rate')->textInput() ?>
     <?= $form->field($model, 'day')->textInput() ?>
     
    <?= $form->field($model, 'total_amount')->textInput() ?>

    <?= $form->field($model, 'total_amount_in_word')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
  </div> <!--box body   --> 

                      
                     
                      </div><!-- end col wraper  -->  
            </div><!-- end row wraper  -->
          
            </div>
<?php
$url=Url::to(['erp-persons-in-position/populate-names']);  

$script = <<< JS

 $(function () {
    //Initialize Select2 Elements
    $(".Select2").select2();
    //$(".select3").select2();
 });
 
 
$(document).ready(function()
		{
			$('.date').bootstrapMaterialDatePicker
			({
				time: false,
				clearButton: true
			});

			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});

	});
 $('#recipients-select0').on('select2:select', function (e) {
    var ids=$(this).val();
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
    // $('#recipients-names').empty();
    $.each(array, function(i,e){
    $("#recipients-names0 option[value='" + e + "']").prop("selected", true);
    console.log(e);
   
});

//trigger change-------------otherwise not updating
$('#recipients-names0').trigger('change.select2');
    });
});

$('#recipients-select0').on('select2:unselect', function (e) {
  
  var ids=$(this).val();
  if(!jQuery.isEmptyObject(ids)){
  
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
     $('#recipients-names0').val([]);
    $.each(array, function(i,e){
    $("#recipients-names0 option[value='" + e + "']").prop("selected", true);
    console.log(e);
});


//trigger change-------------otherwise not updating
$('#recipients-names0').trigger('change.select2');

});

}else{ $('#recipients-names0').val([]);$('#recipients-names0').trigger('change.select2');}

});

//------------------------------------update doc link-------------------------------------------

JS;
$this->registerJs($script);

?>