<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;

use common\models\User;
use yii\helpers\ArrayHelper;


use kartik\select2\Select2;

use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpRequisition;
use common\models\ErpMemo;
use yii\db\Query;

?>
<style>
.select2 {
/*width:100%!important;*/
}

.myDiv{
	display:none;
}
#employees-names01{
 display:none;   
}

.action-hidden{display:none;}

#erpdocument-action label:not(:first-child){padding-left:10px;}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #3c8dbc !important;
    border: 1px solid #aaa;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-top: 5px;
    padding: 0 5px;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    margin-right: 5px;
    color: rgba(255,255,255,0.7) !important;
}

</style>



<?php  
  $user=Yii::$app->user->identity;
  
   
if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
  
  ?>

  
 <div class="card card-default text-dark">
 <div class="card-header">
   <h3 class="card-title"><i class="fas fa-handshake"></i> Approvals  </h3>
 </div>
 <div class="card-body"> 
  
 
<?php
 $user=Yii::$app->user->identity->user_id;
 
 $_qry1=" SELECT DISTINCT u.user_id,u.first_name,u.last_name, p.position,f.timestamp FROM user as u 
inner join  erp_document_flow_recipients  as f on f.recipient=u.user_id 
inner join erp_persons_in_position as pp on u.user_id=pp.person_id 
inner join erp_org_positions as p on p.id=pp.position_id where f.document='".$model->id."' order by f.timestamp desc";
$command9= Yii::$app->db->createCommand($_qry1);
$_approver = $command9->queryOne();



$q7=" SELECT up.position_level as level,p.id,p.position_code FROM  erp_units_positions as up inner join erp_org_positions as p on up.position_id=p.id
inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  pp.person_id='".$user."' and pp.status=1";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne();

$pos_code= $row7['position_code'];

 $q77=" SELECT u.user_id FROM  user as u  inner join   erp_persons_in_position as pp on u.user_id=pp.person_id 
 inner join erp_org_positions as p  on p.id=pp.position_id
  where p.position_code='ADVMD' and pp.status=1 ";
  $command77= Yii::$app->db->createCommand($q77);
  $row77 = $command77->queryOne();
  
    
  $date = date('Y-m-d');
  $date=date('Y-m-d', strtotime($date));
  
$row888 =Yii::$app->muser->getInterim($user,$row77['user_id'],$date);

//-------------------disable settings----------------------------------------------------------
if(in_array($pos_code,array('AAMD','DMD','ADVMD')) ||  $row888 != null){

    $disabled=false;
}else{
    
    $disabled=true;
}



 $items=array();
                  $items['2']='Forward';
                  
                 
                  if($row7['level']=='director' || $row7['position_code']=='ITENG'){
                      $items['3']='Approve';
  
                     }
                  $items['4']='Close';
                  
                  
                  
                  //default open action
                  $model->action=2;
                  
                  
                  
                  
    $form = ActiveForm::begin([
        'id'=>'action-form1', 
    'options' => [
	//	'class' => 'radio',
		
	],
       ]);

?> 

               <?php 
                 
                  
                  
                  
                  echo $form->field($model, 'action')->inline(true)->radioList($items,['class'=>'radios'])->label(false);?>
                  


<!--  --------------------------------change requested----------------------------------------------------->
<?php
   ActiveForm::end();
                            
 ?>                  
                  
              <div id="form1" class="myDiv">
	<h3>Select Next Recipient/Approver</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form1', 
         'action' => ['erp-document/work-flow'],
        'method' => 'post'
       ]);


