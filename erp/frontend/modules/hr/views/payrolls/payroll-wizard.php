<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\modules\hr\models\PayItemCategories;
use frontend\modules\hr\models\PayItems;
use frontend\modules\hr\models\Employees;
use yii\bootstrap4\ActiveForm;
use frontend\modules\hr\models\PayGroups;
use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this);

use kartik\depdrop\DepDrop;
use frontend\modules\hr\models\EmpAdditionalPay;
//-------------pop up-----------------------------
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponents */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
 $name=$model->name;
 $period_start=date('d/m/Y', strtotime($model->pay_period_start));
 $period_end=date('d/m/Y', strtotime($model->pay_period_end));


?>

<style>
ul.dtr-details{
    width:100%;
}

td.details-control {
    background: url('../../img/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('../../img/details_close.png') no-repeat center center;
}

/*
table.dataTable td.details-control:before {
    height: 14px;
    width: 14px;
    display: block;
    position: absolute;
    color: white;
    border: 2px solid white;
    border-radius: 14px;
    box-shadow: 0 0 3px #444;
    box-sizing: content-box;
    text-align: center;
    text-indent: 0 !important;
    font-family: 'Courier New', Courier, monospace;
    line-height: 14px;
    content: '+';
    background-color: #0275d8;
    cursor: pointer;
}*/

/*table.dataTable tr.shown td.details-control:before {
    height: 14px;
    width: 14px;
    display: block;
    position: absolute;
    color: white;
    border: 2px solid white;
    border-radius: 14px;
    box-shadow: 0 0 3px #444;
    box-sizing: content-box;
    text-align: center;
    text-indent: 0 !important;
    font-family: 'Courier New', Courier, monospace;
    line-height: 14px;
    content: '-';
    background-color: #D33333;
    cursor: pointer;
}*/

</style>



                 <div class="card card-default text-dark">
                     
                     
        <div class="card-header">
                <h3 class="card-title"><i class="fas fa-coins"></i> <?php echo $name ?></h3>

                <div class="card-tools">
                  <h6>Pay Period <?php echo $period_start.'-'.$period_end ?></h6>
                  
                 
                </div>
              </div>
                      
               
           <div class="card-body">
               
               
      
      <?php
  

if(Yii::$app->session->hasFlash('error')){
              
   Yii::$app->alert->showError(Yii::$app->session->getFlash('error'))  ;         
           
   
          }
       if (Yii::$app->session->hasFlash('success')){
           
     Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'))  ; 
       }   
      
          
      
      ?>
   
  
    
      <div id="smartwizard">
            
             
           
            <ul class="nav">
                 <li><a class="nav-link" data-content-url="<?=Url::to(['payrolls/adjust-tab-ajax','id'=>$model->id]) ?>"  href="#step-1">
                     <strong><i class="fas fa-exchange-alt"></i> Adjust Payroll</strong>
                     </a></li>
                     
              <li><a class="nav-link" data-content-url="<?=Url::to(['payrolls/preview-tab-ajax','id'=>$model->id]) ?>"  href="#step-2">
                    <strong><i class="fas fa-coins"></i> Payroll Run Details</strong></a></li>
               
               
            </ul>

            <div class="tab-content">
                
              
                
                <div id="step-1" class="tab-pane" role="tabpanel">
                 
       
               
                  
                  
                
                
                </div>
   
 
                 
                    <div id="step-2" class="tab-pane" role="tabpanel">
               
                 </div>
              
              
  
</div><!--end div contnt ---->

              
 

</div><!--end div wizard ---->

</div>
</div>




<?php


$actionText=!empty($model->paySlips)?'Re-process Payroll':'Process Payroll';
$actionLabel=!empty($model->paySlips)?'Yes,Re-Pprocess it!':'Yes,Process it!';

$script = <<< JS

 $(document).ready(function(){
     
     
 $(".next-btn").on("click", function() {
                // Navigate previous
                $('#smartwizard').smartWizard("next");
                return true;
            });

 $(".prev-btn").on("click", function() {
                // Navigate previous
                $('#smartwizard').smartWizard("prev");
                return true;
            });

const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

 // Step show event
              $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
              return true;  
            });
            
       
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
                
                $(".prev-btn").removeClass('disabled');
                $(".next-btn").removeClass('disabled');
                $('.process-payroll').css('display','block');
                if(stepPosition === 'first') {
                    $(".prev-btn").addClass('disabled');
                } else if(stepPosition === 'last') {
                    $(".next-btn").addClass('disabled');
                    $('.process-payroll').css('display','none');
                } else {
                    $(".prev-btn").removeClass('disabled');
                    $(".next-btn").removeClass('disabled');
                }
          
             
               
            });
            
          
            
            // Toolbar extra buttons
             var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });
                                             
              var btnPrevious= $('<button></button>').text('Previous')
                                             .addClass('btn btn-primary prev-btn')
                                             .on('click', function(){ $('#smartwizard').smartWizard("prev");
                return true; });
                                             
             var btnNext= $('<button></button>').text('Next')
                                             .addClass('btn btn-primary next-btn')
                                             .on('click', function(){ 
                                                 
                                                
                      $('#smartwizard').smartWizard("next");
                         return true; 
                                                
                    }); 
         $("#smartwizard").on("stepContent", function(e, anchorObject, stepIndex, stepDirection) {
              
                var ajaxURL    = anchorObject.data('content-url');
               
                // Return a promise object
                return new Promise((resolve, reject) => {

                  // Ajax call to fetch your content
                  $.ajax({
                      method  : "GET",
                      url     : ajaxURL,
                      beforeSend: function( xhr ) {
                          // Show the loader
                          $('#smartwizard').smartWizard("loader", "show");
                      }
                  }).done(function(resp ) {
                      // console.log(res);


                      // Resolve the Promise with the tab content
                      resolve(resp);

                      // Hide the loader
                      $('#smartwizard').smartWizard("loader", "hide");
                  }).fail(function(err) {

                      // Reject the Promise with error message to show as tab content
                      reject( "An error loading the resource" );

                      // Hide the loader
                      $('#smartwizard').smartWizard("loader", "hide");
                  });

                });
            }); 
                                             
            smartWizardConfig.init(0,[],theme='dots',animation='none',showPrevious=true,showNext=true)

     
  
    $('#process-form').on('beforeSubmit', function(event) {
    

     
     var \$form = $(this);
    var formData = new FormData(\$form [0]);// to be able to send file
  
   
   Swal.fire({
  title: 'Are you sure?',
  text: '{$actionText}',
  footer: '<a class="btn-preview" href="#"> <i class="fas fa-share"></i> Skip To Preview </a>',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText:'{$actionLabel}',
  onBeforeOpen: () => {
    const prev = document.querySelector('.btn-preview')
      prev.addEventListener('click', (e) => {
         e.preventDefault();
           swal.close();
          $('#smartwizard').smartWizard("next");   
     })
  },
 
}).then((result) => {
  if (result.value) {
  

 $.ajax({
      
        url: \$form.attr("action"),  //Server script to process data
        type: 'POST',

        // Form data
        data: formData,

       beforeSend: function(){
           
        var swal=Swal.fire({
                title: 'Please Wait !',
                html: 'Payroll Processing...',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });   
           
           
       }, // its a function which you have to define

        success: function(response) {
        swal.close();
        console.log(response);
        var res=JSON.parse(response)[0] ;
        
        if(res.code==1){
         toastr.success(res.msg)  
          $('#smartwizard').smartWizard("next");  
            
        }else{
            
             $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Error',
        subtitle: 'Payroll Processing failed',
        body: res.msg
      })
            
          }
        
           
   
       
        },

        error: function(){
            swal.close();
            alert('ERROR at PHP side!!');
        },


        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false,
       
    });



   
  }
})
  
return false;//prevent the modal from exiting
 
    
});
    
});



JS;
$this->registerJs($script);

?>


