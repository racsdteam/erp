<?php
use yii\helpers\Url;

use yii\helpers\Html;
use common\models\ErpMemoSupportingDoc;
use common\models\ErpTravelRequestAttachement;
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
</style>


<div class="card">
                        <div class="card-header">
                           
                            <h6 class="fa"> <i class="fas fa-suitcase"></i> New Travel Request </h6>
                     
                        </div>
                        
                        
                        <div class="card-block p-0">
  

<?php

    $q1=" SELECT f.* FROM erp_travel_request_approval_flow as f  where f.tr_id='".$model->id."' and status='pending' and is_copy!=1 order by f.timestamp desc ";
    $com1= Yii::$app->db->createCommand($q1);
    $row1 = $com1->queryOne();
    
    //------------------display page--------------------------------------- 
     $page=0;

?>
     
   <div id="smartwizard">
            <ul class="nav">
                <li><a class="nav-link" href="#step-1" data-content-url="<?= Url::to(['erp-memo/view-memo-pdf','id'=>$model->memo])?>">Page 1<br /><small>Approved Memo</small></a></li>
                
                
                 <li><a class="nav-link" href="#step-2" data-content-url="<?= Url::to(['erp-memo-supporting-doc/get-support-docs-by-memo','id'=>$model->memo]) ?>" >Page 2<br /><small>Memo Supporting Doc(s)</small></a></li>
                
                
                 
                <li><a class="nav-link" href="#step-3" data-content-url="<?= Url::to(['erp-travel-clearance/tcs-view-pdf','tr_id'=>$model->id])?>">Page 3<br /><small>Travel Clearance(s)</small></a></li>
               
              
                
                <li><a class="nav-link" href="#step-4" data-content-url="<?= Url::to(['erp-travel-request-attachement/view-pdf1','tr_id'=>$model->id])?>">Page 4<br /><small>Tr.Request Supporting Doc(s)</small></a></li>
                
               
                
                 <?php 
       
               if($row1['approver']==Yii::$app->user->identity->user_id || $model->status=='drafting')
                {
                ?>
                 <li><a class="nav-link" href="#step-5" data-content-url="<?=Url::to(['erp-travel-request-approval/work-flow','tr_id'=>$model->id]) ?>">Page 5<br /><small>Work Flow Action(s)</small></a></li>
              <?php } ?>  
            </ul>

            <div class="tab-content">
                
                <div id="step-1"  class="tab-pane" role="tabpanel">
                <h3 class="border-bottom border-gray pb-2">Page 1 Content</h3>
                </div>
                
                <div id="step-2"  class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Page 2 Content</h3>
                
                </div>
                
                <div id="step-3"  class="tab-pane" role="tabpanel">
                   
                  <h3 class="border-bottom border-gray pb-2">Page 3 Content</h3>   
                </div>
                
                <div id="step-4"  class="tab-pane" role="tabpanel">
                  <h3 class="border-bottom border-gray pb-2">Page 4 Content</h3>  
                </div>
                
                <div id="step-5"  class="tab-pane" role="tabpanel">
                  <h3 class="border-bottom border-gray pb-2">Page 5 Content</h3>  
                </div>
                
            </div>
        </div>
    </div>
        </div>
       


             
          <?php
$url=Url::to(['erp-persons-in-position/populate-names']); 
$contentURL=Url::to(['erp-travel-request/fetch-tab','tr_id'=>$model->id]); 
$uploadURL=Url::to(['erp-travel-request-attachement/create','tr_id'=>$model->id,'context'=>'wizard']); 
$script = <<< JS

var el;
 $(document).ready(function(){

            // Step show event
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
               //alert("You are on step "+stepNumber+" now");
               if(stepPosition === 'first'){
                   $("#prev-btn").addClass('disabled');
               }else if(stepPosition === 'final'){
                   $("#next-btn").addClass('disabled');
               }else{
                   $("#prev-btn").removeClass('disabled');
                   $("#next-btn").removeClass('disabled');
                   
               }
               
              //------------------------show attachment button-------------------------------
              if(stepNumber==2){
                  
                 $('.upload').show(); 
              }else{
                  
                $('.upload').css("display","none") ; 
              }
               
            });

            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text('Finish')
                                             .addClass('btn btn-info')
                                             .on('click', function(){ alert('Finish Clicked'); });
                                             
           var btnUpload = $('<button></button>').html('<i class="fa fa-plus-circle"></i> Add Attachement')
                                             .addClass('btn btn-info  upload')
                                             .on('click', function(e){ 
              /* $.ajax({ url: '{$uploadURL}',
              cache: false,
              success: function(data){
               $('#step-4').html(data);

               //console.log(data);
              },
              dataType: "html"
                });*/
                      e.preventDefault();

        e.stopPropagation();
        var url='{$uploadURL}';
        $.get(url)

        .done(function (data) {

            $('#step-4').html(data);
            
          

        })

        .fail(function () {

            console.log("Ajax fail: ");

        });               
                                                 
                                                 
                                             });
                                             
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });


     
              
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
                                  
        
        //-----------------------initializing----------------------------------------------------------------------------------//
        
            // initSmartWizard(0,[btnUpload],theme='arrows',animation='none')
            smartWizardConfig.init(0,[btnUpload],theme='arrows',animation='none');


        });
JS;
$this->registerJs($script,$this::POS_END);
?>