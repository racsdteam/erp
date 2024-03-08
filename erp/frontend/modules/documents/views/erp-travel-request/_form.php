<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\ErpDocumentType;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use softark\duallistcard\DualListcard;
use kartik\select2\Select2;
use common\models\ErpDocumentSeverity;
use wbraganca\dynamicform\DynamicFormWidget;
use common\models\ErpDocumentAttachType;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use yii\db\Query;
//use kartik\depdrop\DepDrop;
use buttflattery\formwizard\FormWizard;
use common\models\ErpTravelRequestType;
use common\models\ErpTravelRequestAttachement;
//use dosamigos\file\FileInput;
?>
<style>
.select2 {
/*width:100%!important;*/
}

</style>

<div class="row clearfix">

<div class="<?php if(!$isAjax){echo 'col-lg-10 col-md-10 col-sm-12 col-xs-12 offset-md-1';}else{ echo 'col-lg-12 col-md-12 col-sm-12 col-xs-12';}  ?> ">

 <div class="card card-default ">
        
        <div class="card-header ">
          <h3 class="card-title"><i class="fas fa-suitcase"></i>  Travel Request Info</h3>
        </div>
               
           <div class="card-body">

 <?php if($model->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($model, ['encode' => false]) ?>
              </div>
            
            <?php endif?>
            
            
             
           
<?php  
  $user=Yii::$app->user->identity;
  $_SESSION['form_token_param']=Yii::$app->request->csrfToken;
  
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



                    
                        $preview=array();
                        $config_prev=array();
                        
                    
                    if(!$model->isNewRecord){
                        
                   
                    
                     $docs=ErpTravelRequestAttachement::find()->where(['tr_id'=>$model->id])->all(); 
                    
                     
                     if(!empty($docs)){
                         
                         foreach($docs as $doc){
                             
                             $preview[]=Yii::$app->request->baseUrl."/".$doc->attach_upload;
                             $config=(object)['type'=>"pdf",  'caption'=>$doc->attach_name, 'key'=>$doc->id ,
                             'url' => \yii\helpers\Url::toRoute(['erp-travel-request-attachement/delete','id'=>$doc->id]),
                             'downloadUrl'=>Yii::$app->request->baseUrl."/".$doc->attach_upload];
                             $config_prev[]=$config;
                         }
                     }
                        
                    }
                   
                    
                    


echo FormWizard::widget([
      'theme' => FormWizard::THEME_ARROWS,
       //'enablePreview'=>true,
      'formOptions'=>[
        'id'=>'requestform',
        'enableClientValidation'=>false,
        'enableAjaxValidation'=>false,
         
        'options' => ['enctype' => 'multipart/form-data']
    ],
    'steps'=>[
          [
            'model'=>$model,
            'title'=>'Travel Clearance(s)',
            'description'=>'Create Travel Clearance(s)',
            'formInfoText'=>false,
             'stepHeadings' => [
                [
                    'text' => 'Employee(s) Info',
                    'before' => 'position',
                    'icon'=>'<i class="fa fa-user"></i>',
                ],
                 [
                    'text' => 'Travel Info',
                    'before' => 'type',
                    'icon'=>'<i class="fas fa-suitcase"></i>',
                ]
                ],
            'fieldOrder'=>['position','employee','type','purpose','destination','means_of_transport','departure_date','return_date','flight','tr_expenses'],
            'fieldConfig' => [
                   
                      'only' => ['position','employee','type','purpose','destination','means_of_transport','departure_date','return_date','flight','tr_expenses'] ,
                      
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
                      
                       'type'=>[  'widget' => Select2::classname(), //widget class name
                        'options' => [ // you will pass the widget options here
                             'data' => [ ArrayHelper::map(ErpTravelRequestType::find()->all(), 'code', 'type') ],
                             'options' => ['placeholder' => 'Select travel type ...','class'=>'Select2'
   ],
    'pluginOptions' => [
        'allowClear' => true,
       
       
    ],pluginEvents =>[
    //"change" => "function() { changeMeansOfTransport($(this).val()) }",
    
],
                        ],
                        
                        ],
      'means_of_transport'=>[  'widget' => Select2::classname(), //widget class name
                        'options' => [ // you will pass the widget options here
                             'data' => ["By Air"=>"By Air","By Road"=>"By Road"],
                             'options' => ['placeholder' => 'Select mode of Transport ...','class'=>'Select2'
   ],
    'pluginOptions' => [
        'allowClear' => true,
       
       
    ],pluginEvents =>[
    //"change" => "function() { changeMeansOfTransport($(this).val()) }",
    
],
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
                     'departure_date'=>[  
                        'options' => [ // you will pass the widget options here
              'class'=>['form-control date '],
                        ],
                        ],                 
                        
         'return_date'=>[  
                        'options' => [ // you will pass the widget options here
              'class'=>['form-control date ']
                        ],
                        ],
                        
                        
             
                        
                    ],
        ],
        //--------------------------------------------doc title end-----------------
      /*  [
            'model'=>$model1,
            'title'=>'Travel Clearance',
            'description'=>'Add Travel Expense(s)',
            'formInfoText'=>'Fill all fields',
            'fieldOrder'=>['position','employee'],
            'fieldConfig' => [
                    'created_at'=>false,
                    'tc_code'=>false,
                    'request_id'=>false,
                    'created_by'=>false,//hide a specific field
                    'recipients'=>false,
                    'recipients_names'=>false,
                   'position'=>false,
                    'employee'=>false,
                        
                  
                        
                    ],
        ],
        [
            'model'=>$model2,
            'title'=>'Travel Claim(s)',
            'description'=>'Add Travel claim(s)',
            'formInfoText'=>false,
              'fieldOrder'=>['purpose','day','currancy_type','rate','total_amount','total_amount_in_words'],
               'stepHeadings' => [
                [
                    'text' => 'Claim(s) Info',
                    'before' => 'purpose',
                    'icon'=>'<i class="fa fa-money"></i>',
                ],
                
                ],
            'fieldConfig' => [
                    'created_at'=>false,
                    
                    'tr_id'=>false,
                    'created_by'=>false,//hide a specific field
                    'recipients'=>false,
                    'recipients_names'=>false,
                    'is_new'=>false,
                    'position'=>false,
                    'person'=>false,
                    'employee'=>false,
                    'title'=>false,
                 
                        
       
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
        ],*/
      
        
        //-----------------------------attachments-------------------------------------------------------------------
        
         [
           
            'title'=>'Supporting Document(s)',
            'type' => FormWizard::STEP_TYPE_PREVIEW,
             'model'=> $models3,
            'description'=>'Add Supporting Doc(s)',
            'formInfoText'=>false,
             'stepHeadings' => [
                [
                    'text' => 'Attachments',
                    'before' => 'attach_files',
                    'icon'=>'<i class="fa fa-file-archive-o"></i>',
                ],
                
                ],
            
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
                                                       'pluginOptions'=>['allowedFileExtensions'=>['pdf','jpg'],
                                                       'showUpload' => false,
                                                  'uploadUrl' => '/erp-travel-request-attachement/create',
                                                   'initialPreview'=>!empty($preview)?$preview:[],
                                                   'overwriteInitial'=>false,
                                                   'initialPreviewAsData'=>true,
                                                   'initialPreviewFileType'=>'image',
                                                   'initialPreviewConfig'=>$config_prev,
                                                   'purifyHtml'=>true,
                                                   'uploadAsync'=>false,
                                                  
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

//$('.field-erptravelclearance-means_of_transport').hide();
/*function changeMeansOfTransport(type){
    
   if(type==1){
    $('.field-erptravelclearance-means_of_transport').show();  
   }else{
       
       $('.field-erptravelclearance-means_of_transport').hide();
   }
    
}*/



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
	
var date_input1 = document.getElementById('erptravelrequest-departure_date');
date_input1.onchange = function(){
   //console.log(this.value);
   setDays();
}

var date_input2 = document.getElementById('erptravelrequest-return_date');
date_input2.onchange = function(){
   //console.log(this.value);
   setDays();
}

function setDays(){
    
var d_date=date_input1.value;
var r_date=date_input2.value;

if(d_date!='' && r_date!=''){
    
const date1 = new Date(d_date);
const date2 = new Date(r_date);
const diffTime = Math.abs(date2.getTime() - date1.getTime());
const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

var days_input = document.getElementById('erpclaimform-day');
days_input.value=diffDays;

}
    
    
}


JS;
$this->registerJs($script);

?>