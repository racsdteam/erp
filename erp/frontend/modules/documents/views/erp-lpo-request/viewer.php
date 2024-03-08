<?php
use yii\helpers\Url;

use yii\helpers\Html;
use common\models\ErpMemo;
use common\models\ErpTransmissionSlip;
use common\models\ErpRequisition;
use common\models\ErpTravelRequest;
use common\models\ErpLpo;

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
                           
                            <h6 class="fa"> <i class="fab fa-opencart"></i>New LPO  Request </h6>
                     
                        </div>
                        
                        
                        <div class="card-block p-0">
                            
                               <?php if (Yii::$app->session->hasFlash('success')): ?>
                               
                               <?php
                                echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.Yii::$app->session->getFlash('success') .'");';
  echo '</script>';
 
  ?>
           

<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('failure')): ?>
 
  
                               <?php
                                echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.Yii::$app->session->getFlash('error') .'");';
  echo '</script>';
 
  ?>
 
 
         <?php endif; ?>
  
                <?php 
                
                
                $model2=ErpTransmissionSlip::find()->where(['type'=>'LPO','type_id'=>$model->id])->orderBy([ 'timestamp' => SORT_DESC])->one() ; 
            
                
    $q1=" SELECT f.* FROM erp_lpo_request_approval_flow as f  where f.lpo_request='".$model->id."' and is_copy!=1 order by f.timestamp desc ";
     $com1= Yii::$app->db->createCommand($q1);
     $row1 = $com1->queryOne();
                ?>

     
   <div id="smartwizard">
            <ul class="nav">
          
          <!-- ------------------------------check if--purchase requisition-------------------------------------------------->      
                <?php if($model->type=='PR') : ?>
                
                 <?php 

                  $model1=ErpRequisition::find()->where(['id'=>$model->request_id])->one() ; 
            

                ?>
                
                <li><a class="nav-link" href="#step-1" data-page=1 data-content-url="<?= Url::to(['erp-memo/view-memo-pdf','id'=>$model1->reference_memo])?>">Page 1<br /><small>Memo</small></a></li>
                <li><a class="nav-link" href="#step-2" data-page=2 data-content-url="<?= Url::to(['erp-requisition/view-form-pdf','pr_id'=>$model->request_id])?>">Page 2<br /><small>Requisition Form</small></a></li>
                <li><a class="nav-link" href="#step-3" data-page=3 data-content-url="<?= Url::to(['erp-requisition-attachement/view-pdf1','pr_id'=>$model->request_id,'stepcontent'=>3])?>">Page 3<br /><small>Requisition Support Docs</small></a></li>
                
                <li><a class="nav-link" href="#step-4" data-page=4 data-content-url="<?= Url::to(['erp-transmission-slip/view-form','id'=>$model2->id])?>">Page 4<br /><small>Transimission Slip</small></a></li>
                
                <li><a class="nav-link" href="#step-5" data-page=5 data-content-url="<?= Url::to(['erp-lpo-request-supporting-doc/view-pdf1','r_id'=>$model->id,'stepcontent'=>5])?>" >Page 5<br /><small>LPO Request Support Doc(s)</small></a></li>
               
                <?php if($model->status=='completed') : ?>
               
                <?php  $LPO=ErpLpo::find()->where(['lpo_request_id'=>$model->id])->one(); ?>
               
               <li><a class="nav-link" href="#step-6" data-page=6 data-content-url="<?= Url::to(['erp-lpo/lpo-view-pdf','id'=>$LPO->id])?>">Page 6<br /><small>LPO </small></a></li>
             
             <?php
                   if($row1['approver']==Yii::$app->user->identity->user_id || $model->status=='drafting')
                 {
                ?>
               <li><a href="#step-7" data-page=7  data-content-url="<?= Url::to(['erp-lpo-request-approval/work-flow','lpo_request'=>$model->id,'status'=>$model->status])?>">Page 7<br /><small>Work Flow Action(s)</small></a></li>  
                 <?php  } ?>
               
               
               <?php else :?>
                
                <?php
                   if($row1['approver']==Yii::$app->user->identity->user_id || $model->status=='drafting')
                 {
                ?>
                <li><a class="nav-link" href="#step-6" data-page=6 data-content-url="<?= Url::to(['erp-lpo-request-approval/work-flow','lpo_request'=>$model->id,'status'=>$model->status])?>">Page 6<br /><small>Work Flow Action(s)</small></a></li> 
                 <?php  } ?>
                
                
                <?php endif;?>
                
                <?php endif;?>
              
              <!-- travel request---------------------------------------------------->
              
              <?php if($model->type=='TT') : ?>
              
               <?php 

                  $model3=ErpTravelRequest::find()->where(['id'=>$model->request_id])->one() ; 

                ?>
                <li><a class="nav-link" href="#step-1" data-page=1  data-content-url="<?= Url::to(['erp-memo/view-memo-pdf','id'=>$model3->memo])?>">Page 1<br /><small>Memo</small></a></li>
                <li><a class="nav-link" href="#step-2" data-page=2 data-content-url="<?= Url::to(['erp-travel-clearance/tcs-view-pdf','tr_id'=>$model3->id])?>">Page 2<br /><small>Tr.Clearance(s)</small></a></li>
                <li><a class="nav-link"  href="#step-3" data-page=3 data-content-url="<?= Url::to(['erp-claim-form/claims-view-pdf','tr_id'=>$model3->id])?>">Page 3<br /><small>Claim Form(s)</small></a></li>
                <li><a class="nav-link" href="#step-4" data-page=4 data-content-url="<?= Url::to(['erp-travel-request-attachement/view-pdf1','tr_id'=>$model3->id])?>">Page 4<br /><small>Tr.Support Doc(s)</small></a></li>
                
                 
                <li><a class="nav-link" href="#step-5" data-page=5 data-content-url="<?= Url::to(['erp-transmission-slip/view-form','id'=>$model2->id])?>">Page 5<br /><small>Transimission Slip</small></a></li>
                <li><a class="nav-link" href="#step-6" data-page=6  data-content-url="<?= Url::to(['erp-lpo-request-supporting-doc/view-pdf1','r_id'=>$model->id])?>" >Page 6<br /><small>LPO Req.Support Doc(s)</small></a></li>
               
               
               
               
               <?php
                   if($row1['approver']==Yii::$app->user->identity->user_id || $model->status=='drafting')
                 {
                ?>
                <li><a class="nav-link" href="#step-7" data-page=7 data-content-url="<?= Url::to(['erp-lpo-request-approval/work-flow','lpo_request'=>$model->id])?>">Page 7<br /><small>WF Action(s)</small></a></li>  
              
              <?php  } ?>
              <?php endif;?>
              
               <?php if($model->type=='O') : ?>
              
               
               
                 
                <li><a class="nav-link" href="#step-1" data-page=1 data-content-url="<?= Url::to(['erp-transmission-slip/view-form','id'=>$model2->id])?>">Page 1<br /><small>Transimission Slip</small></a></li>
                <li><a class="nav-link" href="#step-2"  data-page=2 data-content-url="<?= Url::to(['erp-lpo-request-supporting-doc/view-pdf1','r_id'=>$model->id,'stepcontent'=>2])?>" >Page 2<br /><small>LPO RequestSupport Doc(s)</small></a></li>
                
                
                
                <?php
                   if($row1['approver']==Yii::$app->user->identity->user_id || $model->status=='drafting')
                 {
                ?>
              
                <li><a class="nav-link"  href="#step-3" data-page=3 data-content-url="<?= Url::to(['erp-lpo-request-approval/work-flow','lpo_request'=>$model->id])?>">Page 3<br /><small>Work Flow Action(s)</small></a></li>  
              
                <?php  } ?>
                
                  <?php
                   if( $model->status=='completed')
                 {
                     $LPO=ErpLpo::find()->where(['lpo_request_id'=>$model->id])->one();
                ?>
              
                 <li><a class="nav-link" href="#step-3" data-page=3 data-content-url="<?= Url::to(['erp-lpo/lpo-view-pdf','id'=>$LPO->id])?>">Page 3<br /><small>LPO </small></a></li>
              
                <?php  } ?>
                
              <?php endif;?>
              
              
            </ul>

           
                <div class="tab-content">
                
                <?php if($model->type=='PR') : ?>
                
                 
                
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
                
                
                
                <div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
                <h3 class="border-bottom border-gray pb-2">Page 5 Content</h3>
                </div>
                
                <?php if($model->status=='completed' && isset($po)) : ?>
                
                <div id="step-6" class="tab-pane" role="tabpanel" aria-labelledby="step-6">
                    <h3 class="border-bottom border-gray pb-2">Page 6 Content</h3>
                
                </div>
                
                <div id="step-7" class="tab-pane" role="tabpanel" aria-labelledby="step-7">
                    <h3 class="border-bottom border-gray pb-2">Page 6 Content</h3>
                
                </div>
                
                
                <?php else:?>
                
                <div id="step-6" class="tab-pane" role="tabpanel" aria-labelledby="step-6">
                    <h3 class="border-bottom border-gray pb-2">Page 6 Content</h3>
                
                </div>
                
            <?php endif?>
                
                
                
                <?php endif?>
                
                 
                 
                 <?php if($model->type=='TT') : ?>
                 
                 
                
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
                
                <div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
                <h3 class="border-bottom border-gray pb-2">Page 5 Content</h3>
                </div>
                <div id="step-6" class="tab-pane" role="tabpanel" aria-labelledby="step-6">
                    <h3 class="border-bottom border-gray pb-2">Page 6 Content</h3>
                
                </div>
                 <div id="step-7" class="tab-pane" role="tabpanel" aria-labelledby="step-7">
                    <h3 class="border-bottom border-gray pb-2">Page 7 Content</h3>
                
                </div>
                
                
                
                <?php endif?>
                
                
                <?php if($model->type=='O') : ?>
                 
                 
                
                <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                <h3 class="border-bottom border-gray pb-2">Page 1 Content</h3>
                </div>
                <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                    <h3 class="border-bottom border-gray pb-2">Page 2 Content</h3>
                
                </div>
                 
                <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                    <h3 class="border-bottom border-gray pb-2">Page 3 Content</h3>
                
                </div>
                
                
                <?php endif?>
                
                 </div>
                
           
        </div>
    </div>
        </div>


             
          <?php


