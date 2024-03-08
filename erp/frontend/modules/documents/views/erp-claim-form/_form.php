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

<div class="col-xs-12 ol-sm-12 col-md-8 col-lg-8  col-md-offset-2">

 <div class="box box-default color-palette-box">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-tag"></i> Claim Form info.</h3>
                </div>
           <div class="box-body">
             
               <div class="form-group">
       <label> Is this Claim form for a travel clearance?</label>
   
<select name="formelement[registration_status]" class="form-control Select2 valid" data-validation="required" 
onchange="if(this.value=='Yes'){$('#travel').show('slow');$('#employee').hide('slow');}else{$('#employee').show('slow');$('#travel').hide('slow');}">
         <option value="">-- Select --</option>
         <option value="Yes" <?php if(!empty($model->id)) echo "selected"; ?>>YES</option>
         <option value="No" <?php if(!empty($model2->id)) echo "selected"; ?> >NO</option>
						 
</select>
</div>
   
 <div class="form-group" id="travel" style="<?php if(empty($model->id)|| !empty($model2->id)) echo "display:none"; ?>">
       
        <?php $form = ActiveForm::begin( ['enableClientValidation' => true]); ?>
       
       <label> Travel Clearance  employee name / destination / departure date</label>
          <select class="form-control Select2" style="width: 100%;" name="ErpClaimForm[tavel_clearance]" data-validation="required">
                <?php
                
$q22 =" SELECT s.signature,p.id,u.first_name,u.last_name,a.id,a.Destination,a.departure_date,u.user_id FROM 
  erp_travel_clearance as a
   inner join user as u on u.user_id=a.employee 
  inner join erp_persons_in_position as pp  on pp.person_id=u.user_id
 inner join erp_org_positions as p  on p.id=pp.position_id
 left join signature as s on u.user_id=s.user where a.status='approved'";
$command22 =Yii::$app->db->createCommand($q22);
$rows22= $command22->queryAll();



                foreach($rows22 as $row22): 
                $q222 = new Query;
$q222->select(['c.*'])->from('`erp_claim_form` as c')->where(['c.tavel_clearance' =>$row22['id']]);
$command222 = $q222->createCommand();
$row222= $command222->queryAll();
               if(empty($row222)) 
               {
                   
               
                ?> 
                <option value="<?= $row22['id'] ?>"><?= $row22['first_name']." ".$row22['last_name']." / ".$row22['Destination']." / ".$row22['departure_date']  ?> </option>
                 <?php
                 }
                 endforeach;?>
          </select>
          
          <?= $form->field($model, 'purpose')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currancy_type')->dropDownList([ 'USD' => 'USD', 'Frw' => 'Frw', ], ['prompt' => '','class'=>'Select2', 'style' => 'width:100% !important', ]) ?>

    <?= $form->field($model, 'rate')->textInput() ?>
     <?= $form->field($model, 'day')->textInput() ?>
     
    <?= $form->field($model, 'total_amount')->textInput() ?>

    <?= $form->field($model, 'total_amount_in_word')->textInput(['maxlength' => true]) ?>
                
           <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
          
          <?php ActiveForm::end(); ?> 
          
           </div>
          
         
          
         
           
            <div class="form-group" id="employee"  style="<?php if(empty($model->id)) echo "display:none"; ?>" >
                
                 <?php $form = ActiveForm::begin(); ?>
           
           <?php $positions=ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position');
            
           
           ?>
           
         
         
         
              <?= $form->field($model, 'position')->widget(Select2::classname(), [
    'data' => $positions,
    'options' => ['placeholder' => 'Select position ...','id'=>'recipients-select0'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])?>                
                      
                    <?= $form->field($model, 'person')->widget(Select2::classname(), [
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
    <?= $form->field($model2, 'pariculars')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model2, 'country')->textInput(['maxlength' => true]) ?>
  <div class="form-group">
             

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>

                  <?= $form->field($model2, 'from')->textInput(['maxlength' => true,'class'=>['form-control date pull-right','placeholder'=>'interim from...']]) ?>
                  
                </div>
                <!-- /.input group -->
              </div>

 <div class="form-group">
             

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>

                  <?= $form->field($model2, 'to')->textInput(['maxlength' => true,'class'=>['form-control date pull-right','placeholder'=>'interim to...']]) ?>
                  
                </div>
                <!-- /.input group -->
              </div>
    <?= $form->field($model, 'purpose')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currancy_type')->dropDownList([ 'USD' => 'USD', 'Frw' => 'Frw', ], ['prompt' => '','class'=>'Select2', 'style' => 'width:100% !important',]) ?>

    <?= $form->field($model, 'rate')->textInput() ?>
     <?= $form->field($model, 'day')->textInput() ?>
     
    <?= $form->field($model, 'total_amount')->textInput() ?>

    <?= $form->field($model, 'total_amount_in_word')->textInput(['maxlength' => true]) ?>

<div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
          
          <?php ActiveForm::end(); ?> 

 </div>
 
  
          
   

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
   // $(".select2").select2();
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