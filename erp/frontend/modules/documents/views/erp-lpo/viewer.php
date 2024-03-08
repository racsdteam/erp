<?php
use yii\helpers\Url;

use yii\helpers\Html;
use common\models\ErpMemo;
use common\models\ErpLpoRequest;

use common\models\ErpTransmissionSlip;
use common\models\ErpRequisition;
use common\models\ErpTravelRequest;
use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this);

?>

<style>



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
                           
                            <h6 class="fa"> <i class="fa fa-opencart"></i>New Purchase Order </h6>
                     
                        </div>
                        
                        
                        <div class="card-block p-0">
  
                      <?php 
                       
                      
                      if($model->lpo_request_id!=null){
                        
                       $model1=ErpLpoRequest::find()->where(['id'=>$model->lpo_request_id])->One(); 
                    
                      
                      if($model1!=null){
          
           
                        $model3=ErpTransmissionSlip::find()->where(['type'=>'LPO','type_id'=>$model1->id])->one() ; 
                        
                        
                      }
                             
                      }
                   
                     
                   
                  
                    
         $q1=" SELECT f.* FROM erp_lpo_approval_flow as f  where f.lpo='".$model->id."' and status='pending' and is_copy!=1 order by f.timestamp desc ";
     $com1= Yii::$app->db->createCommand($q1);
     $row1 = $com1->queryOne();
                
                         ?>

     
   <div id="smartwizard">
            <ul class="nav">
  <!--  --------- --------------------------------------------------------------------------------------->             
                <?php if($model->type=='PR') : ?>
                
                 <?php 
