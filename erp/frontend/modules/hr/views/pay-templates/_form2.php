<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use frontend\modules\hr\models\PayItems;
use frontend\modules\hr\models\ PayGroups;
use frontend\modules\hr\models\PayItemCategories;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\Locations */
/* @var $form yii\widgets\ActiveForm */
?>
 
 
 <?php
    $gross_code=PayItemCategories::GROSS_CODE;
    $net_code=PayItemCategories::NET_CODE;
    $en_code=PayItemCategories::EN_CODE;
    $ded_code=PayItemCategories::DED_CODE;
    
//-----------only fixed items are used here-------------------------------------------  
    $query=new \yii\db\Query(); 
      $rows=$query->select(['pitem.*','pcateg.code']) 
            ->from('pay_items as pitem')
             ->join('INNER JOIN', 'pay_item_categories as pcateg',
              'pitem.edCategory =pcateg.id')
            ->where(['pitem.pay_frequency'=>'fixed']) 
            ->all(\Yii::$app->db4);
            
         $data=array();
       
         
         foreach($rows as $pitem){
          
         $data[$pitem['code']][]=$pitem;
            
         }
   
    $earningItemsList=ArrayHelper::map($data[$en_code],'edCode','edDesc');
                         
    $deductionItemsList=ArrayHelper::map($data[$ded_code],'edCode','edDesc'); 
                         
   
   
   $totalItemsList=ArrayHelper::map(PayItems::find()->alias('it')->innerJoinWith('category')
    ->andFilterWhere(['or',['pay_item_categories.code' =>$gross_code],['pay_item_categories.code' =>$net_code]])->all(), 'edCode', function($c){
                            return $c->edDesc; 
                             
                         });                    
  
               ?>
<style>
    
