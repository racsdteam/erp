<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;
use common\models\User;
use yii\widgets\LinkPager;
use yii\base\View;

use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this);
?>

<style>

.sw-theme-arrows > ul.step-anchor > li > a, .sw-theme-arrows > ul.step-anchor > li > a:hover{
    
   color:#bbb !important; 
    
}
  .btn-info:not(:disabled):not(.disabled).active, .btn-info:not(:disabled):not(.disabled):active, .show>.btn-info.dropdown-toggle {
    color: #fff;
    background-color: #117a8b !important;
    border-color: #10707f !important;
} 

.upload{
    
    display:none;
}

div.form-group label{
    
    color:black;
    font-size:16px;
}
.sw-theme-arrows .step-content {
    padding: 0 0px;
    border: 0px solid #D4D4D4;
    background-color: #FFF;
    text-align: left;
}
</style>

  
   <div  id="smartwizard">
            <ul>
                

                <li><a href="#step-1">Page 1<br /><small>Document View</small></a></li>
              
               
                <li><a href="#step-2">Page 2<br /><small>Work Flow Action(s)</small></a></li>
                
                
             
            </ul>

            <div>
                
                
                
                <div id="step-1" class="">
                 

                </div>
                <div id="step-2" class="">
                 

                </div>
              
            </div>
        </div>
   
 

             
          <?php
$url=Url::to(['erp-persons-in-position/populate-names']); 
$contentURL=Url::to(['erp-document/fetch-tab3','id'=>$model->id]); 
$uploadURL=Url::to(['erp-document-attachment/create','id'=>$model->id,'context'=>'wizard']);


$script = <<< JS


 $(document).ready(function(){

  //$('[data-toggle="push-menu"]').pushMenu('toggle');            

            // Step show event
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
               //alert("You are on step "+stepNumber+" now");
               $('#smartwizard').smartWizard('showMessage','Hello! World');
               if(stepPosition === 'first'){
                   $("#prev-btn").addClass('disabled');
               }else if(stepPosition === 'final'){
                   $("#next-btn").addClass('disabled');
               }else{
                   $("#prev-btn").removeClass('disabled');
                   $("#next-btn").removeClass('disabled');
                   
               }
               
              //------------------------show attachment button-------------------------------
              if(stepNumber==0){
                  
                 $('.upload').show(); 
              }else{
                  
                $('.upload').css("display","none") ; 
              }
               
            });

            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text('Finish')
                                             .addClass('btn btn-info')
                                             .on('click', function(){ $('#smartwizard').smartWizard("next1");});
                                             
           var btnUpload = $('<button></button>').html('<i class="fa fa-plus-circle"></i> Add Attachement')
                                             .addClass('btn btn-info  upload')
                                             .on('click', function(e){ 
            
                      e.preventDefault();
                       //$("#smartwizard").smartWizard("goToStep",1);

        e.stopPropagation();
        var url='{$uploadURL}';
        $.get(url)

        .done(function (data) {

            $('#step-1').html(data);
            
          

        })

        .fail(function () {

            console.log("Ajax fail: ");

        });               
                                                 
                                                 
                                             });
                                             
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });


            // Smart Wizard
            $('#smartwizard').smartWizard({
                    selected: 0,
                    theme: 'arrows',
                    transitionEffect:'fade',
                    showStepURLhash:false,
                   //hiddenSteps:[3],
                    toolbarSettings: {toolbarPosition: 'both',
                                      toolbarButtonPosition: 'end',
                                      toolbarExtraButtons: [btnUpload]
                                    },
                                   contentURL:'{$contentURL}',
                                   ajaxType: 'POST',
                                     contentCache:false,
            });
 


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
                $('#smartwizard').smartWizard("next");
                return true;
            });

            $("#theme_selector").on("change", function() {
                // Change theme
                $('#smartwizard').smartWizard("theme", $(this).val());
                return true;
            });

            // Set selected theme on page refresh
            $("#theme_selector").change();
        });
JS;
$this->registerJs($script,$this::POS_END);
?>