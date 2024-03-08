<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\User;

use yii\db\Query;
use kartik\detail\DetailView;
/* @var $this yii\web\View */
/* @var $model common\models\ErpTravelClearance */
/* @var $form yii\widgets\ActiveForm */

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;


?>

<div class="erp-travel-clearance-form">
      <div class="box box-default color-palette-box">
        
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i> Travel Clearance</h3>
        </div>
               
           <div class="box-body">

    <?php $form = ActiveForm::begin(); ?>

            
                    <?= $form->field($model, 'position')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
    'options' => ['placeholder' => 'Select position ...','id'=>'recipients-select0'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])?>                
                    
                    <?= $form->field($model, 'employee')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(User::find()->all(), 'user_id', function($user){

      return $user->first_name." ".$user->last_name;
  })],
    'options' => ['placeholder' => 'Select names ...','id'=>'recipients-names0'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])?> 

    <?= $form->field($model, 'Destination')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reason')->textarea(['rows' => 6]) ?>

      <div class="form-group">
             

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>

                  <?= $form->field($model, 'departure_date')->textInput(['maxlength' => true,'class'=>['form-control date pull-right','placeholder'=>'interim from...']]) ?>
                  
                </div>
                <!-- /.input group -->
              </div>

 <div class="form-group">
             

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>

                  <?= $form->field($model, 'return_date')->textInput(['maxlength' => true,'class'=>['form-control date pull-right','placeholder'=>'interim to...']]) ?>
                  
                </div>
                <!-- /.input group -->
              </div>
    <?= $form->field($model, 'travel_expenses')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'flight')->textInput(['maxlength' => true]) ?>
<input type="hidden" value="<?php if(!empty($memo)) echo $memo; else echo $model->memo ?>" name="ErpTravelClearance[memo]">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="material-icons">save</i> <span>Save</span>' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])  ?>
    </div>

    <?php ActiveForm::end(); ?>


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