#items tr.item td input{ padding: 15px 1px 5px;}
/*.card-wrapper{font-family: 'Lato', sans-serif;}   */ 
</style>

                 <div class="card card-default text-dark card-wrapper">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-layer-group"></i> Add New Pay Structure Template</h3>
                       </div>
               
           <div class="card-body">
               
              

    <?php $form = ActiveForm::begin(['id'=>'dynamic-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
     
     <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
 
    <?= $form->field($model, 'description')->textArea(['rows' =>3]) ?>
    
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
<?php echo Html::listBox('ed', '',  $earningItemsList, $htmlOptions);  ?>


</div>   
  <div class="box1 col-md-6">   
 
<span class="info-container">     <span class="info">Fixed Deductions</span>    
<input class="form-control filter mb-1" type="text" placeholder="Filter">   
<?php echo Html::listBox('ed', '',  $deductionItemsList, $htmlOptions);  ?>


</div>  

<div class="box1 col-md-2">   
 
<span class="info-container">     <span class="info">Total Items</span>    
<input class="form-control filter mb-1" type="text" placeholder="Filter">   
<?php echo Html::listBox('global', '',    $totalItemsList, $htmlOptions);  ?>


</div> 
</div>

</div>
</div>
</div>
            </div>
            <div class="modal-footer justify-content-between">
            
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success formula-save">Save</button>
              
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      
      <?php
       $earningItemsList=ArrayHelper::map($data[$en_code],'id','edDesc');
                         
       $deductionItemsList=ArrayHelper::map($data[$ded_code],'id','edDesc'); 
      
      ?>
     

                 <div class="card card-default">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fas fa-tags"></i> <b>Fixed Earnings </b> <span class="text-muted">[apply to every pay period until you remove/stop it]</span></h3> 
                       </div>
               
           <div class="card-body">
               
                
                    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-earning-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' =>10, // the maximum times, an element can be added (default 999)
        'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsEarning[0],
        'formId' => 'dynamic-form',
        'formFields' => [
           'item',
           'calc_type',
           'formula',
           'amount',
           
        ],
    ]); ?>
   
    
    <div class="table-responsive">
     <table id="earnings" style="width:100%" class="table table-bordered">
        <thead>
          
            <tr>
               
                <th>Pay Item</th>
                <th>Calculation Method</th>
                  <th>Formula</th>
                   <th>Default Amount</th>
                 
                    
                <th>
                 <i class="fas fa-cog"></i>
                </th>
            </tr>
        </thead>
        <tbody class="container-earning-items">
       <?php foreach ($modelsEarning as $i => $modelEarning): ?>
            <tr class="item vcenter " >
               
                
                <td  width="25%">
                    
                     <?php
                            // necessary for update action.
                            if (! $modelEarning->isNewRecord) {
                                echo Html::activeHiddenInput($modelEarning, "[{$i}]id");
                            }
                            
                        ?> 
                 
              
                 
                  <?= $form->field($modelEarning, "[{$i}]item")
                  ->dropDownList($earningItemsList, ['prompt'=>'Select Item',
               'class'=>['form-control m-select2 component-id ']])->label(false) ?>   
                 
                </td>
                
             
               
                <td width="20%">
                
                  <?= $form->field($modelEarning, "[{$i}]calc_type")->dropDownList([ 'formula' => 'Formula', 
                 'fixed'=>'Fixed Amount','open'=>'At Pay Time' ], ['prompt'=>'Select  calculation',
              'class'=>['form-control m-select2 calc-en '],'onchange'=>'onCalcTypeSelect($(this))'])->label(false) ?>     
                </td>
                
                 <td>
               
               
               
              <?=  $form->field($modelEarning, "[{$i}]formula",['template' => '
                       
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
               
                <td width="10%">
                   
              <?=  $form->field($modelEarning, "[{$i}]amount")->textInput(['class'=>['form-control input-amount'],'placeholder'=>'amount...'])->label(false) ?>      
                   
               </td>
                <td class="text-center vcenter">
                 
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
               
     <div class="card card-default ">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fas fa-tags"></i>  <b>Fixed Deductions </b><span class="text-muted">[apply to every pay period until you remove/stop it]</span></h3>
                       </div>
               
           <div class="card-body">
         
                  
                    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-ded-items', // required: css class selector
        'widgetItem' => '.item_ded', // required: css class
        'limit' =>10, // the maximum times, an element can be added (default 999)
        'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-item-eng', // css class
        'deleteButton' => '.remove-item-eng', // css class
        'model' => $modelsDeduction[0],
        'formId' => 'dynamic-form',
        'formFields' => [
           'item',
           'calc_type',
           'formula',
           'amount',
           
        ],
    ]); ?>
   
    
    <div class="table-responsive">
     <table id="deductions" style="width:100%" class="table table-bordered">
        <thead>
          
            <tr>
               
                <th>Pay Item</th>
                <th>Calculation Method</th>
                  <th>Formula</th>
                   <th>Default Amount</th>
                 
                    
                <th>
                 <i class="fas fa-cog"></i>
                </th>
            </tr>
        </thead>
        <tbody class="container-ded-items">
       <?php foreach ($modelsDeduction as $i => $modelDeduction): ?>
            <tr class="item_ded vcenter " >
               
                
                <td width="25%">
                    
                     <?php
                            // necessary for update action.
                            if (! $modelDeduction->isNewRecord) {
                                echo Html::activeHiddenInput($modelDeduction, "[{$i}]id");
                            }
                            
                
                        ?> 
                 
              
                 
                  <?= $form->field($modelDeduction, "[{$i}]item")
                  ->dropDownList( $deductionItemsList, ['prompt'=>'Select Item','class'=>['form-control m-select2 component-id ']])->label(false) ?>   
                 
                </td>
                
             
               
                <td width="20%">
                
                  <?= $form->field($modelDeduction, "[{$i}]calc_type")->dropDownList([ 'formula' => 'Formula', 
                 'fixed'=>'Fixed Amount','open'=>'At Pay Time' ], ['prompt'=>'Select  calculation',
               'class'=>['form-control m-select2 calc-ded '],'onchange'=>'onCalcTypeSelect($(this))'])->label(false) ?>     
                </td>
                
                 <td>
               
               
               
              <?=  $form->field($modelDeduction, "[{$i}]formula",['template' => '
                       
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
               
                <td width="10%">
                   
              <?=  $form->field($modelDeduction, "[{$i}]amount")->textInput(['class'=>['form-control input-amount'],'placeholder'=>'amount...'])->label(false) ?>      
                   
               </td>
                <td class="text-center vcenter">
                 
                    <button type="button" class="remove-item-eng btn btn-danger btn-xs bg-red btn-circle"><span style="font-size:16px;" class="fa fa-minus-circle "></span></button>
              
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
    <tr>
     
      <td colspan="5"  class="text-right"><button type="button" class="add-item-eng btn btn-success btn-xs bg-green btn-circle"><span style="font-size:16px;" class="fa fa-plus-circle"></span></button></td>
    </tr>
  </tfoot>
    </table>
   
   </div> 
    
    <?php DynamicFormWidget::end(); ?>     
               </div>
               
               </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?'Save':'Update', ['class' =>$model->isNewRecord?'btn btn-primary':'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>

</div>
<?php

$script = <<< JS
$('#earnings').DataTable( {
       retrieve: true,
	  paging: false,
      lengthChange: false,
      searching: false,
      ordering: false,
      info: false,
      autoWidth: true,
       responsive: true,
     
     
		
	
	} );
	
	$('#deductions').DataTable( {
       retrieve: true,
	  paging: false,
      lengthChange: false,
      searching: false,
      ordering: false,
      info: false,
      autoWidth: true,
       responsive: true,
     
     
		
	
	} );
$(document).ready(function(){


            

   	    
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

     //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
     $(".m-select").select2({width:'80%',theme: 'bootstrap4'});
     
   
   $(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
        $(item).find("td:eq(3) input").val("0.00");
         $(item).find("td:eq(2) input").val("");
         $(item).find("td:eq(1) select").prop('selectedIndex', 0);
        

   
});

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
     $(item).find("td:eq(3) input").val("0.00");
     $(item).find("td:eq(2) input").val("");
     $(item).find("td:eq(1) select").prop('selectedIndex', 0);
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

function isMathExpression (str) {
  try {
    Complex.compile(str);
  } catch (error) {
    return false;
  }
  
  return true;
}
     
});

 


JS;
$this->registerJs($script);

$script1 = <<< JS



function onCalcTypeSelect(select){
var inputAmount = select.closest('tr').find("td input.input-amount"); 
var inputFormula = select.closest('tr').find("td input.input-formula");
console.log(select.val());

 if(select.val()==='fixed' || select.val()==='open'){
   
    if( inputAmount.is(":disabled")){
       
       inputAmount.prop("disabled", false);  
       
         
     }
     inputFormula.prop("disabled", true);
     //inputAmount.val('');
   
     

 }else if(select.val()==='formula'){
  
  if( inputFormula.is(":disabled")){
       
       inputFormula.prop("disabled", false);  
      
         
     }
     inputAmount.prop("disabled", true);
     inputFormula.val(''); 
  
 }else{
     inputFormula.prop("disabled", false); 
     inputFormula.prop("disabled", false);  
   }
}

JS;
$this->registerJs($script1,$this::POS_HEAD);

?>