?>

    
   
  	 <?= $form->field($model, 'position')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
    'options' => ['placeholder' => 'Select Employee(s) ...','id'=>'employees-select',
    
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Employee(s) Position')?>                
                    
                    <?= $form->field($model, 'employee')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(User::find()->all(), 'user_id', function($user){

      return $user->first_name." ".$user->last_name;
  })],
    'options' => ['placeholder' => 'Employee(s) Names...','id'=>'employees-names'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Employee(s) Names')?> 

<?= $form->field($model, 'remark')->textarea(['id'=>'hidden_text1','rows' => '6']) ?>
<?= Html::submitButton('<i class="glyphicon glyphicon-send"></i> Send ', ['class' => 'btn btn-primary ']) ?>
 <?= $form->field($model, 'id')->hiddenInput(['id'=>'hidden_Input8','value'=>$model->id])->label(false);?>
 <?= $form->field($model, 'action')->hiddenInput(['id'=>'hidden_Input7','value'=>'rfa'])->label(false);?>



<?php
   ActiveForm::end();

 ?>
</div>    
                        
                   
<!--  --------------------------forward------------------------------------------------------>

    <div id="form2" class="myDiv">
	<h3>Select Next Recipient /Approver</h3>
	<?php
	$positionsList = ArrayHelper::map(ErpOrgPositions::find()->all(), 'id','position');

    $form = ActiveForm::begin([
        'id'=>'work-form2', 
         'action' => ['erp-document/work-flow'],
        'method' => 'post'
       ]);

?>

<div class="row">

<div class="col-sm-6">
    
      <?= $form->field($model, 'position')->dropDownList($positionsList, 
	         ['prompt'=>'-Choose position(s)-','class'=>['input-select form-control'],'id'=>'2',
			   'onchange'=>'getEmployee($("#2").val(),this.id)',
			  'options' => [1=> ['disabled' =>$disabled ]]])->label('Employee Position'); ?>  
</div>
     
<div class="col-sm-6">
    
       <?= $form->field($model, 'employee')->dropDownList([], 
	         ['prompt'=>'-Choose a employee-','class'=>['input-select form-control '],'id'=>'emp-2' ,
			 
			])->label('Employee Name (automatically filled in)'); ?>  
</div> 


<!-- ----------------------Employee-position copy-------------------------------------->
<div class="col-sm-6">
    
      <?= $form->field($model, 'position_cc')->dropDownList($positionsList, 
	         ['prompt'=>'-Choose position(s)-','class'=>['input-select form-control'],'id'=>'3','multiple'=>'multiple',
			   'onchange'=>'getEmployee($("#3").val(),this.id)',
			  'options' => [1=> ['disabled' =>$disabled ]]])->label('Employee Position(s) To Copy'); ?>  
</div>
     
<div class="col-sm-6">
    
       <?= $form->field($model, 'employee_cc')->dropDownList([], 
	         ['prompt'=>'-Choose a employee-','class'=>['input-select form-control'],'id'=>'emp-3' ,'multiple'=>'multiple',
			  'onchange'=>'
			'])->label('Employee Name (automatically filled in)'); ?>  
</div>


</div>

   

<?= $form->field($model, 'remark')->textarea(['id'=>'hidden_text2','rows' => '6']) ?>
<?= Html::submitButton('<i class="glyphicon glyphicon-send"></i> forward ', ['class' => 'btn btn-primary ']) ?>	

<?= $form->field($model, 'id')->hiddenInput(['id'=>'hidden_Input6','value'=>$model->id])->label(false);?>
<?= $form->field($model, 'action')->hiddenInput(['id'=>'hidden_Input5','value'=>'forward'])->label(false);?>




<?php
   ActiveForm::end();

 ?>
</div>  

<!-- -----------------approve--------------------------------------->
<div id="form3" class="myDiv">
	<h3>Select Next Recipient/Approver </h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form3', 
         'action' => ['erp-document/work-flow'],
        'method' => 'post'
       ]);

?>
    
    
  	<?= $form->field($model, 'position')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
    'options' => ['placeholder' => 'Select Employee(s) ...','id'=>'employees-select1',
			  'options' => [1=> ['disabled' =>$disabled ]]
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Employee(s) Position')?>                
                    
                    <?= $form->field($model, 'employee')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(User::find()->all(), 'user_id', function($user){

      return $user->first_name." ".$user->last_name;
  })],
    'options' => ['placeholder' => 'Employee(s) Names...','id'=>'employees-names1'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Employee(s) Names')?> 

<?= $form->field($model, 'remark')->textarea(['id'=>'hidden_text3','rows' => '6']) ?>
<?= Html::submitButton('<i class="glyphicon glyphicon-check"></i>Approve', ['class' => 'btn btn-primary ']) ?>
 <?= $form->field($model, 'id')->hiddenInput(['id'=>'hidden_Input3','value'=>$model->id])->label(false);?>
 <?= $form->field($model, 'action')->hiddenInput(['id'=>'hidden_Input4','value'=>'approve'])->label(false);?>

<?php
   ActiveForm::end();

 ?>
</div> 

<!--  ---------------------close------------------------------------>

<div id="form4" class="myDiv">
	<h3>Close Document</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'form4', 
         'action' => ['erp-document/work-flow'],
    
       'method' => 'post'
       ]);

?>
<?= Html::submitButton('<i class="fa   fa-lock "></i> Close ', ['class' => 'btn btn-primary ']) ?>
 <?= $form->field($model, 'id')->hiddenInput(['id'=>'hidden_Input1','value'=>$model->id])->label(false);?>
 <?= $form->field($model, 'action')->hiddenInput(['id'=>'hidden_Input2','value'=>'close'])->label(false);?>

 
 <?php
   ActiveForm::end();

?>
</div> 
 
              </div>

 </div>




          <?php
$url=Url::to(['erp-persons-in-position/populate-names']);            



$script = <<< JS

$(document).ready(function(){
  
    $(".input-select").select2({width: '100%' });
    var radioValue = $("input[name='ErpDocument[action]']:checked").val();
    $("div.myDiv").hide();
    $("#form"+radioValue).show();
   
   // $('input:radio[name="ErpDocument[action]"]').each(function () { $(this).prop('checked', false); });
     $('.select3').hide();
    
    $('input[type="radio"]').click(function(){
    	var value = $(this).val(); 
        $("div.myDiv").hide();
        $("#form"+value).show();
    });
    
    
    
});
 


$('#employees-select').on('select2:select', function (e) {
    var ids=$(this).val();
   
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
    // $('#employees-names').empty();
    $.each(array, function(i,e){
    $("#employees-names option[value='" + e + "']").prop("selected", true);
    
   
});

//trigger change-------------otherwise not updating
$('#employees-names').trigger('change.select2');
    });
});

