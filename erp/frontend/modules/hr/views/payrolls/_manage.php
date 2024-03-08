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
/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayComponents */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
 $name=$model->name;
 $period_start=date('d/m/Y', strtotime($model->pay_period_start));
 $period_end=date('d/m/Y', strtotime($model->pay_period_end));
 
?>
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  ">

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
              
               $msgbox=Html::tag('div',Html::button('x',
    ['class'=>'close',' data-dismiss'=>'alert','aria-hidden'=>true]).
    Html::tag('h5','<i class="icon fas fa-ban"></i> Alert!',[]).
    Yii::$app->session->getFlash('error'),
    ['class'=>'alert alert-danger alert-dismissible']);
  
    echo $msgbox;
          }
       if (Yii::$app->session->hasFlash('success')){
           
            echo '<script type="text/javascript">';
  echo "Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: '".Yii::$app->session->getFlash('success')."',
                 showConfirmButton: false,
                 timer: 1500
                  })";
  echo '</script>'; 
       }   
      
          
      
      ?>
   
  
    
      <div id="smartwizard">
            
             
           
            <ul class="nav">
                 <li><a class="nav-link" data-content-url="<?=Url::to(['payrolls/employees','id'=>$model->id]) ?>" href="#step-1">
                     <small><i class="fas fa-users"></i> Employees</small></a></li>
                <li><a class="nav-link" data-content-url="<?=Url::to(['payrolls/adjust','id'=>$model->id]) ?>" href="#step-2">
                    <small><i class="fas fa-exchange-alt"></i>  Variable Earnings & Deductions</small></a></li>
                <li><a class="nav-link" data-content-url="<?=Url::to(['payrolls/preview','id'=>$model->id]) ?>"  href="#step-3">
                    <small><i class="far fa-thumbs-up"></i> Review & Confirm</small></a></li>
               
               
            </ul>

            <div class="tab-content">
                
              
                
                <div id="step-1" class="tab-pane" role="tabpanel">
                   
                
                </div>
   
   
   <!-- ---------------------------------------step 2--------------------------------------------------------------------->             
                <div id="step-2" class="tab-pane" role="tabpanel">
               
                 </div>
              
                
                
      <!-------------------------------step 3-------------------------------------------------------------------->             
                <div id="step-3" class="tab-pane" role="tabpanel">
               
                 </div>
                              
    
           
              
             
                
              
                
                
  
</div><!--end div contnt ---->

</div><!--end div wizard ---->



</div>
</div>
</div>
</div>



<?php

$currentStep=0;
if(isset($step) && $step!=null){$currentStep=$step;}
$script = <<< JS

 $(document).ready(function(){

 // Step show event
              $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
       /*         
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
   */
             
            });
            
       
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
                
            
               
               if(stepPosition === 'first'){
                   $("#prev-btn").addClass('disabled');
                    $(".prev-btn").addClass('disabled');
               }else if(stepPosition === 'last'){
                   $("#next-btn").addClass('disabled');
                     $(".next-btn").addClass('disabled');
               }else{
                   $("#prev-btn").removeClass('disabled');
                   $("#next-btn").removeClass('disabled');
                   
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
                                                 
                                                
                      if($('#smartwizard').smartWizard("getStepIndex")===1) {
                          
                       $('#dynamic-form').submit(); 
                      return false; 
                      } else{
                          
                        $('#smartwizard').smartWizard("next");
                         return true; 
                      }
                     
                                                
                    }); 
                                             
             
               $("#smartwizard").on("stepContent", function(e, anchorObject, stepIndex, stepDirection) {
                console.log("content load")
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
            
                                             
            smartWizardConfig.init($currentStep,[],theme='dots',animation='slide-horizonta',showPrevious=false,showNext=false)


            // External Button Events
            $("#reset-btn").on("click", function() {
                // Reset wizard
                $('#smartwizard').smartWizard("reset");
                return true;
            });

           /* $("#prev-btn").on("click", function() {
                // Navigate previous
                $('#smartwizard').smartWizard("prev");
                return true;
            });*/

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

     //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
     $(".m-select").select2({width:'80%',theme: 'bootstrap4'});
     $('.input-amount').number( true);
     
     
     
});

JS;
$this->registerJs($script);

?>


