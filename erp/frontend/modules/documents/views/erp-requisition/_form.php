<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use yii\db\Query;
//use kartik\depdrop\DepDrop;
use buttflattery\formwizard\FormWizard;
use common\models\ErpRequisitionType;
use dosamigos\tinymce\TinyMce;
use common\models\ErpMemoCateg;
use common\models\ErpMemo;
use common\models\ErpRequisitionAttachement;

use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this); 
//use dosamigos\file\FileInput;
?>
<style>
.select2 {
/*width:100%!important;*/
}
.sw-theme-arrows > ul.step-anchor > li > a, .sw-theme-arrows > ul.step-anchor > li > a:hover{
    
   color:#bbb !important; 
    
}

#items tr td .total_one,.TotalCell{background-color:#ffd9b3;font-family:"Lucida Console", Monaco, monospace, sans-serif;font-weight:bold;}
#items tr td.TotalCell{font-family:"Arial Black", Gadget, sans-serif}



</style>

<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

 <div class="card card-default ">
        
        <div class="card-header ">
          <h3 class="card-title"><i class="fa fa-cart-plus"></i> Purchase Requisition</h3>
        </div>
               
           <div class="card-body">

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
            
            <?php foreach($modelsRequisitionItems as $item) :?>
  
  <?php if($item->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($item, ['encode' => false]) ?>
              </div>
            
            <?php endif?>           
     
     <?php endforeach?>       
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




<?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data', 'data-toggle'=>'validator'],
                                'id'=>'dynamic-form', 
                               'enableClientValidation'=>true,
                                //'action' => ['erp-requisition/create'],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                              
                               ]); ?>

 <div id="smartwizard">
            <ul class="nav">
                <!--<li><a href="#step-1">Memo<br /><small>Create Memo For PR</small></a></li>-->
                <li><a class="nav-link" href="#step-1">Requisition Info<br /><small>Add Requisition Info</small></a></li>
                <li><a class="nav-link" href="#step-2">Requisition Items<br /><small>Add  Requisition Items</small></a></li>
                <li><a class="nav-link" href="#step-3">Requisition Supporting Docs<br /><small>Requisition Supporting Document(s)</small></a></li>
               
            </ul>

            <div class="tab-content">
                
                <div id="step-1"  class="tab-pane" role="tabpanel">
                    <h2>Purchase Requisition Details</h2>
                     <div class="form-group"> 
                    
                   