//--------------------------------------Requition requring LPO----------------------------------------------------
                  $model2=ErpRequisition::find()->where(['id'=>$model1->request_id])->one() ; 
                  
                ?>
                
                 <!--  ------------------------------Requsition document--------------------------------------------------------------->
                <li><a class="nav-link"  href="#step-1" data-content-url="<?= Url::to(['erp-memo/view-memo-pdf','id'=>$model2->reference_memo])?>">Page 1<br /><small>Memo</small></a></li>
                <li><a class="nav-link"  href="#step-2" data-content-url="<?= Url::to(['erp-requisition/view-form-pdf','pr_id'=>$model1->request_id])?>">Page 2<br /><small>PR Form</small></a></li>
                <li><a class="nav-link"  href="#step-3" data-content-url="<?= Url::to(['erp-requisition-attachement/view-pdf1','pr_id'=>$model1->request_id,'stepcontent'=>3])?>">Page 3<br /><small>PR Supporting Docs</small></a></li>
                 <!--  ------------------------------transmission slip+ support docs-------------------------------------------------------------->
                
                <li><a class="nav-link"  href="#step-4" data-content-url="<?= Url::to(['erp-transmission-slip/view-form','id'=>$model3->id])?>">Page 4<br /><small>Transimission Slip</small></a></li>
                <li><a class="nav-link"  href="#step-5"  data-content-url="<?= Url::to(['erp-lpo-request-supporting-doc/view-pdf1','r_id'=>$model1->id,'stepcontent'=>5])?>">Page 5<br /><small>LPO Request Supporting Doc(s)</small></a></li>
                
                 <!--  ------------------------------genarated LPO-------------------------------------------------------------->
                <li><a class="nav-link"  href="#step-6" data-content-url="<?= Url::to(['erp-lpo/lpo-view-pdf','id'=>$model->id])?>">Page 6<br /><small>LPO </small></a></li>
                 <!--  ------------------------------work flow action--------------------------------------------------------------->
                      <?php
                   if($row1['approver']==Yii::$app->user->identity->user_id || $model->status=='drafting')
                 {
                ?>
                <li><a class="nav-link"   href="#step-7" data-content-url="<?=Url::to(['erp-lpo-approval/work-flow','lpo'=>$model->id]) ?>">Page 7 <br /><small>Approvals</small></a></li>
                 <?php  } ?>
               <?php endif;?>
               
               
                <?php if($model->type=='TT') : ?>
              
               <?php 
  //-------------------------------------------------get travel document------------------------------------------
                  $model2=ErpTravelRequest::find()->where(['id'=>$model1->request_id])->one() ; 

                ?>
                <!--  ------------------------------Travel document--------------------------------------------------------------->
                <li><a class="nav-link"  href="#step-1"  data-content-url="<?= Url::to(['erp-memo/view-memo-pdf','id'=>$model2->memo])?>">Page 1<br /><small>Memo</small></a></li>
                <li><a class="nav-link"  href="#step-2" data-content-url="<?= Url::to(['erp-travel-clearance/tcs-view-pdf','tr_id'=>$model2->id])?>">Page 2<br /><small>Tr.Clearance(s)</small></a></li>
                <li><a class="nav-link"  href="#step-3" data-content-url="<?= Url::to(['erp-claim-form/claims-view-pdf','tr_id'=>$model2->id])?>">Page 3<br /><small>Claim Form(s)</small></a></li>
                <li><a class="nav-link"  href="#step-4" data-content-url="<?= Url::to(['erp-travel-request-attachement/view-pdf1','tr_id'=>$model2->id,'stepcontent'=>4])?>">Page 4<br /><small>Tr.Support.Doc(s)</small></a></li>
                
                 <!--  ------------------------------Transmission Slip+support docs---------------------------------------------------------------> 
                <li><a class="nav-link"  href="#step-5" data-content-url="<?= Url::to(['erp-transmission-slip/view-form','id'=>$model3->id])?>">Page 5<br /><small>Trans.Slip</small></a></li>
                <li><a class="nav-link"  href="#step-6"  data-content-url="<?= Url::to(['erp-lpo-request-supporting-doc/view-pdf1','r_id'=>$model1->id,'stepcontent'=>6])?>">Page 6<br /><small>LPO.Req.Support.Doc(s)</small></a></li>
                
                 <!--  ------------------------------generated LPO--------------------------------------------------------------->
                <li><a class="nav-link"  href="#step-7" data-content-url="<?= Url::to(['erp-lpo/lpo-view-pdf','id'=>$model->id])?>">Page 7<br /><small>LPO </small></a></li>
                 <!--  ------------------------------work flow-------------------------------------------------------------->
                    <?php
                   if($row1['approver']==Yii::$app->user->identity->user_id || $model->status=='drafting')
                 {
                ?>
                <li><a class="nav-link"  href="#step-8" data-content-url="<?=Url::to(['erp-lpo-approval/work-flow','lpo'=>$model->id]) ?>">Page 8 <br /><small>WF.Action(s)</small></a></li>
               <?php  } ?>
              
              
              <?php endif;?>
              
              
              <?php if($model->type=='O') : ?>
              
              <?php  if($model3!=null): ?>
              
              <li><a class="nav-link"  href="#step-1" data-content-url="<?= Url::to(['erp-transmission-slip/view-form','id'=>$model3->id])?>">Page 1<br /><small>Transimission Slip</small></a></li>
              
              <?php endif;?>
              
               <?php  if($model1!=null): ?>
              
              <li><a class="nav-link"  href="#step-2"  data-content-url="<?= Url::to(['erp-lpo-request-supporting-doc/view-pdf1','r_id'=>$model1->id,'stepcontent'=>2])?>">Page 2<br /><small>LPO Request Supporting Doc(s)</small></a></li>
              
                <?php endif;?>
              
              
               <li><a class="nav-link"  href="#step-3" data-content-url="<?= Url::to(['erp-lpo/lpo-view-pdf','id'=>$model->id])?>">Page 3<br /><small>LPO </small></a></li>
               
                <?php
                   if($row1['approver']==Yii::$app->user->identity->user_id || $model->status=='drafting')
                 {
                ?>
                <li><a class="nav-link"  href="#step-4" data-content-url="<?=Url::to(['erp-lpo-approval/work-flow','lpo'=>$model->id]) ?>">Page 4<br /><small>Work flow Action(s)</small></a></li>
               <?php  } ?>
              
              <?php endif;?>
              
                
            </ul>

            <div class="tab-content">
                
                <?php if($model->type=='PR') : ?>
                
                <div id="step-1" class="tab-pane" role="tabpanel">
                <h3 class="border-bottom border-gray pb-2">Page 1 Content</h3>
                </div>
                <div id="step-2" class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Page 2 Content</h3>
                
                </div>
                 <div id="step-3" class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Page 3 Content</h3>
                
                </div>
                
                <div id="step-4" class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Page 4 Content</h3>
                
                </div>
                
                <div id="step-5" class="tab-pane" role="tabpanel">
                <h3 class="border-bottom border-gray pb-2">Page 5 Content</h3>
                </div>
                <div id="step-6" class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Page 6 Content</h3>
                
                </div>
                 <div id="step-7" class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Page 7 Content</h3>
                
                </div>
                
                <?php endif?>
                
                
                 <?php if($model->type=='TT') : ?>
                
                <div id="step-1" class="tab-pane" role="tabpanel">
                <h3 class="border-bottom border-gray pb-2">Page 1 Content</h3>
                </div>
                <div id="step-2" class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Page 2 Content</h3>
                
                </div>
                 <div id="step-3" class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Page 3 Content</h3>
                
                </div>
                
                <div id="step-4" class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Page 4 Content</h3>
                
                </div>
                
                <div id="step-5" class="tab-pane" role="tabpanel">
                <h3 class="border-bottom border-gray pb-2">Page 5 Content</h3>
                </div>
                <div id="step-6" class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Page 6 Content</h3>
                
                </div>
                 <div id="step-7" class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Page 7 Content</h3>
                
                </div>
                <div id="step-8" class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Page 8 Content</h3>
                
                </div>
                
                <?php endif?>
                
                 <?php if($model->type=='O') : ?>
              
             <div id="step-1" class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Page 1 Content</h3>
                
                </div>
                
                 <div id="step-2" class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Page 1 Content</h3>
                
                </div>
                
                 <div id="step-3" class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Page 1 Content</h3>
                
                </div>
                
                 <div id="step-4" class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Page 1 Content</h3>
                
                </div>
              
              <?php endif;?>
                
            </div>
        </div>
    </div>
        </div>


             
          <?php
$url=Url::to(['erp-persons-in-position/populate-names']); 
$contentURL=Url::to(['erp-lpo/fetch-tab','lpo_id'=>$model->id]); 
$uploadURL=Url::to(['erp-requisition-attachement/create','pr_id'=>$model->id,'context'=>'wizard']);

if($model->type=='PR'){
    $page=5;

}else if($model->type=='TT'){
    $page=6;
}
else{
    
    if($model1!=null){
       
       $page=2; 
        
    }else{
       $page=0;  
    }
    
    
   
    
    
}
$script = <<< JS

var el;
 $(document).ready(function(){

              

            // Step show event
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
               
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

            $('#step-3').html(data);
            
          

        })

        .fail(function () {

            console.log("Ajax fail: ");

        });               
                                                 
                                                 
                                             });
                                             
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });
                        var btnNext = $('<button></button>').text('Next')
                                             .addClass('btn btn-danger')
                                             .on('click', function(){  $('#smartwizard').smartWizard("next");return true; });

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
                   

            smartWizardConfig.init($page,[btnUpload],theme='dark',animation='none');


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