$('#employees-select').on('select2:unselect', function (e) {
  
  var ids=$(this).val();
  if(!jQuery.isEmptyObject(ids)){
  
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
     $('#employees-names').val([]);
    $.each(array, function(i,e){
    $("#employees-names option[value='" + e + "']").prop("selected", true);

});


//trigger change-------------otherwise not updating
$('#employees-names').trigger('change.select2');

});

}else{ $('#employees-names').val([]);

$('#employees-names').trigger('change.select2');
    
}   
});



//----------------------------selec0----------------------------------------------------------
 $('#employees-select0').on('select2:select', function (e) {
    var ids=$(this).val();
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
    // $('#employees-names').empty();
    $.each(array, function(i,e){
    $("#employees-names0 option[value='" + e + "']").prop("selected", true);
    console.log(e);
   
});

//trigger change-------------otherwise not updating
$('#employees-names0').trigger('change.select2');
    });
});

$('#employees-select0').on('select2:unselect', function (e) {
  
  var ids=$(this).val();
   console.log(ids);
  if(!jQuery.isEmptyObject(ids)){
  
   
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
     $('#employees-names0').val([]);
    $.each(array, function(i,e){
    $("#employees-names0 option[value='" + e + "']").prop("selected", true);
    console.log(e);
});


//trigger change-------------otherwise not updating
$('#employees-names0').trigger('change.select2');

});

}else{ $('#employees-names0').val([]);$('#employees-names0').trigger('change.select2');}
   
});

//-===========================================copy==============================================
//----------------------------selec01----------------------------------------------------------
 $('#employees-select01').on('select2:select', function (e) {
    var ids=$(this).val();
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
    // $('#employees-names').empty();
    $.each(array, function(i,e){
    $("#employees-names0 option[value='" + e + "']").prop("selected", true);
    var copy_text = $("#employees-names0 option[value='" + e + "']").text();
    $("#employees-names01 option[value='" + e + "']").prop("selected", true);
    copy_text='CC:'+copy_text;
    $("#employees-names0 option[value='" + e + "']").text(copy_text);
});

//trigger change-------------otherwise not updating
$('#employees-names0').trigger('change.select2');
$('#employees-names01').trigger('change.select2');
    });
});

$('#employees-select01').on('select2:unselect', function (e) {
  
  var ids=[e.params.data.id];
  
  if(!jQuery.isEmptyObject(ids)){
  
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
     //$('#employees-names0').val([]);
    $.each(array, function(i,e){
    $("#employees-names0 option[value='" + e + "']").prop("selected", false);
    $("#employees-names01 option[value='" + e + "']").prop("selected", false);
    console.log(e);
});


//trigger change-------------otherwise not updating
$('#employees-names0').trigger('change.select2');
$('#employees-names01').trigger('change.select2');

});

}//else{ $('#employees-names0').val([]);$('#employees-names0').trigger('change.select2');}
   
});
//===========================================copy===============================================







//---------------------------------select1--------------------------------------------------
$('#employees-select1').on('select2:select', function (e) {
    var ids=$(this).val();
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
    // $('#employees-names').empty();
    $.each(array, function(i,e){
    $("#employees-names1 option[value='" + e + "']").prop("selected", true);
    console.log(e);
   
});

//trigger change-------------otherwise not updating
$('#employees-names1').trigger('change.select2');
    });
});

$('#employees-select1').on('select2:unselect', function (e) {
  
  var ids=$(this).val();
  if(!jQuery.isEmptyObject(ids)){
  
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
     $('#employees-names1').val([]);
    $.each(array, function(i,e){
    $("#employees-names1 option[value='" + e + "']").prop("selected", true);
    console.log(e);
});


//trigger change-------------otherwise not updating
$('#employees-names1').trigger('change.select2');

});

}else{ $('#employees-names1').val([]);$('#employees-names1').trigger('change.select2');}

});


$('.submit').on('click', function(event) {
    
  if($('#employees-names').val()==''){
      
      swal({
        title: "No Recipient(s) Selected?",
        text: "The document will be shared to who you report to !",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Share ",
        closeOnConfirm: false
    }, function () {
    
       
      $('#dynamic-form').submit();
    });
    
    return false;
  }
 
    
});


JS;
$this->registerJs($script);

$url1=Url::to(['erp-persons-in-position/get-employee-by-positions']); 

$script1 = <<< JS


function getEmployee(values,id)
{
   $.ajax({
    contentType: "application/json", // php://input
    dataType : "json",
    method: "POST",
    url: '{$url1}',
    data:JSON.stringify({ pos : values })
})
.done(function(data) {  
    console.log("test: ", data);
    $('#emp-'+id).html(data);
})
.fail(function(data) {
    console.log("error: ", data);
});
    
   
}
/*
 function getEmployee(values,id)
{
   
     $.get('{$url1}',{ pos : values },function(data){
        
        
          $('#emp-'+id).html(data);
    });
   
}*/



JS;
$this->registerJs($script1,$this::POS_HEAD);

?>

