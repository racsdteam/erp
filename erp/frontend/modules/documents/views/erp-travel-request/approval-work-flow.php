<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;

use kartik\select2\Select2;

use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use yii\db\Query;
use kartik\depdrop\DepDrop;
?>
<style>
.select2 {
/*width:100%!important;*/
}

.myDiv{
	display:none;
} 

</style>



<?php  
  $user=Yii::$app->user->identity;
  
  ?>

   <?php if (Yii::$app->session->hasFlash('success')){

$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  

   }
  

  
  ?>
  
 <div class="box box-default color-palette-box">
 <div class="box-header with-border">
   <h3 class="box-title"><i class="fa fa-tag"></i> Work Flow Actions  </h3>
 </div>
 <div class="box-body"> 
  
 
<?php
    
   
    $form = ActiveForm::begin([
        'id'=>'action-form1', 
    'options' => [
	//	'class' => 'radio',
		
	],
       ]);

?> 


      
<div  class="col-sm-12">
                  <?php 
                 // $items=['1'=>'Request for Action','2'=>'Forward','3'=>'Approve','4'=>'Reject'];
                  
                  //echo $form->field($model, 'action')->radioList($items,['class'=>'radios']);?>
                  
     <!--           not working in modal                            -->            
     <?php // $form->field($model, 'action',[
                    //'template' => "{label}\n<div class='col-md-12 radio'>{input}</div>\n{hint}\n{error}",
                    //'labelOptions' => [ 'class' => '' ]])->radio(['label' => 'Request for Correction', 'value' => 1, 'uncheckValue' => null]) ?>
      <? php //$form->field($model, 'action',[
                    //'template' => "{label}\n<div class='col-md-12 radio'>{input}</div>\n{hint}\n{error}",
                   // 'labelOptions' => [ 'class' => '' ]])->radio(['label' => 'Forward', 'value' => 2, 'uncheckValue' => null]) ?>
       <?php // $form->field($model, 'action',[
                    //'template' => "{label}\n<div class='col-md-12  radio'>{input}</div>\n{hint}\n{error}",
                    //'labelOptions' => [ 'class' => '' ]])->radio(['label' => 'Approve', 'value' => 3, 'uncheckValue' => null]) ?>
       
       
        <?= $form->field($model, 'action',[
                    'template' => "{label}\n<div class='col-md-12 '>{input}</div>\n{hint}\n{error}",
                    'labelOptions' => [ 'class' => '' ]])->radio(['label' => 'Request for Correction', 'value' => 1, 'uncheckValue' => null]) ?>
      <?=  $form->field($model, 'action',[
                    'template' => "{label}\n<div class='col-md-12'>{input}</div>\n{hint}\n{error}",
                    'labelOptions' => [ 'class' => '' ]])->radio(['label' => 'Forward', 'value' => 2, 'uncheckValue' => null]) ?>
       <?= $form->field($model, 'action',[
                    'template' => "{label}\n<div class='col-md-12'>{input}</div>\n{hint}\n{error}",
                    'labelOptions' => [ 'class' => '' ]])->radio(['label' => 'Approve', 'value' => 3, 'uncheckValue' => null]) ?>
                  
</div>

<?php
   ActiveForm::end();
                            
 ?>                  
                  
              <div id="form1" class="myDiv">
	<h3>Select Recipient(s)</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'search-party-form', 
         'action' => ['erp-travel-request/request-for-action','id'=>$model->id],
        'method' => 'post'
       ]);

?>
  	 <?= $form->field($model, 'position')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
    'options' => ['placeholder' => 'Select Employee(s) ...','id'=>'employees-select'
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

<textarea name="ErpTravelRequest[remark]" value="<?php $model->remark ?>" class="form-control" rows="3" placeholder="Remark..."></textarea>

<?= Html::submitButton('<i class="glyphicon glyphicon-send"></i> Send ', ['class' => 'btn btn-primary ']) ?>


<?php
   ActiveForm::end();

 ?>
</div>    
                        
                   
<!--  --------------------------forward------------------------------------------------------>

    <div id="form2" class="myDiv">
	<h3>Select Recipient(s)</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'search-party-form', 
         'action' => ['erp-travel-request/forward','id'=>$model->id],
        'method' => 'post'
       ]);

?>
  <?= $form->field($model, 'position')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
    'options' => ['placeholder' => 'Select Employee(s) ...','id'=>'employees-select0'
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
    'options' => ['placeholder' => 'Employee(s) Names...','id'=>'employees-names0'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Employee(s) Names')?> 

<textarea name="ErpTravelRequest[remark]" value="<?php $model->remark ?>" class="form-control" rows="3" placeholder="Remark..."></textarea>

<?= Html::submitButton('<i class="glyphicon glyphicon-send"></i> forward ', ['class' => 'btn btn-primary ']) ?>	
<?php
   ActiveForm::end();

 ?>
</div>  

<!-- -----------------approve--------------------------------------->
<div id="form3" class="myDiv">
	<h3>Select Recipient(s)</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'search-party-form', 
         'action' => ['erp-travel-request/approve','id'=>$model->id],
        'method' => 'post'
       ]);

?>
  	<?= $form->field($model, 'position')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
    'options' => ['placeholder' => 'Select Employee(s) ...','id'=>'employees-select1'
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

<textarea name="ErpTravelRequest[remark]" value="<?php $model->remark ?>" class="form-control" rows="3" placeholder="Remark..."></textarea>

<?= Html::submitButton('<i class="glyphicon glyphicon-check"></i>Approve', ['class' => 'btn btn-primary ']) ?>
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
    
    
    
    $('input[type="radio"]').click(function(){
    	var value = $(this).val(); 
        $("div.myDiv").hide();
        $("#form"+value).show();
    });
});
 
 
 
 $(function () {
    //Initialize Select2 Elements
    $(".Select2").select2({width: '100%' });
     
 });

$('#employees-select').on('select2:select', function (e) {
    var ids=$(this).val();
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
    // $('#employees-names').empty();
    $.each(array, function(i,e){
    $("#employees-names option[value='" + e + "']").prop("selected", true);
    console.log(e);
   
});

//trigger change-------------otherwise not updating
$('#employees-names').trigger('change.select2');
    });
});

$('#employees-select').on('select2:unselect', function (e) {
  
  var ids=$(this).val();
  if(!jQuery.isEmptyObject(ids)){
  
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
     $('#employees-names').val([]);
    $.each(array, function(i,e){
    $("#employees-names option[value='" + e + "']").prop("selected", true);
    console.log(e);
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
  if(!jQuery.isEmptyObject(ids)){
  
    console.log(ids);
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
?>

