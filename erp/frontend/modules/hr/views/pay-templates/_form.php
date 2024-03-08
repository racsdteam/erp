<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use frontend\modules\hr\models\PayItems;
use frontend\modules\hr\models\ PayGroups;
use frontend\modules\hr\models\PayItemCategories;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this); 

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\Locations */
/* @var $form yii\widgets\ActiveForm */
?>
 
 
 <?php
         

         $earningsType=ArrayHelper::map(PayItems::find()->earnings()->all(),'code', 'name');
         $deductionTypes=ArrayHelper::map(PayItems::find()->deductions()->all(),'code', 'name');
         $totalTypes=ArrayHelper::map(PayItems::find()->totals()->all(),'code', 'name');
         $itemsList=ArrayHelper::map(PayItems::find()->all(), 'id','name');
  
               ?>
<style>
    
#items tr.item td input{ padding: 15px 1px 5px;}

</style>

                 <div class="card card-default text-dark card-wrapper">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-layer-group"></i> Add New Pay  Template</h3>
                       </div>
               
           <div class="card-body">
               
               <?php
               
                            
 if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
               ?>
               
                <?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data'],
                                'id'=>'dynamic-form', 
                               'enableClientValidation'=>true,
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                              
                               ]); ?>
               
             <div id="smartwizard">
            
            
            <ul class="nav">
                
                <li><a class="nav-link" href="#step-1"><strong><i class="fas fa-coins"></i> Pay Template Details</strong></a></li>
                <li><a class="nav-link" href="#step-2"><strong><i class="fas fa-money-bill-wave"></i> Applicable Pay Items</strong></a></li>
               
                
               
            </ul>

            <div class="tab-content">
                
            <div class="tab-custom-content">
            
            </div>  
                
                <div id="step-1" class="tab-pane" role="tabpanel">
                    
                    
   

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
     
     <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
 
    <?= $form->field($model, 'description')->textArea(['rows' =>3]) ?>
     
     <?= $form->field($model,  'pay_group')->dropDownList([ArrayHelper::map(PayGroups::find()->all(), 'id', 'name')], ['prompt'=>'Select payroll group',
               'id'=>'pay-group-id','class'=>['form-control m-select2 ']])->label("Payroll Group") ?> 
      <?= $form->field($modelSettings, 'copy')->checkbox(['id'=>'checkCopy'])
			->label('Copy Items from existing Template'); ?> 
			
<div id="divCopy">
    
 <?= $form->field($modelSettings, 'copyTemplate')->dropDownList([], ['prompt'=>'Select Pay Template To Copy',
               'id'=>'prev','class'=>['form-control  m-select2 ']])->label("Pay Template To Copy") ?>     
    
    
