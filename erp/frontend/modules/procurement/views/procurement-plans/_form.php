<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;


/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponents */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    
 
/*--------------------------spacing radio options------------------------------------------------*/
  div.emp-type label, div.pay-type label,div.med-scheme label {  
      display: inline-block; margin-right: 30px;
      
      
  }
  
  .invalid-feedback {
  display: block;
}
</style>


                 <div class="card card-default text-dark">
        
                  <div class="card-header ">
            <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Procurement Plan Details</h3>
        </div>    
               
           <div class="card-body">
      
  
      <?php
      
        if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
  
  
    /* if($model->isNewRecord){
        $model->pay_period_month=date("m", strtotime('m'));
        $model->pay_period_year= date("Y"); 
        
        $model->pay_period_start=date('01/m/Y',strtotime('this month'));
        $model->pay_period_end=date( 't/m/Y' );
     }else{
          $model->pay_period_start=date('d/m/Y', strtotime($model->pay_period_start));
          $model->pay_period_end=date('d/m/Y', strtotime($model->pay_period_end));
         
       }
    */
     
  //  $model->run_type="REG";
     
     
     
   
   
   ?>
     
      
 <?php $form = ActiveForm::begin(['id'=>'plan-create-form']); ?>
 
 



 <div class="row">
     
      <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
           
          <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label("Name") ?>   
              
          </div> 
     
     
        
         <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6">
           
           <?= $form->field($model, 'fiscal_year')->dropDownList(Yii::$app->procUtil->yearsList(), ['prompt'=>'Select fiscal Year',
               'id'=>'pay-year-id','class'=>['form-control m-select2 ']])->label("Fiscal Year") ?> 
              
          </div> 
          
        
          
          
     </div>                  
  
 			
 
 
    
     <div class="form-group">
        <?= Html::submitButton($model->isNewRecord?'Save':'Update', ['class' =>$model->isNewRecord?'btn btn-info':'btn btn-success']) ?>
    </div>    
            
      <?php ActiveForm::end(); ?>      
            
            </div>
            
  
    
   
        
   

    


</div>





<?php

       
$urlToAdjust=Url::to(['payrolls/adjust']);
$urlToPrevPays=Url::to(['payrolls/prev-payrolls']);
$urlToPayGroups=Url::to(['pay-groups/find-by-run-type']);
$script = <<< JS

 $(document).ready(function(){

 $("div#divCopy").hide().find('input:text,input:hidden, select').prop("disabled",true);  
 $("div.run-opt").hide().find('input:text,input:hidden, select').prop("disabled",true);

 //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
     $(".m-select").select2({width:'80%',theme: 'bootstrap4'});
         
     
     $('.date').bootstrapMaterialDatePicker
			({
			    format: 'DD/MM/YYYY',
				time: false,
				clearButton: true
			});

			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});


$('input:radio[name="Payrolls[run_type]"]').on('change', function(event) {
 
  if(this.value!=='') {
    
 $('.run-opt').not('.'+ this.value).hide().find('input:text,input:hidden, select').prop("disabled",true);
 $('.'+ this.value).show().find('input:text,input:hidden, select').prop("disabled",false);
 findGroupsByRunType(this.value);
  }
 
        });
        
 $('#checkCopy').on('change', function(event) {
   
   if ($(this).is(":checked")) {
                $("#divCopy").show().find('input:text,input:hidden, select').prop("disabled",false);
                
                  $.ajax({
  url: "{$urlToPrevPays}",
  type: "get", //send it through get method
  data: { 
    pay_group: $("#pay-group-id").val(), 
   
  },
  success: function(data) {
   
   $( "select#prev" ).html( data );
   var defaultOption = new Option("Select Payroll To Copy","");
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
  

$("#pay-create-form").on('beforeSubmit',function(event) {
             Swal.showLoading(); 
              event.preventDefault(); // stopping submitting
             var formData = $(this).serializeArray();
             var url = $(this).attr('action');
            
            $.ajax({
                 url: url , //Server script to process data
                 type: 'POST',
                   dataType: 'json',
                 // Form data
               data: formData,
              
             
                 beforeSend: function( xhr ) {
     var swal=Swal.fire({
                title: 'Please Wait !',
                html: 'Payroll generating...',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });  
  }
            })
            .done(function(res) {
                   console.log(res);
     swal.close();
   
     if(res.success){
         
         toastr.success(res.data.msg)  
         
        window.location.href="{$urlToAdjust}?id="+res.data.id;
            
        }else{
           
             $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Error',
        subtitle: 'Unable to generate payroll !',
         body: res.data.msg
      })
            
          }
            })
            .fail(function(jqXHR, textStatus, error) {
              swal.close();
  });
      return false;  
        });
        
          
function  findGroupsByRunType(val){

                $.ajax({
  url: "{$urlToPayGroups}",
  type: "get", //send it through get method
  data: { 
   run_type: val, 
   
  },
  success: function(data) {
   
   $( "select#pay-group-id" ).html( data );
   var defaultOption = new Option("Select Payroll Run Group","");
   defaultOption.selected = true;    
   $( "select#pay-group-id" ).prepend(defaultOption);
  },
  error: function(xhr) {
    console.log(xhr);
  }
});
                
            
            
 

  }
   
});

JS;
$this->registerJs($script);




$script2 = <<< JS


//------check value validation
function isCopyOptionChecked (attribute, value) {

return $('input:checkbox[name="DynamicModel[copy]"]').is(':checked');
	};
  
//------check value validation
function isSupplOptionChecked (attribute, value) {

return $(attribute.container).is(':visible') && $("input[name='Payrolls[run_type]']:checked").val()=='SUP'; 

	};
  
JS;
$this->registerJs($script2,$this::POS_HEAD);
?>


