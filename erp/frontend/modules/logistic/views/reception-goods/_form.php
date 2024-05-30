<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\db\Query;
use common\models\User;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\Supplier;
use common\models\ItemsReception;
use common\models\Items;
use common\models\ItemsReceptionSupporting;

use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this); 


//--------------------all positions------------------------------------------------
$positions=ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ;

//--------------------all positions------------------------------------------------
$logistic_positions=ArrayHelper::map(ErpOrgPositions::find()
                              ->where(['report_to'=>'15'])
                              ->all(), 'id', 'position') ;

//--------------------all Items------------------------------------------------
$users=ArrayHelper::map(User::find()->all(), 'id',function($item){
    return  $item->first_name.' '.$item->last_name;
}) ;

//--------------------all Items------------------------------------------------
$items=ArrayHelper::map(Items::find()->all(), 'it_id',function($item){
    return  $item->it_code.' / '.$item->it_name.' / '.$item->it_unit;
}) ;

//--------------------all Items------------------------------------------------
$currency=["RwF"=>"RwF","USD"=>"USD"];

?>
<style>

</style>

<div class="row clearfix">

<div class="<?php if(!$isAjax){echo 'col-lg-12 col-md-12 col-sm-12 col-xs-12';}else{ echo 'col-lg-12 col-md-12 col-sm-12 col-xs-12';}  ?> ">

 <div class="card card-default">
     
               
           <div class="card-body">

 <?php if($model->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($model, ['encode' => false]) ?>
              </div>
            
            <?php endif?>
            
             <?php if(!empty($modelsAttachement)) :?>
            
            <?php foreach($modelsAttachement as $item) :?>
  
  <?php if($item->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($item, ['encode' => false]) ?>
              </div>
            
            <?php endif?>   
              
     
     <?php endforeach?>  
     
           <?php endif?>  


   <?php if (Yii::$app->session->hasFlash('success')){

$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  

   }
  

  
  ?>


<?php  
  $user=Yii::$app->user->identity;
 
  
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
                 
                <li><a href="#step-1" class="nav-link">Page 1<br /><small>Add Goods Recieved notes Details </small></a></li>
                <li><a href="#step-2" class="nav-link">Page 2<br /><small>Add Items Details</small></a></li>
                <li><a href="#step-3" class="nav-link">Page 3<br /><small>Goods Recieved notes  Support.Doc(s)</small></a></li>
              
            </ul>

            <div class="tab-content">
                
                <div id="step-1"  class="tab-pane" role="tabpanel">
                    <h2>Goods Receiption Details</h2>
                     <?php $suppliers=ArrayHelper::map(Supplier::find()->all(), 'id', 'name');
                    
                    ?>
                    
                    <?= $form->field($model, 'supplier')
        ->dropDownList($suppliers,['prompt'=>'Select type...','class'=>['form-control select2'],'id'=>'9'])->label('Supplier Name ')?>
        
   <?= $form->field($model, 'purchase_order_number')->textInput(['maxlength' => true]) ?>


                       
     <?php
     
     if(!$model->isNewRecord ){
         
     $preview2[]=Yii::$app->request->baseUrl."/".$model->delivery_notes;
                             $config=(object)['type'=>"pdf", 'key'=>$model->id ,
                             'downloadUrl'=>Yii::$app->request->baseUrl."/".$model->delivery_notes];
                             $config_prev[]=$config;
     }
     
     ?>
    
                 
          
   <?= $form->field($model, 'uploaded_file2')->widget(FileInput::classname(), [
                                                 'options' => ['accept' => 'file/*','multiple'=>false,'class'=>['clearfix']],
                                                 'pluginOptions'=>['allowedFileExtensions'=>['pdf','jpg'],'showUpload' => false,
                                                   'initialPreview'=>!empty($preview2)?$preview2:[],
                                                   'overwriteInitial'=>true,
                                                   'initialPreviewAsData'=>true,
                                                   'initialPreviewFileType'=>'image',
                                                   'initialPreviewConfig'=>$config_prev,
                                                   
                                                   
                                                  
  ],     
                                                
                                                                                    
  ])->label("Delivery notes")?> 
 
 <div class="row">
  
     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bg-green">
         
          <h3 style="display: inline;"><b> End user  department: </b></h3> (<em>position and person</em>) 
     </div>
     
     <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
     <?= $form->field($model, 'position1')->dropDownList($positions, 
	         ['prompt'=>'-Choose an option-','class'=>[' form-control select2'],'id'=>'10',
			   'onchange'=>'getEmployee(this.value,this.id)'])->label('Select Employee Position'); ?>   
      
  </div>
  
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
   <?= $form->field($model, 'end_user_officer')->dropDownList($users, 
	         ['prompt'=>'-Choose a employee-','class'=>['form-control select2 '],'id'=>'emp-10',])->label('Endesur Name (automatically filled in)'); ?>	   
      
  </div>
      
      

  

    

     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  bg-gray">
         
          <h3 style="display: inline;"><b>Store Keeper: </b></h3> (<em>position and person</em>) 
     </div>
     
     <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
     <?= $form->field($model, 'position2')->dropDownList($logistic_positions, 
	         ['prompt'=>'-Choose an option-','class'=>['form-control select2  '],'id'=>'11',
			   'onchange'=>'getEmployee(this.value,this.id)'])->label('Select Employee Position'); ?>   
      
  </div>
  
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
   <?= $form->field($model, 'store_keeper')->dropDownList($users, 
	         ['prompt'=>'-Choose a employee-','class'=>['form-control select2 '],'id'=>'emp-11' ,])->label('Store keeper (automatically filled in)'); ?>	   
      
  </div>
      
</div>

              
  <div class="form-group">
             

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar-alt"></i>
                  </div>
</div>
                <!-- /.input group -->
                  <?= $form->field($model, 'reception_date')->textInput(['maxlength' => true,'class'=>['form-control date pull-right','placeholder'=>'Ending date...']]) ?>
                  
                
              </div>               
    

  <?= $form->field($model, 'observation')->textarea(['rows' => 6]) ?>
               
 
                </div>
                <div id="step-2"  class="tab-pane" role="tabpanel">
                 
               
            

                              
                  
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
     <table id="items" style="width:100%" class="table1 table-bordered table-striped">
        <thead>
            <tr>
               
    <th  style="color:#2196f3;font-weight:bold;" colspan="8">
        
   <h4 style="display:inline;" class="card-title"><i class="fa fa-cart-arrow-down"></i>Goods Received Items</h4>
    
   
    
  
    </th>
    
   
                
            </tr>
            <tr style="padding:5px 5px">
               
                  <th style="width:40%;" >Item code / name / Unit of measurment </th>
                 <th style="width:10%">Quantity Ordered</th>
                 <th style="width:10%">Quantity Delivered</th>
                 <th style="width:20%">Unit_Price</th>
                 <th style="width:10%" >Type Currency</th>
                 <th style="width:10%;">VAT Inclused</th>
                <th  class="text-center" style="width:10%;">
                   Add/Remove Item
                </th>
            </tr>
        </thead>
        <tbody class="container-items2">
       <?php foreach ($modelsItem as $i => $modelItem): ?>
            <tr class="item">
                
                
                <td style="width:40%;">
                    
                     <?php
                            // necessary for update action.
                            if (! $modelItem->isNewRecord) {
                                echo Html::activeHiddenInput($modelItem, "[{$i}]id");
                            }
                        ?> 
                 
                        <?= $form->field($modelItem, "[{$i}]item")
        ->dropDownList($items,['prompt'=>'Select type...','class'=>['form-control select2']])->label(false)?>
                    
                  
                </td>
          
                 <td style="width:10%">
                    
                    <?=  
                 $form->field($modelItem, "[{$i}]item_qty_ordered")->textInput(['autofocus' => true])->label(false)
                 ?> 
                </td>
                
                <td  style="width:10%" >
                    
                    <?=  
                 $form->field($modelItem, "[{$i}]item_qty")->textInput(['autofocus' => true])->label(false)
                              
                 
                 ?> 
                </td>
                 <td style="width:20%">
                    
                    <?=  
                 $form->field($modelItem, "[{$i}]item_unit_price")->textInput(['autofocus' => true])->label(false)
                 ?> 
                </td>
                <td style="width:10%">
                <?= $form->field($modelItem, "[{$i}]total_currency")
        ->dropDownList($currency,['prompt'=>'Select type...','class'=>['form-control Select2']])->label(false)?>
                    
                   
                </td>
                   <td style="width:10%;">
                      <?php 
  $v_choices =["1"=>"Yes","0"=>"No"];
  ?>
                   
                  <?php echo $form->field($modelItem, "[{$i}]vat_included")->radioList($v_choices)->label(false);?> 
                </td>
                <td class="text-center vcenter" style="width:10%; verti">
                    <button type="button" class="remove-item btn btn-danger btn-xs bg-red btn-circle"><span style="font-size:16px;" class="fa fa-minus-circle "></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
    <tr>
       <td style="font-size:18px" align="right" colspan="6"><b>Add new Item:</b></td>
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
                /*   
                    if(!$model1->isNewRecord){
                        
                     $docs1=ItemsReceptionSupporting::find()->where(['pr_id'=>$model1->id])->all(); 
                     $preview1=array();
                        $config_prev1=array();
                     
                     if(!empty($docs1)){
                         
                         foreach($docs1 as $doc1){
                             
                             $preview1[]=Yii::$app->request->baseUrl.'/'.$doc1->attach_upload;
                             $config1=(object)[type=>"pdf",  caption=>$doc1->attach_name, key=>$doc1->id, 
                             'url' => \yii\helpers\Url::toRoute(['erp-requisition-attachement/delete','id'=>$doc1->id])];
                             $config_prev1[]=$config1;
                         }
                     }
                        
                    }*/
                   
                    
                    ?>
                  
                 
                  
                  
                  <?= $form->field($ItemsReceptionSupporting, 'attach_files[]')->widget(FileInput::classname(), [
                                                 'options' => ['accept' => 'file/*','multiple' => true
                                                 
                                                 ],
                                                 'pluginOptions'=>['allowedFileExtensions'=>['pdf','jpg'],
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
<?php


$script = <<< JS


$(document).ready(function(){

$('.table1').DataTable( {
        retrieve: true,//to be able to reintinialize
	  paging: false,
      lengthChange: true,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false,
      // responsive: true,
      dom: '<"d-flex justify-content-between mt-3" Blf>'+
       'tr' +
       '<"d-flex justify-content-between"ip>',
     buttons: {
        buttons: [{
          extend: 'print',
          text: '<i class="fas fa-print"></i> Print',
          title: $('h1').text(),
          exportOptions: {
            columns: ':not(.no-print)'
          },
          footer: true,
          autoPrint: true
        }, {
          extend: 'pdf',
          text: '<i class="far fa-file-pdf"></i> PDF',
          title: $('h1').text(),
          exportOptions: {
            columns: ':not(.no-print)'
          },
          footer: true
        }
        ,{
          extend: 'excel',
          text: '<i class="far fa-file-excel"></i> Excel',
          title: $('h1').text(),
          exportOptions: {
            columns: ':not(.no-print)'
          },
          footer: true
        }
        
        
        ],
        
        
        dom: {
          container: {
            className: 'dt-buttons'
          },
          button: {
            className: 'btn btn-default dt-button'
          }
        }
      }
		
	
	} );



//--------------------------------------smartwizard---------------------------------------
            // Step show event
              $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
             if(stepDirection=='backward'){
        
        return true;
    }   
   
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
               //alert("You are on step "+stepPosition+" now");
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
            var btnFinish = $('<button></button>').text('Save')
                                             .addClass('btn btn-success submit')
                                             .on('click', function(){ $('#dynamic-form').submit();});
                                             
         
                                             
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });
         
     // initSmartWizard(0,[btnUpload],theme='arrows',animation='none')
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
     
$(function () {
    //Initialize Select2 Elements
   $(".select2").select2({width:'100%',theme: 'bootstrap4'});
   
 });

$(".dynamicform_wrapper2").on("beforeInsert", function(e, item) {
        $(".select2").select2({width:'100%',theme: 'bootstrap4'});
        
    
});			

$(".dynamicform_wrapper2").on("afterInsert", function(e, item) {
        $(".select2").select2({width:'100%',theme: 'bootstrap4'});
    
});	
            //----------------init datepicker-----------------
             
		    
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





JS;
$this->registerJs($script);
$this->registerJs($script2);

$url=Url::to(['/doc/erp-persons-in-position/get-employee-names']); 

$script_1 = <<< JS



 function getEmployee(value,id)
{
    
     $.get('{$url}',{ position : value },function(data){
        
         
          $('#emp-'+id).html(data);
    });
   
}



JS;
$this->registerJs($script_1,$this::POS_HEAD);


?>