</div>	          
               
                 </div> 
              
 <div id="step-2" class="tab-pane" role="tabpanel">
              
               
                
                    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-earning-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' =>30, // the maximum times, an element can be added (default 999)
        'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsItem[0],
        'formId' => 'dynamic-form',
        'formFields' => [
           'item',
           'item_code',
           'calc_type',
           'formula',
           'amount',
           
        ],
    ]); ?>
   
    
    <div class="table-responsive">
     <table id="tbl-items" style="width:100%;" class="table table-bordered">
        <thead>
          
            <tr>
              
                <th>Pay Item</th>
                 <th>Input Type</th>
                  <th>Formula</th>
                   <th>Amount</th>
                 <th>
                 <i class="fas fa-cog"></i>
                </th>
            </tr>
        </thead>
        <tbody class="container-earning-items">
       <?php foreach ($modelsItem as $i => $modelItem): ?>
            <tr class="item vcenter " >
               
                
                <td style="word-wrap: break-word;" width="35%">
                    
                     <?php
                            // necessary for update action.
                            if (! $modelItem->isNewRecord) {
                                echo Html::activeHiddenInput($modelItem, "[{$i}]id");
                            }
                            
                        ?> 
                 
              
                 
                  <?= $form->field($modelItem, "[{$i}]item")
                  ->dropDownList($itemsList, ['prompt'=>'Select Item',
               'class'=>['form-control m-select2'],'onchange' => 'onItemSelect($(this))'])->label(false) ?>   
                 
                </td>
                
             
               
                <td width="20%">
                
                  <?= $form->field($modelItem, "[{$i}]calc_type")->dropDownList(['fixed'=>'Fixed Amount','formula' => 'Formula',
                 'open'=>'User Enterred' ], ['prompt'=>'Select input Type',
              'class'=>['form-control m-select2 calc-en '],/*'onchange'=>'onCalcTypeSelect($(this))'*/])->label(false) ?>     
                </td>
                
                 <td>
               
              
              
              <?=  $form->field($modelItem, "[{$i}]formula",['template' => '
                       
                       <div class="input-group col-sm-12">
                          {input}
                       <div class="input-group-append">
                               
                               <a data-toggle="modal" href="#modal-formula" class="btn btn-outline-success  open-AddFormulaDialog ">
           <i class="fas fa-angle-down"></i>
          </a>
                               
                                </div>
                     
                          
                           
                           
                       </div>{error}{hint}
               '])->textInput(['class'=>['form-control input-formula'],'placeholder'=>'formula...'])->label(false) ?> 
            
       
               </td>
               
                <td width="12%">
                 
              <?=  $form->field($modelItem, "[{$i}]amount")->textInput(['class'=>['form-control input-amount'],'placeholder'=>'Amt...'])->label(false) ?>      
                   
               </td>
                <td width="1%" class="text-center vcenter">
                 
                    <button type="button" class="remove-item btn btn-danger btn-xs bg-red btn-circle"><span style="font-size:16px;" class="fa fa-minus-circle "></span></button>
              
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
    <tr>
     
      <td colspan="5"  class="text-right"><button type="button" class="add-item btn btn-success btn-xs bg-green btn-circle"><span style="font-size:16px;" class="fa fa-plus-circle"></span></button></td>
    </tr>
  </tfoot>
    </table>
   
   </div> 
    
    <?php DynamicFormWidget::end(); ?>
                
                 </div> 
                 </div>
                 </div>  
     
   

    <?php ActiveForm::end(); ?>


</div>

</div>

<div class="modal  fade " id="modal-formula" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          
          <div class="modal-content bg-primary ">
            
            <div class="modal-header">
              <h4 id="defaultModalLabel" class="modal-title"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            
            <div class="modal-body">
          
                <div class="card card-default text-dark card-wrapper">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-laptop-code"></i> Add New Formula </h3>
                       </div>
               
           <div class="card-body">

           <div class="form-inputs">
    
          <input type="hidden" name="refId" id="refId" value=""/>
   
                     <div class="form-group">
                       
                        <textarea  class="form-control formula-box"  name="formula" rows="3" ></textarea>
                      </div>
   
   
 <?php 
    $htmlOptions = ['class'=>'custom-select components'];
 
?>

<div class="row">
 <div class="box1 col-md-4">   
 <span class="info-container">     <span class="info">Fixed Earnings</span>    
<input class="form-control filter mb-1" type="text" placeholder="Filter">   
<?php echo Html::listBox('ed', '',  $earningsType, $htmlOptions);  ?>
</div>

 <div class="box1 col-md-6">   
 <span class="info-container">     <span class="info">Fixed Deductions</span>    
<input class="form-control filter mb-1" type="text" placeholder="Filter">   
<?php echo Html::listBox('ed', '',  $deductionTypes, $htmlOptions);  ?>
</div>  


<div class="box1 col-md-2">   
 <span class="info-container">     <span class="info">Total Items</span>    
<input class="form-control filter mb-1" type="text" placeholder="Filter">   
<?php echo Html::listBox('global', '',    $totalTypes, $htmlOptions);  ?>
</div> 

</div><!--end row----->

</div><!----form-inputs-->

</div><!----card-body-->
</div><!---end card--->

</div><!----modal-body-->
            
            <div class="modal-footer justify-content-between">
            
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success formula-save">Save</button>
              
            </div>
            
            
          </div><!----modal-content-->
        
        </div><!----modal-dai-->
      </div><!----modal-->
     
   
<?php

$isNewRecord=json_encode($model->isNewRecord);
$get_pay_item_url=\yii\helpers\Url::to(['pay-items/get-item-by-id']);
$urlToCopy=Url::to(['pay-templates/copy-list']);
$script = <<< JS


$(document).ready(function(){

$("div#divCopy").hide().find('input:text,input:hidden, select').prop("disabled",true); 
            // Step show event
              $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
                
         //--------------------------prevent backward validation       
                if(stepDirection=='backward')return true;
    
    data = $("#dynamic-form").data("yiiActiveForm");
$.each(data.attributes, function() {
    this.status = 3;
});
$("#dynamic-form").yiiActiveForm("validate");

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
               
             
              //------------------------show Save button-------------------------------
              if(stepPosition === 'last')
              {
                 $('.finish').show(); 
            
                  
              }
              else{
                  
                $('.finish').css("display","none") ; 
              }
              
             
               
            });

             var isNewRecord=$isNewRecord;
             var btnText=isNewRecord?'Save':'Update';
            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text(btnText)
                                             .addClass('btn btn-info finish')
                                             .on('click', function(){ $('#dynamic-form').submit();});
            $('.finish').css("display","none") ;                                
         
                                             
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger btn-cancel')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });
                                             
            
                                            
                smartWizardConfig.init(0,[btnFinish],theme='dots',animation='none');
                                        
            

    $('#tbl-items').DataTable( {
      destroy: true,
	  paging: false,
      lengthChange: false,
      searching: false,
      ordering: false,
      info: false,
      autoWidth: true,
       responsive: true,
      language: {
      emptyTable: " "
    }
       
     /*language : {
        "zeroRecords": " "             
    },*/
     
		
	
	} );

   	    
	
     //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
    
     
   
   $(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
      
        
      //$(item).find('input:text, select, textarea').val('');
   
});

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    // $(item).find('input:text, select, textarea').val('');
    
});

