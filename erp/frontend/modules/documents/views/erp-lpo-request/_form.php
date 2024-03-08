<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use yii\db\Query;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use kartik\file\FileInput;
use common\models\ErpLpoRequestSupportingDocType;
use common\models\ErpLpoRequestSupportingDoc;
use yii\bootstrap4\ActiveForm;
use dosamigos\tinymce\TinyMce;
use common\models\ErpLpoRequestType;
use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this);
use common\models\ErpTransmissionSlipType;
use common\models\ErpRequisition;
use common\models\ErpTravelRequest;
use yii\web\JsExpression;
use common\components\Constants;
use  common\models\UserHelper;



/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */
$this->title = 'Request for LPO ';
$this->params['breadcrumbs'][] = $this->title;

?>


<style>

/*-----------------select type form hidden by default------------------------------------------*/

.myDiv{
    
    display:none;
}

/*-----------------override tinymce default height-------------------------------------------*/


.tox-tinymce{
    
    height:300px !important;
}

</style>


<!-- -------------------Memo model3ory--------------------------------------->
<?php



?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                             <h3 class="card-title"><i class="fab fa-opencart"></i> Request for LPO</h3>
                       </div>
               
           <div class="card-body">

 
  <?php
  
   if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
  
  
  $user=Yii::$app->user->identity; 
  
if(is_array($params) && !empty($params))
 extract($params);


   
           
           if(isset($request_id) && $request_id!=null){
            
            $model->request_id=$request_id;   
          
           
        }
        
          if(isset($request_type) && $request_type!=null){
            
            $model->type=$request_type;   
            
        } 
           
          
       
      if($model->type!=null) {
         
         $typeInputDisabled=true;
      } 
      
      //----------in case not update model-----------------------
      if($model->request_id!=null && $model->isNewRecord) {
         
         $requestInputDisabled=true; 
          
      } 
      
  ?>


<?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data', 'data-toggle'=>'validator'],
                                'id'=>'lpo-req-form', 
                               'enableClientValidation'=>true,
                                'enableAjaxValidation' => false,
                               'method' => 'post',
                              
                               ]); ?>

       <div id="smartwizard">
            
            
            <ul class="nav">
                
                 <li><a class="nav-link" href="#step-1">Page 1<br /><small>Add Request Details </small></a></li>
                  <li><a class="nav-link" href="#step-2">Transmission Slip<br /><small>Add Transmission Slip</small></a></li>
                <li><a class="nav-link" href="#step-3">LPO Request Supporting Document(s)<br /><small>Add Supporting Document(s)</small></a></li>
               
                
               
            </ul>

            <div class="tab-content">
                
              
                
                <div id="step-1" class="tab-pane" role="tabpanel">
                   
                
                   
                 
                    <?php $items=ArrayHelper::map(ErpLpoRequestType::find()->all(), 'code', 'type'); ?>
                 
    
                     <?= $form->field($model, 'type')->widget(Select2::classname(), [
    'data' => [$items],
    'options' => ['placeholder' => 'Select LPO Request  Category ...',
    'id'=>'request-type-select',
    'disabled'=>$typeInputDisabled,
    'class'=>'m-select2'//------for select to look correctly
   ],
    'bsVersion' => '4.x',
    'pluginOptions' => [
        'allowClear' => true,
      
       
       
    ],"pluginEvents" =>[
     /*"change" => "function() { showType($(this).val()) }",*/
    
],
  
    
])->label('Select LPO Request Category')?>

<?Php 
  
    if($typeInputDisabled){
        
         echo Html::hiddenInput('ErpLpoRequest[type]', $request_type);
    }
      
   
       if($requestInputDisabled){
           
          echo Html::hiddenInput('ErpLpoRequest[request_id]', $request_id); 
        
       }
     
    
  

?>



<?php

  $query=" SELECT pr.* FROM erp_requisition as pr where pr.approve_status='approved' 
  and pr.id NOT IN (select r.request_id from erp_lpo_request as r where pr.id=r.request_id and r.type='PR') or
  pr.id  IN (select r.request_id from erp_lpo_request as r where pr.id=r.request_id and r.type='PR' and r.status NOT IN ('processing' ,'approved','processed','completed'))";
  $com = Yii::$app->db->createCommand($query);
  $res = $com->queryall();
  
  $data1=ArrayHelper::map($res, 'id', function($row){
  $user=UserHelper::getUserInfo($row['requested_by']);  
  return '#'.$row['id'].' '.$row['title'].' //'. $user['first_name'].' '.$user['last_name'].'';
     
});
  

