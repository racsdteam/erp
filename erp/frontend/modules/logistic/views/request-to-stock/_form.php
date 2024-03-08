<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use common\models\Items;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use buttflattery\formwizard\FormWizard;
use kartik\popover\PopoverX;
use common\models\Categories;
use common\models\SubCategories;


//--------------------all Items------------------------------------------------
$items=ArrayHelper::map(Items::find()->all(), 'it_id', function($item){
    return $item['it_name']."/ ".$item['it_code']." / ".$item['it_unit'];
}) ;
?>

<div class="request-to-stock-form">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i> Create Stock voucher</h3>
                       </div>
               
           <div class="card-body">
  <?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data', 'data-toggle'=>'validator'],
                                'id'=>'dynamic-form', 
                               'enableClientValidation'=>true,
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               ]); ?>                              
                  
                    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper2', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items2', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 500, // the maximum times, an element can be added (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsItem[0],
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
     <table id="items" style="width:100%" class=" table-bordered table-striped">
        <thead>
            <tr>
               
    <th  style="color:#2196f3;font-weight:bold;" colspan="8">
        
   <h4 style="display:inline;" class="card-title"><i class="fa fa-cart-arrow-down"></i> Request Items form</h4>
    
   
    
  
    </th>
    
   
                
            </tr>
            <tr>
                
                  <th>name / Item code   / Unit of measurment </th>
                 <th>Requested Quantity </th>
                <th  class="text-center" style="width:10%;">
                   Add/Remove Item
                </th>
            </tr>
        </thead>
        <tbody class="container-items2">
       <?php foreach ($modelsItem as $i => $modelItem): ?>
            <tr class="item">
         <td>
                        <?= $form->field($modelItem, "[{$i}]it_id")
                        ->widget(Select2::classname(), [
    'data' => $items,
    'bsVersion'=>'4.x',
    'theme' => Select2::THEME_KRAJEE_BS4,
    'options' => [
        'placeholder' => 'Select a Item ...',
        
    ],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>
                    
                  
                </td>

                 <td>
                    
                    <?=  
                 $form->field($modelItem, "[{$i}]req_qty")->textInput(['autofocus' => true,'onchange'=>'checkStock($(this))'])
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
       <td style="font-size:18px" align="right" colspan="2"><b>Add new Item:</b></td>
      <td  class="text-center"><button type="button" class="add-item btn btn-success btn-xs bg-green btn-circle"><span style="font-size:16px;" class="fa fa-plus-circle"></span></button></td>
    </tr>
  </tfoot>
    </table>
   </div> 
    
    <?php DynamicFormWidget::end(); ?>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
           
                </div>
</div>
</div>
</div>
<?php
$curl=Url::to(['check-stock/get-sub-categories']);
$surl=Url::to(['check-stock/get-items']);
$script1 = <<< JS

 
 function getSubCategories(value,id)
{
  
var arr= id.split("-"); 
var  id=arr[1];

     $.get('{$curl}',{ category : value },function(data){
        var subcat='#requesttostock-'+id+'-subcategory';
          $(subcat).html(data);
    });
   
}
function getItems(value,id)
{
  
var arr= id.split("-"); 
var  id=arr[1];

     $.get('{$surl}',{subcategory : value },function(data){
        
        var Iditem='#itemsrequest-'+id+'-it_id';
          $(Iditem).html(data);
    });
   
}
JS;
$this->registerJs($script1,$this::POS_HEAD);


$script2 = <<< JS
$(document).ready(function(){

 

 
 //-------------------------=========initialize dates and time widgets================--------------------------------------  
   	    
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
			
			
$(function () {
    //Initialize Select2 Elements
   $(".Select2").select2({width:'100%',theme: 'bootstrap4'});
   
 });

$(".dynamicform_wrapper2").on("beforeInsert", function(e, item) {
        $(".Select2").select2({width:'100%',theme: 'bootstrap4'});
        
    
});			

$(".dynamicform_wrapper2").on("afterInsert", function(e, item) {
        $(".Select2").select2({width:'100%',theme: 'bootstrap4'});
    
});	
       
        });

JS;
$this->registerJs($script2);

$url=Url::to(['check-stock/check']); 

$script_1 = <<< JS

 function checkStock(selectitem)
{

var idString=selectitem.attr('id') ;
var arr= idString.split("-"); 
var  id=arr[1];

var itemselect =document.getElementById('itemsrequest-'+id+'-it_id');
var item = itemselect.options[itemselect.selectedIndex].value;
var quantity=document.getElementById('itemsrequest-'+id+'-req_qty').value;
if(quantity!=0)
{
     $.get('{$url}',{ item : item, quantity: quantity },function(data){
        
         data=JSON.parse(data);
          if(!data['flag'])
          {
              document.getElementById('itemsrequest-'+id+'-req_qty').value=0;
               Swal.fire('Error',data['message'],'error');
          }
    });
}
}
JS;
$this->registerJs($script_1,$this::POS_HEAD);

?>
