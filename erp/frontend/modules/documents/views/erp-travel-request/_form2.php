<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\ErpDocumentType;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use softark\duallistbox\DualListbox;
use kartik\select2\Select2;
use common\models\ErpDocumentSeverity;
use wbraganca\dynamicform\DynamicFormWidget;
use common\models\ErpDocumentAttachType;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use yii\db\Query;
//use kartik\depdrop\DepDrop;
use buttflattery\formwizard\FormWizard;
//use dosamigos\file\FileInput;
?>
<style>
.select2 {
/*width:100%!important;*/
}

</style>

<div class="row clearfix">

<div class="<?php if(!$isAjax){echo 'col-lg-10 col-md-10 col-sm-12 col-xs-12 col-md-offset-1';}else{ echo 'col-lg-12 col-md-12 col-sm-12 col-xs-12';}  ?> ">

 <div class="box box-default color-palette-box">
        
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa- fa-paperclip"></i>Travel Request Document(s)</h3>
        </div>
               
           <div class="box-body">

 <?php if($model->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($model, ['encode' => false]) ?>
              </div>
            
            <?php endif?>
            
             <?php if($model1->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($model1, ['encode' => false]) ?>
              </div>
            
            <?php endif?>
             
             <?php if($model2->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($model2, ['encode' => false]) ?>
              </div>
            
            <?php endif?>
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


<div class="guest-chickin-form">




<?php


echo FormWizard::widget([
      'theme' => FormWizard::THEME_ARROWS,
     
      'formOptions'=>[
        'id'=>'requestform',
        'enableClientValidation'=>false,
        'enableAjaxValidation'=>false,
       
        'options' => ['enctype' => 'multipart/form-data']
    ],
    'steps'=>[
          [
            'model'=>$model,
            'title'=>'Document Title',
            'description'=>'Add Document Title',
            'formInfoText'=>'Fill all fields',
            'fieldOrder'=>['title'],
            'fieldConfig' => [
                    'memo'=>false,
                      
                        
                    ],
        ],
        //--------------------------------------------doc title end-----------------
        [
            'model'=>$model1,
            'title'=>'Travel Clearance',
            'description'=>'Add Travel Clearance(s)',
            'formInfoText'=>'Fill all fields',
            'fieldOrder'=>['position','employee'],
            'fieldConfig' => [
                    'created_at'=>false,
                    'tc_code'=>false,
                    'request_id'=>false,
                    'created_by'=>false,//hide a specific field
                    'recipients'=>false,
                    'recipients_names'=>false,
                    'position'=>[  'widget' => Select2::classname(), //widget class name
                        'options' => [ // you will pass the widget options here
                             'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
                             'options' => ['placeholder' => 'Select position ...','id'=>'recipients-select0'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
                        ],
                        ],
                 'employee'=>[  'widget' => Select2::classname(), //widget class name
                        'options' => [ // you will pass the widget options here
                              'data' => [ ArrayHelper::map(User::find()->all(), 'user_id', function($user){

      return $user->first_name." ".$user->last_name;
  })],
    'options' => ['placeholder' => 'Select names ...','id'=>'recipients-names0'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    ],
                        ],
                        
        'departure_date'=>[  
                        'options' => [ // you will pass the widget options here
              'class'=>['form-control date pull-right']
                        ],
                        ],                 
                        
         'return_date'=>[  
                        'options' => [ // you will pass the widget options here
              'class'=>['form-control date pull-right']
                        ],
                        ],
                        
                        
             'reason' => [
                        'options' => [
                            'type' => 'textarea',
                            'class' => 'form-control',
                            //'cols' => 25,
                            'rows' => 6
                        ]
                    ],           
                        
                    ],
        ],
        [
            'model'=> $model2,
            'title'=>'Claim Form',
            'description'=>'Add claim form(s)',
            'formInfoText'=>'Fill all fields',
              'fieldOrder'=>['position','person'],
            'fieldConfig' => [
                    'created_at'=>false,
                    
                    'request_id'=>false,
                    'created_by'=>false,//hide a specific field
                    'recipients'=>false,
                    'recipients_names'=>false,
                    'is_new'=>false,
                    'position'=>[  'widget' => Select2::classname(), //widget class name
                        'options' => [ // you will pass the widget options here
                             'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
                             'options' => ['placeholder' => 'Select position ...','id'=>'recipients-select1'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
                        ],
                        ],
                 'person'=>[  'widget' => Select2::classname(), //widget class name
                        'options' => [ // you will pass the widget options here
                              'data' => [ ArrayHelper::map(User::find()->all(), 'user_id', function($user){

      return $user->first_name." ".$user->last_name;
  })],
    'options' => ['placeholder' => 'Select names ...','id'=>'recipients-names1'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    ],
                        ],
                        
       
              'currancy_type'=>[  'widget' => Select2::classname(), //widget class name
                        'options' => [ // you will pass the widget options here
                             'data' => [ 'USD'=>'USD','Frw'=>'Frw'],
                             'options' => ['placeholder' => 'Select Currency Type ...','id'=>'currency'
   ],
    'pluginOptions' => [
        'allowClear' => true,
       
       
       
    ]
                        ],
                        ],           
                        
             'purpose' => [
                        'options' => [
                            'type' => 'textarea',
                            'class' => 'form-control',
                            //'cols' => 25,
                            'rows' => 6
                        ]
                    ],           
                        
                    ],
        ],
      
        
        //-----------------------------attachments-------------------------------------------------------------------
        
         [
           
            'title'=>'Other Attachment(s)',
            'type' => FormWizard::STEP_TYPE_PREVIEW,
             'model'=> $models3,
            'description'=>'Add attachment(s)',
            'formInfoText'=>'Upload Attachment(s)',
            
            'fieldConfig' => [
                   
                'only' => ['attach_files'] ,
                 'attach_files'=>[ 
                      
                     'labelOptions' => [
                            'label' => 'Attach Files'
                        ],
                        
            'widget' => FileInput::classname(),
            'options' =>[
                'options' => [
                    'multiple' => true,
                    'accept' => 'file/*',
                    'pluginOptions' => [
                       
                       
                        'allowedFileExtensions' => ['jpg','png','pdf'],
                        'showUpload' => false,
                                                'showPreview' => true,
                                                'showCaption' => true,
                                                'showRemove' => true,
                        'overwriteInitial' =>true
                    ],
                 
                ],
            ],
                        
                          
                        ],
       
                      
                        
                    ],
        ],
    ]
]);

?>

           


              </div>



</div>

</div>

 
 </div>

</div>
<?php
$url=Url::to(['erp-persons-in-position/populate-names']);  

$script = <<< JS



 $(function () {
    //Initialize Select2 Elements
    $(".Select2").select2({width:'100%'});
    $("#currency").select2({width:'100%'});
    // $("ul.step-anchor > li.active ").css("cssText", "background: red !important;");
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
  
 $('#recipients-names0').val([]);$('#recipients-names0').trigger('change.select2');

});

//------------------------------------select1-------------------------------------------
 $('#recipients-select1').on('select2:select', function (e) {
    var ids=$(this).val();
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
    // $('#recipients-names').empty();
    $.each(array, function(i,e){
    $("#recipients-names1 option[value='" + e + "']").prop("selected", true);
    console.log(e);
   
});

//trigger change-------------otherwise not updating
$('#recipients-names1').trigger('change.select2');
    });
});

$('#recipients-select1').on('select2:unselect', function (e) {
  
 $('#recipients-names1').val([]);$('#recipients-names1').trigger('change.select2');

});
	});
 

JS;
$this->registerJs($script);

?>