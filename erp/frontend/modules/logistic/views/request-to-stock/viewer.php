<?php
use yii\helpers\Url;

use yii\helpers\Html;

use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this);


     $q1=" SELECT f.* FROM request_approval_flow as f  where f.request='".$model->reqtostock_id."' and status='pending' and  f.is_copy!=1 order by f.timestamp desc ";
         $com1= Yii::$app->db1->createCommand($q1);
         $row1 = $com1->queryOne();
?>

<div class="card">
                        <div class="card-header">
                           
                            <h6 class="fa"> <i class="fa fa-opencart"></i>Stock Voucher</h6>
                     
                        </div>
                        
                        
                        <div class="card-body">

     
   <div id="smartwizard">
            
            <ul class="nav">
                
                  <li><a class="nav-link" href="#step-1" 
                data-page=1 
                data-content-url="<?=Url::to(['request-to-stock/fetch-tab','id'=>$model->reqtostock_id])?>" >Page 1<br /><small>Stock Voucher</small></a></li>
               <?php
                  if($row1['approver']==Yii::$app->user->identity->user_id || $model->status=='drafting')
                {
                ?>
                      <li><a href="#step-2" class="nav-link" data-content-url="<?=Url::to(['request-approval/work-flow','request'=>$model->reqtostock_id]) ?>">Page 2 <br /><small>Work Flow Action(s)</small></a></li>
             <?php 
                }
                ?>
              
            </ul>

            <div class="tab-content">
                
                
                <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                <h3 class="border-bottom border-gray pb-2">Page 1 Content</h3>
                </div>
               <?php
                  if($row1['approver']==Yii::$app->user->identity->user_id || $model->status=='drafting')
                {
                ?>
                <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                    <h3 class="border-bottom border-gray pb-2">Page 2 Content</h3>
                
                </div>
                  <?php 
                }
                ?>
               
              
            </div>
        </div>
    </div>
        </div>


             
          <?php


$script = <<< JS

var el;

 $( document ).ready(function($){

              

            // Step show event
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
                var currentPage   = anchorObject.data('page');
              
             
               if(stepPosition === 'first'){
                   $("#prev-btn").addClass('disabled');
               }else if(stepPosition === 'last'){
                   $("#next-btn").addClass('disabled');
               }else{
                   $("#prev-btn").removeClass('disabled');
                   $("#next-btn").removeClass('disabled');
                   
               }
               
               
            });

            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text('Finish')
                                             .addClass('btn btn-info')
                                             .on('click', function(){ $('#smartwizard').smartWizard("next1");});
                                             
           var btnUpload = $('<button></button>').html('<i class="fas fa-plus-circle"></i> Add Attachement')
                                             .addClass('btn btn-success  upload')
                                             .on('click', function(e){ 
            
                     e.preventDefault();
                      

        e.stopPropagation();
        var url='{$uploadURL}';
        $.get(url)

        .done(function (data) {
            
            $('#step-{$uploadContent}').html(data);
            
          

        })

        .fail(function () {

            console.log("Ajax fail: ");

        });               
                                                 
                                        
                    
                    //$('#smartwizard').smartWizard("goToStep",0);
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
            smartWizardConfig.init(0,[],theme='dark',animation='none');
           
           
        });
JS;
$this->registerJs($script,$this::POS_END);
?>