$uploadURL=Url::to(['erp-lpo-request-supporting-doc/create','request_id'=>$model->id,'currentUrl'=>Yii::$app->request->url]);


    
 if(($model->status=='completed' && isset($po)) && $model->type=='PR'){
    $initialPage=5;
}

elseif(($model->status=='completed' && isset($po)) && $model->type=='TT'){
    $initialPage=6;
}else{
   
     if($model->type=='PR'){
         
        $initialPage=3; 
        $uploadPage=5;
        $uploadPageContent=5;
     }
     if($model->type=='TT'){
       
       $initialPage=4;
       $uploadPage=6;
       $uploadPageContent=6;
     }
    
     if($model->type=='O'){
       
       $initialPage=0;
       $uploadPage=2;
       $uploadPageContent=2;
     }
 
  
}




$request_type=$model->type; 

$script = <<< JS

var el;

 $(document).ready(function(){

              

            // Step show event
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
               var dataPage   = anchorObject.data('page');
               if(stepPosition === 'first'){
                   $("#prev-btn").addClass('disabled');
                   $(".prev-btn").addClass('disabled');
               }else if(stepPosition === 'last'){
                   $("#next-btn").addClass('disabled');
                   $(".next-btn").addClass('disabled');
               }else{
                   $("#prev-btn").removeClass('disabled');
                   $(".prev-btn").removeClass('disabled');
                   
                   $("#next-btn").removeClass('disabled');
                   $(".next-btn").removeClass('disabled');
                   
               }
               
           
               
              //------------------------show attachment button-------------------------------
              if(dataPage== $uploadPage){
                  
                 $('.upload').show(); 
                
                 
              }
              else{
                  
                $('.upload').css("display","none") ; 
              }
               
            });

            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text('Finish')
                                             .addClass('btn btn-info')
                                             .on('click', function(){ $('#smartwizard').smartWizard("next1");});
                                             
           var btnUpload = $('<button></button>').html('<i class="fa fa-upload"></i> Add Attachement')
                                             .addClass('btn btn-info  upload')
                                             .on('click', function(e){ 
            
                      e.preventDefault();
                      

        e.stopPropagation();
        var url='{$uploadURL}&stepNumber='+$uploadPage;
       
        $.get(url)
         
        .done(function (data) {
        
            $('#step-'+$uploadPageContent).html(data);
            
          

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
                   

            smartWizardConfig.init($initialPage,[btnUpload,btnPrevious,btnNext],theme='dark',animation='none',showPrevious=false,showNext=false);



        });
JS;
$this->registerJs($script,$this::POS_END);
?>