<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use frontend\modules\hr\models\PayTemplates;
use frontend\modules\hr\models\PayTemplateItems;
use frontend\modules\hr\models\PayItems;
use frontend\modules\hr\models\PayItemCategories;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayTemplateItems */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="card card-default text-dark card-wrapper">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-layer-group"></i> Pay Template Item</h3>
                       </div>
               
           <div class="card-body">
               
        <?php 
         
         $payTempList=ArrayHelper::map(PayTemplates::find()->all(), 'id','name');
         $itemCategories=ArrayHelper::map(PayItemCategories::find()->all(), 'code','name');
         
         $earningsType=ArrayHelper::map(PayItems::find()->earnings()->all(),'code', 'name');
         $deductionTypes=ArrayHelper::map(PayItems::find()->deductions()->all(),'code', 'name');
         $totalTypes=ArrayHelper::map(PayItems::find()->totals()->all(),'code', 'name');
         $itemsList=ArrayHelper::map(PayItems::find()->all(), 'id','name');
       
     
        ?>       
               <?php $form = ActiveForm::begin(['id'=>'item-form']); ?>
    
 
     
     <?= $form->field($model, 'tmpl')->dropDownList( $payTempList, ['disabled' =>true,'class'=>['form-control m-select2  ']]) ?>
     <?= $form->field($model, 'item')->dropDownList( $itemsList, ['disabled' =>false,'class'=>['form-control m-select2  ']])->label('Pay Item') ?>
     <?= $form->field($model, 'code')->dropDownList( $itemsList, ['disabled' =>false,'class'=>['form-control m-select2  ']])->label('Code') ?>
     <?= $form->field($model, 'category')->dropDownList( $itemCategories, ['disabled' =>false,'class'=>['form-control m-select2 ']])->label('Pay Item Category') ?>

    <?= $form->field($model, 'calc_type')->dropDownList([ 'formula' => 'Formula', 'fixed' => 'Fixed Amount', 'open' => 'At Pay Time', '' => '',
    ], ['prompt' => '', 'class'=>['form-control m-select2 calc-type'],'id'=>'calc-type']) ?>
    
    <div class="input formula">

    <?= $form->field($model, 'formula',['template' => '
                       {label}
                       <div class="input-group">
                          {input}
                       <div class="input-group-append">
                               
                               <a data-toggle="modal" href="#modal-formula" class="btn btn-outline-success  open-AddFormulaDialog ">
           <i class="fas fa-angle-down"></i>
          </a>
                               
                                </div>
                     
                          
                           
                           
                       </div>{error}{hint}
               '])->textInput(['maxlength' => true,'class'=>['form-control input-formula'],'placeholder'=>'formula...'])?>
               
               </div>
               
               <div class="input fixed">

    <?= $form->field($model, 'value')->textInput(['maxlength' => true,'class'=>['form-control input-amount'],'placeholder'=>'amount...']) ?>
    
    </div>
   
   <?= $form->field($model, 'display_order')->textInput(['maxlength' => true,'class'=>['form-control '],'placeholder'=>'display order...']) ?>		
   
     <?= $form->field($model, 'active')->checkbox(array('label'=>''))
			->label('Active'); ?> 

  <?= $form->field($model, 'visible')->checkbox(array('label'=>''))
			->label('Visible'); ?> 
			
 <?= $form->field($model, 'editable')->checkbox(array('label'=>''))
			->label('Editable'); ?> 	

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
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
 

 
<span class="info-container">     <span class="info">Standard Earnings</span>    
<input class="form-control filter mb-1" type="text" placeholder="Filter">   
<?php echo Html::listBox('ed', '',   $earningsType, $htmlOptions);  ?>


</div>   
  <div class="box1 col-md-6">   
 
<span class="info-container">     <span class="info">Standard Deductions</span>    
<input class="form-control filter mb-1" type="text" placeholder="Filter">   
<?php echo Html::listBox('ed', '',  $deductionTypes, $htmlOptions);  ?>


</div>  

<div class="box1 col-md-2">   
 
<span class="info-container">     <span class="info">Fixed Items</span>    
<input class="form-control filter mb-1" type="text" placeholder="Filter">   
<?php echo Html::listBox('global', '',    $totalTypes, $htmlOptions);  ?>


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

$script = <<< JS

$(document).ready(function(){



     //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
     $(".m-select").select2({width:'80%',theme: 'bootstrap4'});
     resetInput($('.calc-type').val());
    console.log($('.calc-type').val());

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

$("#calc-type").on('change.yii',function(){
      
  var inputAmount = $(".input-amount"); 
  var inputFormula = $(".input-formula");

 $(".input").not("." + $(this).val()).hide();
 $(".input").not("." + $(this).val()).find("input").val('');
 $("." + $(this).val()).show(); 
});

function resetInput(selected){
    
  $(".input").not("." + selected).hide();
  $(".input").not("." + selected).find("input").val('');
  $("." + selected).show();  
    
}

function isMathExpression (str) {
  try {
    Complex.compile(str);
  } catch (error) {
    return false;
  }
  
  return true;
}
     
});

 
 $('#item-form').on('beforeSubmit', function (e) {
 var c=$('.calc-type').val();
 
 if(c=='fixed' && $('.input-amount').val()==''){
  
     return false;
 }
 
  if(c=='formula' && $('.input-formula').val()==''){
  
     return false;
 }
 
    return true;
});


JS;
$this->registerJs($script);


?>
