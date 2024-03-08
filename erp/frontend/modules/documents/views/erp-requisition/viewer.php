<?php
use yii\helpers\Url;

use yii\helpers\Html;
use common\models\ErpMemo;

use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this);

?>

<style>


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

.add-assets-code{
    
float:left !important;

}

</style>


<div class="card">
                        <div class="card-header">
                           
                            <h6 class="fa"> <i class="fab fa-opencart"></i>  New Purchase Requisition </h6>
                     
                        </div>
                        
                        
                        <div class="card-body">
  
<?php 

$model1=ErpMemo::find()->where(['id'=>$model->reference_memo])->One();
 $q1=" SELECT f.* FROM erp_requisition_approval_flow as f  where f.pr_id='".$model->id."'  and status='pending' and is_copy=0 order by f.timestamp desc ";
     $com1= Yii::$app->db->createCommand($q1);
     $row1 = $com1->queryOne();

?>

     
   <div id="smartwizard">
            <ul class="nav">
                <li><a class="nav-link" data-page=1 href="#step-1"  data-content-url="<?= Url::to(['erp-memo/view-memo-pdf','id'=>$model1->id])?>">Page 1<br />
                <small>Memo For Requisition</small></a></li>
                <li><a class="nav-link" data-page=2 href="#step-2" data-content-url="<?= Url::to(['erp-requisition/fetch-tab','pr_id'=>$model->id,'step_number'=>1,'stepcontent'=>2])?>" >Page 2<br />
                <small>Requisition Form</small></a></li>
                <li><a class="nav-link" data-page=3 href="#step-3" data-content-url="<?= Url::to(['erp-requisition-attachement/get-support-docs-by-req','id'=>$model->id,'stepcontent'=>3])?>">Page 3<br />
                <small>Attachement(s)</small></a></li>
                  <?php 
      
               if($row1['approver']==Yii::$app->user->identity->user_id || ($model1->status=='drafting' || $model->approve_status=='drafting'))
                {
                ?>
                 <li><a class="nav-link" data-page=4 href="#step-4" data-content-url="<?= Url::to(['erp-requisition-approval/work-flow','pr_id'=>$model->id]) ?>">Page 4 <br /><small>Work Flow Actions</small></a></li>
            <?php } ?>
            </ul>
<div  class="card-tools ml-3 mt-1 p-1 ">
  
    
    
              
                 
                 
                 
                </div>
            <div class="tab-content" >
                <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                <h3 class="border-bottom border-gray pb-2">Page 1 Content</h3>
                </div>
                <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                    <h3 class="border-bottom border-gray pb-2">Page 2 Content</h3>
                
                </div>
                
                <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                   
                  <h3 class="border-bottom border-gray pb-2">Page 3 Content</h3>   
                </div>
                <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                  <h3 class="border-bottom border-gray pb-2">Page 4 Content</h3>  
                </div>
                
                
                
            </div>
        </div>
    </div>
        </div>


             
          <?php
$url=Url::to(['erp-persons-in-position/populate-names']); 
$contentURL=Url::to(['erp-requisition/fetch-tab','pr_id'=>$model->id]); 
$uploadURL=Url::to(['erp-requisition-attachement/create','pr_id'=>$model->id,'context'=>'wizard']);
$assetsCodeURL=Url::to(['erp-requisition/assets-code','id'=>$model->id]); 
$script = <<< JS

var el;
 $(document).ready(function(){

              

            // Step show event
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
                var page   = anchorObject.data('page');
             
               if(stepPosition === 'first'){
                   $("#prev-btn").addClass('disabled');
                   //-------------------custom prev button--------------------
                    $(".prev-btn").addClass('disabled');
               }else if(stepPosition === 'last'){
                   $("#next-btn").addClass('disabled');
                   //--------custom next button-----------------------
                    $(".next-btn").addClass('disabled');
               }else{
                   $("#prev-btn").removeClass('disabled');
             //---------------custom previous button------------------- 
                   $(".prev-btn").removeClass('disabled');
                   
                   $("#next-btn").removeClass('disabled');
                   
                    //---------------custom previous button------------------- 
                   $(".next-btn").removeClass('disabled');
                   
               }
               
              //------------------------show attachment button-------------------------------
              if(page==3){
                  
                 $('.upload').show(); 
              }else{
                  
                $('.upload').css("display","none") ; 
              }
               
            });

            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text('Finish')
                                             .addClass('btn btn-info')
                                             .on('click', function(){ $('#smartwizard').smartWizard("next1");});
           var btnAssetsCode = $('<button></button>').html('<i class="fa fa-plus-circle"></i> Assets code')
                                             .addClass('btn  add-assets-code')
                                             .on('click', function(){ 
                    
                                                 
                                                 window.location.href='{$assetsCodeURL}'
                                                 
                                             });
                                             
           var btnUpload = $('<button></button>').html('<i class="fa fa-plus-circle"></i> Add Attachement')
                                             .addClass('btn btn-info  upload')
                                             .on('click', function(e){ 
            
                      e.preventDefault();
                       

        e.stopPropagation();
        var url='{$uploadURL}';
        $.get(url)

        .done(function (data) {

            $('#step-3').html(data);
            
          

        })

        .fail(function () {

            console.log("Ajax fail: ");

        });               
                                                 
                                                 
                                             });
                                             
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });
                                             
             var btnPrevious= $('<button></button>').text('Previous')
                                             .addClass('btn btn-primary prev-btn')
                                             .on('click', function(){ $('#smartwizard').smartWizard("prev");
                return true; });
                                             
             var btnNext= $('<button></button>').text('Next')
                                             .addClass('btn btn-primary next-btn')
                                             .on('click', function(){ $('#smartwizard').smartWizard("next");
                return true; });                                                                  

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
                                  
        
        //-----------------------initializing----------------------------------------------------------------------------------//
        
            // initSmartWizard(0,[btnUpload],theme='arrows',animation='none')
            smartWizardConfig.init(1,[btnUpload,btnAssetsCode,btnPrevious,btnNext],theme='dark',animation='none',showPrevious=false,showNext=false);

         

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