?>

<div id="formPR" class="myDiv PR">
                      
                      
                      <?= $form->field($model, 'request_id')->widget(Select2::classname(), [
    'data' =>$data1,
    'options' => ['placeholder' => 'Select Purachase Requisition ...',
    'id'=>'pr-select',
    'class'=>'m-select2',
    'style' => 'font-wight:bold',
    'disabled'=>$requestInputDisabled
   ],
  
    'pluginOptions' => [
        'allowClear' => true,
       
        
       
       
    ]
    
])->label("Select Purchase Requisition")?> 

</div>



                     <div id="formTT" class="myDiv TT">
    


<?php

  $query=" SELECT tr.* FROM erp_travel_request as tr where tr.status='approved'  
  and tr.id NOT IN (select r.request_id from erp_lpo_request as r where tr.id=r.request_id and r.type='TT') 
  or
 tr.id  IN (select r.request_id from erp_lpo_request as r where tr.id=r.request_id and r.type='TT' and r.status NOT IN ('approved','processed','completed'))";
  $com = Yii::$app->db->createCommand($query);
  $res = $com->queryall();
  
  $data=ArrayHelper::map($res, 'id', function($row){
  
   return '#'.$row['id'].' '. $row['purpose']." / Departure Date : ".$row['departure_date'];
     
});



?>

    <?= $form->field($model, 'request_id')->widget(Select2::classname(), [
    'data' =>$data,
    'options' => ['placeholder' => 'Select Travel Request ...',
    'id'=>'tr-select',
    'class'=>'m-select2',
    'style' => 'font-wight:bold',
     'disabled'=>$requestInputDisabled
   ],
    'pluginOptions' => [
        'allowClear' => true,
        //'multiple'=>true
       
       
    ]
    
])->label("Select Travel Request")?> 


 
</div> 