var ta = $(".formula-box");
 ta.focus();
 $(".filter").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".components option").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });


 $('.components option').click(function(){
      ta.val(ta.val()+$(this).val()+' ').focus();
 
});
   
$("#modal-formula").on("hidden.bs.modal", () => {

 $(this).find(".form-inputs input[type=text], textarea").val("");
 $(this).find(".form-inputs select").prop('selectedIndex', -1);
});   
  
  
  $(document).on("click", ".open-AddFormulaDialog", function () {
      
     var refId = $(this).closest('.input-group').find('input').attr('id');
 
     $(".modal-body #refId").val(refId );
   
});


  
 $(".formula-save").on("click", () => {

 var formula=$('.form-inputs').find("textarea").val();
  if(formula!=''){
   
   var refid= $(".modal-body #refId").val();
  
   
    $('#'+refid).val(formula) ;
    
    $("#modal-formula").modal('hide');
  
  }else{
      
      alert("Please Enter Formula");return ;
  }
}); 


 $('#checkCopy').on('change', function(event) {
   
   if ($(this).is(":checked")) {
                $("#divCopy").show().find('input:text,input:hidden, select').prop("disabled",false);
                
                  $.ajax({
  url: "{$urlToCopy}",
  type: "get", //send it through get method
  data: {},
  success: function(data) {
   
   $( "select#prev" ).html( data );
   var defaultOption = new Option("Select Template To Copy","");
   defaultOption.selected = true;    
   $("select#prev").prepend(defaultOption);
   
  },
  error: function(xhr) {
    console.log(xhr);
  }
});
                
            } else {
                $("#divCopy").hide().find('input:text,input:hidden, select').prop("disabled",true);
               
               
            }
         
   
        });   


});

 


JS;
$this->registerJs($script);

$script1 = <<< JS

function onItemSelect(select){
  
  var itemid=select.val();
  var inputCode = select.closest('tr').find("td input.item-code"); 
  var inputCateg = select.closest('tr').find("td input.item-categ");
  var inputPayType = select.closest('tr').find("td input.item-pay-type");

  
    $.ajax({
            url: "$get_pay_item_url",
            type: 'post',
            data: {id:itemid},
            dataType: 'json',
            success: function(res) {
            
             if(res.success){
              var data=res.data;
             
             inputCode.val(data.code);
             inputCateg.val(data.category);
             inputPayType.val(data.pay_type);
             
             console.log( inputCode.val())
             
            /* if(inputCode.val()!='')
             inputCode.prop("readonly", true);
             
             if(inputCateg.val()!='')
             inputCateg.prop("readonly", true);
             
             if(inputPayType.val()!='')
             inputPayType.prop("readonly", true);*/
                
            }
  },
  error: function(xhr) {
    console.log(xhr)
  }
        });
}
function onCalcTypeSelect(select){
var inputAmount = select.closest('tr').find("td input.input-amount"); 
var inputFormula = select.closest('tr').find("td input.input-formula");


 if(select.val()==='fixed' || select.val()==='open' || select.val()==='base'){
   
    if( inputAmount.is(":disabled")){
       
       inputAmount.prop("disabled", false);  
       
         
     }
     inputFormula.prop("disabled", true);
     //inputAmount.val('');
   
     

 }else if(select.val()==='formula'){
  
  if( inputFormula.is(":disabled")){
       
       inputFormula.prop("disabled", false);  
      
         
     }
     //inputAmount.prop("disabled", true);
     inputFormula.val(''); 
  
 }else{
     inputFormula.prop("disabled", false); 
     inputFormula.prop("disabled", false);  
   }
}
//------check value validation
function isCopyOptionChecked (attribute, value) {

return $('input:checkbox[name="DynamicModel[copy]"]').is(':checked');
	};

JS;
$this->registerJs($script1,$this::POS_HEAD);

?>