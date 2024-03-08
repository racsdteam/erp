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


  .btn-info:not(:disabled):not(.disabled).active, .btn-info:not(:disabled):not(.disabled):active, .show>.btn-info.dropdown-toggle {
    color: #fff;
    background-color: #117a8b !important;
    border-color: #10707f !important;
} 

.upload,.btn-cancel{
    
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

  <div class="card">
                        <div class="card-header">
                           
                            <h6 class="fa"> <i class="fas fa-book-open"></i> DOCUMENT VIEW</h6>
                     
                        </div>
                        
                        
                        <div class="card-body">
                            
   <div  id="smartwizard">
            
            <ul class="nav">
                

               <li><a class="nav-link" href="#step-1" 
                data-page=1 
                data-content-url="<?=Url::to(['erp-document/fetch-tab','id'=>$model->id,'step_number'=>0])?>">Page 1<br />
                <small><i class="fas fa-binoculars"></i> Document View</small></a>
                </li>
               
                <?php
               //---------------check if last recipient---------------------------------------- 
                  $q1=" SELECT f.* FROM erp_document_flow_recipients  as f  where f.document='".$model->id."' and recipient=".Yii::$app->user->identity->user_id ." and 
           status = 'pending' and is_copy=0 order by f.timestamp desc ";
     $com1= Yii::$app->db->createCommand($q1);
     $row1 = $com1->queryOne(); 
     
                  if(!empty($row1['recipient'])|| $model->status=='drafting'){
                ?>
                <li><a class="nav-link" href="#step-2"  data-content-url="<?=Url::to(['erp-document/fetch-tab','id'=>$model->id,'step_number'=>1])?>">Page 2<br />
                <small><i class="fas fa-handshake"></i> Approvals</small></a></li>
                
                      <?php 
                      }
                      ?>
                
                
             
            </ul>

            <div  class="tab-content">
                
                
                
                <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                 

                </div>
                <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                 

                </div>
              
            </div>
        </div>
   
 
 </div>
        </div>
             
          <?php
 

$uploadURL=Url::to(['erp-document-attachment/create','id'=>$model->id,'context'=>'wizard']);

$uploadPage=1;
$script = <<< JS


 $(document).ready(function(){

           

            // Step show event
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
              
                var currentPage   = anchorObject.data('page');
               if(stepPosition === 'first'){
                   $("#prev-btn").addClass('disabled');
                     $(".prev-btn").addClass('disabled');
               }else if(stepPosition === 'last'){
                   $("#next-btn").addClass('disabled');
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
              if($uploadPage==currentPage){
                  
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
                                             .addClass('btn btn-danger btn-cancel')
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
                   

            
             
            smartWizardConfig.init(0,[btnCancel,btnUpload,btnPrevious,btnNext],theme='dark',animation='none',showPrevious=false,showNext=false);
 


        });
JS;
$this->registerJs($script,$this::POS_END);
?>