<?= $form->field($model, 'title')->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'LPO Request Title...'])->label("Request Title")?>
 
 <?php
     
     $model->severity='normal';
  $items=['normal'=>'Normal','immediate'=>'Immedidate','urgent'=>'Urgent','very urgent'=>'Very Urgent'];?>
                  
                 <?php echo $form->field($model, 'severity')->inline(true)->radioList($items,['class'=>'radio'])->label('Select Severity');?>


                </div>
                
                
                    <div id="step-2" class="tab-pane" role="tabpanel">
                    
                     <h2>Add Transmission Slip</h2>
                     
                     <?php $model1->type='LPO';  
                     
                  
                     ?>
                     
      <?= $form->field($model1, 'type')->hiddenInput(['value'=>$model1->type])->label(false);  ?>               
                     
              <?= $form->field($model2, 'comment')->widget(TinyMce::className(), [
    'options' => ['rows' => 6],
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



                   

                    
 
                </div> 
                
                 <div id="step-3" class="tab-pane" role="tabpanel">
                    <h2>Supporting Document(s)</h2>
                    
                    
                   <?php
                    
                    if(!$model->isNewRecord){
                        
                     $docs1=ErpLpoRequestSupportingDoc::find()->where(['lpo_request'=>$model->id])->all(); 
                     
                     $preview1=array();
                     $config_prev1=array();
                     
                     if(!empty($docs1)){
                         
                         foreach($docs1 as $doc1){
                             
                             
                             if(file_exists($doc1->doc_upload)){
                                
                                $preview1[]=Yii::$app->request->baseUrl.'/'.$doc1->doc_upload;
                                $config1=(object)["type"=>"pdf",  "caption"=>$doc1->doc_name, "key"=>$doc1->id, 
                             'url' => \yii\helpers\Url::toRoute(['erp-lpo-request-supporting-doc/delete','id'=>$doc1->id])];
                              $config_prev1[]=$config1; 
                             }
                                 
                               
                             
                             
                         }
                     }
                        
                    }
                   
                    
                    ?>
                    
                              <?= $form->field($modelSupportDocs, 'doc_uploaded_files[]')->widget(FileInput::classname(), [
                                                 'options' => ['accept' => 'file/*','multiple' => true
                                                 
                                                 ],
                                                 'pluginOptions'=>['allowedFileExtensions'=>['pdf','jpg'],
                                                 'showUpload' => false,
                                                 'theme'=>'fas',
                                                 'uploadUrl' => '/erp-lpo-request-supporting-doc/create',
                                                 'initialPreview'=>!empty($preview1)?$preview1:[],
                                                 'overwriteInitial'=>true,
                                                 'initialPreviewAsData'=>true,
                                                 'initialPreviewFileType'=>'image',
                                                 'initialPreviewConfig' =>$config_prev1,
                                                 'purifyHtml'=>true,
                                                 'uploadAsync'=>false,
                                                  
  ],     
                                                
                                                                                    
  ])?>
                
 
                </div>
   
    </div>
    
           
    
  
</div>

<?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>



<?php

if($model->isNewRecord){
    
    $label='Save';
}else{
    
    $label='Update';
}

$script = <<< JS


 $(function () {
   
              showType($("#request-type-select").val()) ;
              
              $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
   
            // Step show event
              $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
                
         //--------------------------prevent backward validation       
                if(stepDirection=='backward')return true;
    
    data = $("#lpo-req-form").data("yiiActiveForm");
$.each(data.attributes, function() {
    this.status = 3;
});

//----------------------------------------filter validation on attr disabled--------------------------------

$('#lpo-req-form').on('beforeValidateAttribute', function (event, attribute) {
    if ($(attribute.input).prop('disabled')) { return false; }
});





$("#lpo-req-form").yiiActiveForm("validate");


var content=tinymce.activeEditor.getContent({format: 'text'});
 

 if(content.trim()){
   $(".field-erptransmissionslipcomments-comment").find(".invalid-feedback").empty(); 
   
    
 }
 
    var currentstep=stepNumber+1;
    

  
   
   if($("#step-"+currentstep).find(".invalid-feedback").contents().length >0){
            e.preventDefault();
            return false;
        }
        
       
   
    return true;
   
             
            });
            
            
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
            
               if(stepPosition === 'first'){
                   $("#prev-btn").addClass('disabled');
               }else if(stepPosition === 'last'){
                   $("#next-btn").addClass('disabled');
               }else{
                   $("#prev-btn").removeClass('disabled');
                   $("#next-btn").removeClass('disabled');
                   
               }
               
               $('.submit').css("display","none") ;
              //------------------------show Save button-------------------------------
              if(stepPosition === 'last')
              {
                 $('.submit').show(); 
            
                  
              }
              else{
                  
                $('.submit').css("display","none") ; 
              }
              
              
              
            
               
            });

            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text('{$label}')
                                             .addClass('btn btn-info submit')
                                             .on('click', function(){ $('#dynamic-form').submit();});
                                             
         
                                             
          //--------------------------------------initialize smartwizard with cutsom namespace function init------------------------------------------------------>
                                             
                                        smartWizardConfig.init(0,[btnFinish],theme='dots',animation='none')
                                        
                      
   
   

   
 
 //-----------------------show selected request type on page load------------------------------------->
 
  
 $('#request-type-select').on('change.yii',function(){
              
              showType($(this).val());

});
 
 
    /*function showType(id){
 var types=['PR','TT','O'] 

    if(id!=null) {
      
       $("div.myDiv").hide(); 
       $("#form"+id).show();     
      
    } 
 
 //-------------------------prevent submit empty request Id------------------------------------------------>  
    for(var i=0;i<types.length;i++){
        
         if(id.localeCompare(types[i])==0){
             
             $("#form"+types[i]+' select').prop('disabled',false);
             
         }else{
             
             $("#form"+types[i]+' select').prop('disabled',true); 
         }
       
    }

  }*/
   
   function showType(optValue){
 
  if(optValue!=='') {
    
 $('div.myDiv').not('.'+ optValue).hide().find('input:text,input:hidden, select').prop("disabled",true);
 
 $('.'+ optValue).show().find('input:text,input:hidden, select').prop("disabled",false);


 
}




}
   
 });
                  
  

   

JS;
$this->registerJs($script);

//--------------------------custom select option format------------------------------------------------------------>
$format = <<< JS

function format(req) {

}


JS;
$this->registerJs($format,$this::POS_HEAD);



?>