<?php $items=ArrayHelper::map(ErpRequisitionType::find()->all(), 'id', 'type');
$currency_types=["Rwfrs"=>"Rwandan Francs","$" => "USD","€" => "EURO"];
?>
                    <?= $form->field($model, 'type')
        ->dropDownList(
            $items,           // Flat array ('id'=>'label')
            ['prompt'=>'Select...','class'=>['form-control m-select2']]    // options
        )?>
                   
        </div>  
        
        

 <?= $form->field($model, 'title')->textInput(['maxlength' => true,'class'=>['form-control','placeholder'=>'Requisition Title...']]) ?>


 <?= $form->field($model, 'currency_type')
        ->dropDownList(
            $currency_types,
            ['prompt'=>'Select...','class'=>['form-control m-select2']]    // options
        )?>
  
  <?php 
  $items =["1"=>"Yes","0"=>"No"];
  ?>
                   
                  <?php echo $form->field($model, 'is_tender_on_proc_plan')->radioList($items,[
                      
                      
                    'template' => "{label}\n<div class='col-md-12 radio'>{input}</div>\n{hint}\n{error}",
                    'labelOptions' => [ 'class' => '' ],
                    'uncheckValue' => null
                    ]);?>         
 
 
                </div>
                <div id="step-2"  class="tab-pane" role="tabpanel">
                  
                    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items2', // required: css class selector
        'widgetItem' => '.item', // required: css class
       'limit' => 500, // the maximum times, an element can be added (default 999)
        'min' =>1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsRequisitionItems[0],
        'formId' => 'dynamic-form',
        'formFields' => [
           'designation',
            'specs',
           'uom',
            'quantity',
            'unit_price',
            'total_amount',
            'badget_code'
           // 'attach_description'
           
        ],
    ]); ?>
    
    <div class="table-responsive">
      <table id="items" style="width:100%" class="table-bordered table-striped">
        <thead>
            <tr>
               
    <th  style="text-align:center;color:#2196f3;font-weight:bold;" colspan="8"><h4 class="card-title"><i class="fa fa-cart-arrow-down"></i> Add Purchase Requisition Items</h4></th>
                
            </tr>
            <tr style="padding:5px 5px">
               
                <th>Item Description</th>
                <th>Specs</th>
                 <th>UoM(unit of measurement)</th>
                  <th>Quantity</th>
                   <th>Badget Code</th>
                   <th>Unit Price</th>
                   <th>Total Price</th>
                    
                <th  class="text-center" style="width:10%;">
                   Add/Remove Item
                </th>
            </tr>
        </thead>
        <tbody class="container-items2">
       <?php foreach ($modelsRequisitionItems as $i => $modelRequisitionitem): ?>
            <tr class="item">
                
                
                <td style="width:30%;">
                    
                     <?php
                            // necessary for update action.
                            if (! $modelRequisitionitem->isNewRecord) {
                                echo Html::activeHiddenInput($modelRequisitionitem, "[{$i}]id");
                            }
                        ?> 
                 
                 <?= $form->field($modelRequisitionitem, "[{$i}]designation")->textarea(['rows' => '1'])->label('Item Description') ?>
                
                 
                    
                  
                </td>
                <td style="width:15%">
                 <?=  
                 $form->field($modelRequisitionitem, "[{$i}]specs")->textInput(['autofocus' => true])
                              
                 
                 ?> 
                </td>
                
                 <td style="width:5%">
                    
                    <?=  
                 $form->field($modelRequisitionitem, "[{$i}]uom")->textInput(['autofocus' => true])
                              
                 
                 ?> 
                </td>
                
                <td  style="width:5%" >
                    
                    <?=  
                 $form->field($modelRequisitionitem, "[{$i}]quantity")->textInput(['onchange' => 'getTotal($(this))'])
                              
                 
                 ?> 
                </td>
                
                <td nowrap style="width:10%">
                   <?=  
                 $form->field($modelRequisitionitem, "[{$i}]badget_code")->textInput(['autofocus' => true])
                              
                 
                 ?>  
                    
                </td>
                
                 <td nowrap style="width:5%">
                    
                    <?=  
                 $form->field($modelRequisitionitem, "[{$i}]unit_price")->textInput(['onchange' => 'getTotal($(this))'])
                              
                 
                 ?> 
                 </td>
                 
                  <td  nowrap style="width:10%" >
                    
                    <?=  
                 $form->field($modelRequisitionitem, "[{$i}]total_amount")->textInput(['autofocus' => true,'class'=>'form-control total_one '])
                              
                 
                 ?> 
                </td>
              
                <td class="text-center vcenter" style="width:10%; verti">
                    <button type="button" class="remove-item btn btn-danger btn-xs bg-red btn-circle"><span style="font-size:16px;" class="fa fa-minus-circle "></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
    <tr>
       <td align="right" colspan="6"><b>Total Price :</b></td>
      <td  class="TotalCell">0</td>
      <td  class="text-center"><button type="button" class="add-item btn btn-success btn-xs bg-green btn-circle"><span style="font-size:16px;" class="fa fa-plus-circle"></span></button></td>
    </tr>
  </tfoot>
    </table>
   </div> 
    
    <?php DynamicFormWidget::end(); ?>
                </div>
                
                    
                <div id="step-3"  class="tab-pane" role="tabpanel">
                   
                  <h3 class="border-bottom border-gray pb-2">Upload Supporting Doc(s) if available</h3> 
                  
                  
                   <?php
                    
                    if(!$model->isNewRecord){
                        
                     $docs1=ErpRequisitionAttachement::find()->where(['pr_id'=>$model->id])->all(); 
                     $preview1=array();
                        $config_prev1=array();
                     
                     if(!empty($docs1)){
                         
                         foreach($docs1 as $doc1){
                             
                             $preview1[]=Yii::$app->request->baseUrl.'/'.$doc1->attach_upload;
                             $config1=(object)["type"=>"pdf",  "caption"=>$doc1->attach_name, "key"=>$doc1->id, 
                             'url' => \yii\helpers\Url::toRoute(['erp-requisition-attachement/delete','id'=>$doc1->id])];
                             $config_prev1[]=$config1;
                         }
                     }
                        
                    }
                   
                    
                    ?>
                  
                 
                  
                  
                  <?= $form->field($model2, 'attach_files[]')->widget(FileInput::classname(), [
                                                 'options' => ['accept' => 'file/*','multiple' => true
                                                 
                                                 ],
                                                 'pluginOptions'=>['allowedFileExtensions'=>['pdf','jpg'],
                                                  'theme'=>'fas',
                                                 'showUpload' => false,
                                                 'uploadUrl' => '/erp-requisition-attachement/create',
                                                 'initialPreview'=>!empty($preview1)?$preview1:[],
                                                 'overwriteInitial'=>false,
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

</div>
<?php
$url=Url::to(['erp-persons-in-position/populate-names']); 

if(!$model->isNewRecord){
    
    $label='Update';
}else{
    
    $label='Save';
}

$script = <<< JS



$('.total_one').number( true,2);

function getTotal(item){

var idString=item.attr('id') ;
var arr= idString.split("-"); 
var  id=arr[1];


var price=document.getElementById('erprequisitionitems-'+id+'-unit_price').value;
var quatity=document.getElementById('erprequisitionitems-'+id+'-quantity').value;

/*if(price){
    
    var p=price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    document.getElementById('erprequisitionitems-'+id+'-unit_price').value=p;
}*/


if(!price){
  price=0;  
}
if(!quatity){
  quatity=0;  
}

//--------------------remove separator----------------
if(price && price!=0){
//price=price.replace(/([.,])(\d\d\d\D|\d\d\d$)/g,'$2');  
price=price.replace(/,/g, '');
}

var tot=parseFloat(price)*parseFloat(quatity);



//-----------add separator------------------
//var tot1=tot.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")

 document.getElementById('erprequisitionitems-'+id+'-total_amount').value=tot;
  
 
 
 var sum=0;
 $(".total_one").each(function() {

    var value = $(this).val();
    
    value=value.replace(/,/g, '');
   
    if(!isNaN(value) && value.length != 0) {
        sum += parseFloat(value);
    }
   
   
      
});
 

 
 $('#items tr').each(function() {
  
  var tot3=sum.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
  
  $(this).find(".TotalCell").text(tot3); 
    





 });
 
 
 
   

}

JS;
$this->registerJs($script,$this::POS_HEAD);




$script = <<< JS

/*

document.getElementById('erprequisitionitems-0-quantity').onchange = function() {
 setTotal(this,'q');
 
};

document.getElementById('erprequisitionitems-0-unit_price').onchange = function() {
 setTotal(this,'p');
};

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    console.log(item);
    var input_qty=$('tr.item').find('td:eq(3) input').attr("onchange", "setTotal(this,'q');");
    var input_price=$('tr.item').find('td:eq(5) input').attr("onchange", "setTotal(this,'p');");


    
    
    
    
});
*/

$(document).ready(function(){

            // Step show event
              $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
               
               if(stepDirection=='backward')return true;
    
    data = $("#dynamic-form").data("yiiActiveForm");
$.each(data.attributes, function() {
    this.status = 3;
});
$("#dynamic-form").yiiActiveForm("validate");
 
    var stepContent=stepNumber+1;
   

  
   
      if($("#step-"+stepContent).find(".has-error").length>0){
            e.preventDefault();
           
           return false;
        }
        
       
   
    return true;
   
             
            });
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
               //alert("You are on step "+stepNumber+" now");
               if(stepPosition === 'first'){
                   $("#prev-btn").addClass('disabled');
               }else if(stepPosition === 'last'){
                   $("#next-btn").addClass('disabled');
               }else{
                   $("#prev-btn").removeClass('disabled');
                   $("#next-btn").removeClass('disabled');
                   
               }
               
               
              //------------------------show attachment button-------------------------------
              if(stepPosition === 'last'){
                  
                 $('.submit').show(); 
              }else{
                  
                $('.submit').css("display","none") ; 
              }
               
           });

            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text('{$label}')
                                             .addClass('btn btn-info submit')
                                             .on('click', function(){ $('#dynamic-form').submit();});
                                             
         
                                             
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });
         

              smartWizardConfig.init(0,[btnFinish ],theme='arrows',animation='none');


            // External Button Events
            $("#reset-btn").on("click", function() {
                // Reset wizard
                $('#smartwizard').smartWizard("reset");
                return true;
            });

            $("#prev-btn").on("click", function() {
                // Navigate previous
                $('#smartwizard').smartWizard("prev");
                return true;
            });

            $("#next-btn").on("click", function() {
                // Navigate next
                /*$('#smartwizard').smartWizard("next");
                return true;*/
                
                alert();
            });

            $("#theme_selector").on("change", function() {
                // Change theme
                $('#smartwizard').smartWizard("theme", $(this).val());
                return true;
            });

            // Set selected theme on page refresh
            $("#theme_selector").change();
       
       
       //--------------------------------END WIZARD CONFIG------------------------------------------------------------------
       
       $('.unit_price').number( true);
       
           var sum=0;
 $(".total_one").each(function() {

    var value = $(this).val();
    
    value=value.replace(/,/g, '');
   
    if(!isNaN(value) && value.length != 0) {
        sum += parseFloat(value);
    }
   
   
      
});
 

 
 $('#items tr').each(function() {
  sum=parseFloat(sum).toFixed(2);
  var tot3=sum.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
  
  $(this).find(".TotalCell").text(tot3); 
    

 });
       
       
   
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


 $(function () {
       
     //--------------------------------------------------init select2-------------------------------------------------       
          
           $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
 });
 



 

JS;
$this->registerJs($script);

?>