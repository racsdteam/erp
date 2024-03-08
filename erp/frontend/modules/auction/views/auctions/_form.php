<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\file\FileInput;
use frontend\modules\auction\models\LotsCategories;
use frontend\modules\auction\models\LotsLocations;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this); 
/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\Auctions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title">Add New Auction</h3>
                       </div>
               
           <div class="card-body">
               <?php if (Yii::$app->session->hasFlash('failure')): ?>
  
   <div class="alert alert-danger alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
   <?php echo  Yii::$app->session->getFlash('failure');?>
  </div>
    <?php endif; ?>
               

    <?php $form = ActiveForm::begin([
                               
                                'id'=>'dynamic-form', 
                               
                               'enableClientValidation'=>false,
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                              
                               ]); ?>
    
     <div id="smartwizard">
            
            
            <ul class="nav">
                
                 <li><a class="nav-link" href="#step-1">Page 1<br /><small>Add Auction Details </small></a></li>
                <li><a class="nav-link" href="#step-2">Page 2<br /><small>Add Event Details</small></a></li>
                 
               <li><a class="nav-link" href="#step-3">Page 3<br /><small>Add Auction Lots</small></a></li>
                 
               
                
                
                
               
            </ul>

            <div class="tab-content">
                
              
                
                <div id="step-1" class="tab-pane" role="tabpanel">
                      <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php //$form->field($model, 'status')->dropDownList([ 'closed' => 'Closed', 'active' => 'Active', 'draft' => 'Draft', '' => '', ], ['prompt' => '---select status---']) ?>


                    </div>
                    
                      <div id="step-2" class="tab-pane" role="tabpanel">
                          
                       
  

        
        
        <label>Auction Online Schedule</label>
        
        
        <div class="row">
           
           <div class="col-xs-12 col-md-6 col-lg-6">
                <?= $form->field($model, 'online_start_time', ['template' => '
                         {label} 
                       <div class="input-group col-sm-12">
                        <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                
                                </div>
                     
                         {input}
                         
                           
                       </div>{error}{hint}
               '])->textInput(['maxlength' => false,'class'=>['form-control datetime'],'placeholder'=>'Online Auction Start date and time...'])->label(false)?> 
               
           </div> 
           
             <div class="col-xs-12 col-md-6 col-lg-6">
               
                  <?= $form->field($model, 'online_end_time', ['template' => '
                         {label} 
                       <div class="input-group col-sm-12">
                        <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                
                                </div>
                     
                         {input}
                         
                           
                       </div>{error}{hint}
               '])->textInput(['maxlength' => false,'class'=>['form-control datetime'],'placeholder'=>' Online Auction End date and time...'])->label(false)?>   
               
           </div> 
            
        </div>
                  
                   
                    
                        
                          
                      </div>
                    
                     <div id="step-3" class="tab-pane" role="tabpanel">
                      <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper2', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items2', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 500, // the maximum times, an element can be added (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsAuctionLots[0],
        'formId' => 'dynamic-form',
        'formFields' => [
           'lot',
            'description',
             'quantity',
            'reserve_price',
            'location',
            'comment'
      
           
        ],
    ]); ?>
   
    
    <div class="table-responsive">
     <table id="lots-table" style="width:100%" cellspacing="10" cellpadding="10" class="table-bordered ">
        <thead>
            <tr>
               
    <th  style="color:#2196f3;font-weight:bold;" colspan="8" >
        
   <h4 style="display:inline;" ><i class="fas fa-cubes"></i> Add Auction Lots</h4>
    
    </th>
    
   
                
            </tr>
            <tr>
                <th  class="text-center" style="width:12%">Lot No#</th>
                <th  class="text-center" style="width:25%">Description</th>
                 <th  class="text-center">Quantity</th>
                  <th  class="text-center" style="width:20%">Reserve Price</th>
                <th  class="text-center" style="width:25%">Location</th>
                 <th  class="text-center"  style="width:15%">Comment / Status</th>
                 
                  
                    
                <th>
                 <i class="fas fa-cog"></i>
                </th>
            </tr>
        </thead>
        <tbody class="container-items2">
       <?php foreach ($modelsAuctionLots as $i => $modelAuctionlot): ?>
            <tr class="item">
                
                
                <td>
                    
                     <?php
                            // necessary for update action.
                            if (! $modelAuctionlot->isNewRecord) {
                                echo Html::activeHiddenInput($modelAuctionlot, "[{$i}]id");
                            }
                        ?> 
                 
                 <?=   $form->field($modelAuctionlot, "[{$i}]lot")->textInput(['class'=>['form-control'],'placeholder'=>'Lot No#...'])->label(false)  ?>
                
                 
                    
                  
                </td>
                <td >
                 <?=  
                 $form->field($modelAuctionlot, "[{$i}]description")->textarea(['rows' => '3','placeholder'=>'Description...'])->label(false) 
                              
                 
                 ?> 
                </td>
                
                 <td >
                    
                    <?=  
                 $form->field($modelAuctionlot, "[{$i}]quantity")->textInput(['class'=>['form-control'],'placeholder'=>'Qty...'])->label(false) 
                 
                              
                 
                 ?> 
                </td>
                
              
                
                <td>
                   <?=  
                 $form->field($modelAuctionlot, "[{$i}]reserve_price")->textInput(['class'=>['form-control'],'placeholder'=>'Reserve Price...'])->label(false) 
                              
                 
                 ?>  
                    
                </td>
                
                 <td>
                  <?php  
                   $locations=ArrayHelper::map(LotsLocations::find()->all(), 'id', 'location'); 
             ?>
                   
         <?= $form->field($modelAuctionlot, "[{$i}]location")
        ->dropDownList(
            $locations,         
            ['prompt'=>'--Select Location---','class'=>['form-control m-select2']]    // options
        )->label(false)?>
               
                 </td>
                 
                  <td >
                    
              <?=  $form->field($modelAuctionlot, "[{$i}]comment")->textarea(['rows' => '3','placeholder'=>'Comment / Status...'])->label(false) 
                 
                 ?> 
                </td>
              
                <td class="text-center vcenter">
                    <button type="button" class="remove-item btn btn-danger btn-xs bg-red btn-circle"><span style="font-size:16px;" class="fa fa-minus-circle "></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
    <tr>
      
      <td colspan="7"  class="text-right"><button type="button" class="add-item btn btn-success btn-xs bg-green btn-circle"><span style="font-size:16px;" class="fa fa-plus-circle"></span></button></td>
    </tr>
  </tfoot>
    </table>
   </div> 
    
    <?php DynamicFormWidget::end(); ?>
    
    </div>
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
    
    $label="Save";
}else{
    
    $label="Update";
}

$script = <<< JS

 $(function () {
     
     $(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
    $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
});

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
});
  
         $('#lots-table').DataTable({
       paging: false,
	  responsive: true,
      lengthChange: false,
      searching: false,
      ordering: false,
      info: false,
      autoWidth: false
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
   
          $('.datetime').bootstrapMaterialDatePicker(
              { format : 'YYYY-MM-DD  HH:mm' 
                  
              });
              
                //--------------------------------------------------init select2-------------------------------------------------       
          
           $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
           
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
                                             .addClass('btn btn-success submit')
                                             .on('click', function(){ $('#dynamic-form').submit();});
                                             
         
                                             
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger btn-cancel')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });
                                             
          
                                             
                                        smartWizardConfig.init(0,[btnFinish],theme='dots',animation='none')
        
 });
     
   	    

   

JS;
$this->registerJs($script);

?>
