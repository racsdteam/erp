<?php
use yii\helpers\Url;

use yii\helpers\Html;
use common\models\ErpRequisition;

use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this);

use common\components\Constants;

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



div.form-group label{
    
    color:black;
    font-size:16px;
}
</style>


<div class="card">
                        <div class="card-header">
                           
                            <h6 class="fa"> <i class="fa fa-opencart"></i>New Memo Request</h6>
                     
                        </div>
                        
                        
                        <div class="card-body">
  
<?php 
 $q=" SELECT m.*, c.*  FROM erp_memo_categ as c
 inner join erp_memo  as m  on c.id=m.type  
 where m.id='".$model->id."' ";
     $com = Yii::$app->db->createCommand($q);
     $row = $com->queryOne();
    
   // $mcateg=ErpMemoCateg::find()->where(['id'=>$model->type])->one();

         $q1=" SELECT f.* FROM erp_memo_approval_flow as f  where f.memo_id='".$model->id."' and status='pending' and  f.is_copy!=1 order by f.timestamp desc ";
         $com1= Yii::$app->db->createCommand($q1);
         $row1 = $com1->queryOne();
     
    if  ($row['categ_code']==Constants::MEMO_TYPE_PR){
         
         $model1=ErpRequisition::find()->where(['reference_memo'=>$model->id])->one() ;
        
    }

?>

     
   <div id="smartwizard">
            
            <ul class="nav">
                
                <li><a class="nav-link" href="#step-1" 
                data-page=1 
                data-content-url="<?=Url::to(['erp-memo/fetch-tab','memo_id'=>$model->id,'step_number'=>0])?>">Page 1<br />
                <small>Memo</small></a></li>
                
                 <!-- purchase requisition------------------------------------------->
                
                <?php if  ($row['categ_code']==Constants::MEMO_TYPE_PR) :?>
               
                <li><a class="nav-link" href="#step-2" 
                data-page=2 
                data-content-url="<?= Url::to(['erp-requisition/view-form-pdf','pr_id'=>$model1->id])?>">Page 2<br />
                <small>Requistion Form</small></a></li>
                
                <li><a  class="nav-link" href="#step-3" 
                data-page=3 
                data-content-url="<?= Url::to(['erp-requisition-attachement/get-support-docs-by-req','id'=>$model1->id,'stepcontent'=>3])?>">Page 3<br />
                <small>Requisition Support Docs</small></a></li>
               
                <?php 
       
               if($row1['approver']==Yii::$app->user->identity->user_id   || $model->status=='drafting' || $model->status=='Returned')
                {
                ?>
                <li><a  class="nav-link" href="#step-4" 
                data-page=4 
                data-content-url="<?=Url::to(['erp-memo-approval/work-flow','memo_id'=>$model->id]) ?>">Page 4 <br /><small>Approvals</small></a></li>
                <?php } ?>
                
                 <!--request for payment-------------------------------------------------->
                
                <?php elseif($row['categ_code']==Constants::MEMO_TYPE_RFP) :?>
                
               
               
                <li><a class="nav-link" href="#step-2" 
                data-page=2
                data-content-url="<?=Url::to(['erp-memo-supporting-doc/get-support-docs-by-memo','id'=>$model->id,'stepcontent'=>2]) ?>">Page 2<br /><small>Supporting Documents(s)</small></a></li>
                <?php
                   if($row1['approver']==Yii::$app->user->identity->user_id || $model->status=='drafting' || $model->status=='Returned')
                 {
                ?>
                <li><a class="nav-link" href="#step-3"
                data-page=3
                data-content-url="<?=Url::to(['erp-memo-approval/work-flow','memo_id'=>$model->id]) ?>">Page 3 <br /><small>Approvals</small></a></li>
                 <?php  } ?>
               
               <!-- 0ther---------------------------------------------------->
                <?php else :?>
                
                 <li><a class="nav-link"  href="#step-2" 
                 data-page=2 
                 data-content-url="<?=Url::to(['erp-memo-supporting-doc/get-support-docs-by-memo','id'=>$model->id,'stepcontent'=>2]) ?>" >Page 2<br />
                 <small>Supporting Documents(s)</small></a></li>
                
                <!--hidden add attachement ---->
                
                
                 
                 <?php
                  if($row1['approver']==Yii::$app->user->identity->user_id || $model->status=='drafting' || $model->status=='Returned')
                {
                ?>
                 <li><a class="nav-link" href="#step-3" 
                 data-page=3 
                 data-content-url="<?=Url::to(['erp-memo-approval/work-flow','memo_id'=>$model->id]) ?>">Page  3<br /><small>Approvals</small></a></li>
                <?php } ?>
                
                
               <?php endif;   ?>
             
            </ul>

            <div class="tab-content">
                
                
                <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                <h3 class="border-bottom border-gray pb-2">Page 1 Content</h3>
                </div>
                
                
                 <?php if  ($row['categ_code']=='PR') :?>
                
                <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                    <h3 class="border-bottom border-gray pb-2">Page 2 Content</h3>
                
                </div>
                
                <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                   
                  <h3 class="border-bottom border-gray pb-2">Page 3 Content</h3>   
                </div>
               
               <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                   
                  <h3 class="border-bottom border-gray pb-2">Page 4 Content</h3>   
                </div>
             
                   <?php elseif($row['categ_code']=='RFP') :?>
               
                <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                    <h3 class="border-bottom border-gray pb-2">Page 2 Content</h3>
                
                </div>
                
                <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                  <h3 class="border-bottom border-gray pb-2">Page 3 Content</h3>   
                </div>
                   
                   <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                   
                  <h3 class="border-bottom border-gray pb-2">Page 4 Content</h3>   
                </div>
                <?php else :?>
              
                <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                    <h3 class="border-bottom border-gray pb-2">Page 2 Content</h3>
                
                </div>
                
                 <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                   
                  <h3 class="border-bottom border-gray pb-2">Page 3 Content</h3>   
                </div>
                <?php endif;   ?> 
            </div>
        </div>

    </div>
        </div>


             
          <?php
$categCode=$row['categ_code'];
if($categCode==Constants::MEMO_TYPE_PR){

 $uploadContent=3;
 $uploadPage=3;
 $uploadURL=Url::to(['erp-requisition-attachement/create','pr_id'=>$model1->id,'stepcontent'=>$uploadContent]);  
 
}else if($categCode==Constants::MEMO_TYPE_RFP){
 
   $uploadContent=2;
   $uploadPage=2;
   $uploadURL=Url::to(['erp-memo-supporting-doc/create','memo'=>$model->id,'stepcontent'=> $uploadContent]);   
  
}
else{

   $uploadContent=2;
   $uploadPage=2;
   $uploadURL=Url::to(['erp-memo-supporting-doc/create','memo'=>$model->id,'stepcontent'=>$uploadContent]); 
   
}

$assetsCodeURL=Url::to(['erp-requisition/assets-code','id'=>$model1->id]); 
$type=$model->categ->categ_code;



$script = <<< JS



 $( document ).ready(function($){

              

            // Step show event
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
                var currentPage   = anchorObject.data('page');
              
             
               if(stepPosition === 'first'){
                   $("#prev-btn").addClass('disabled');
                 //------------custom previuos button----------------- 
                   $(".prev-btn").addClass('disabled');
               }else if(stepPosition === 'last'){
                   $("#next-btn").addClass('disabled');
               //---------------custom next button-------------------    
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
            if(currentPage==$uploadPage){
                  
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

                                             });
                                             
              var btnPrevious= $('<button></button>').text('Previous')
                                             .addClass('btn btn-primary prev-btn')
                                             .on('click', function(){ $('#smartwizard').smartWizard("prev");
                return true; });
                                             
             var btnNext= $('<button></button>').text('Next')
                                             .addClass('btn btn-primary next-btn')
                                             .on('click', function(){ $('#smartwizard').smartWizard("next");
                return true; });                                 
                                             
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
            var type='{$type}';
            var btnArr=new Array();
            btnArr.push(btnUpload);
            if(type=='PR'){
              btnArr.push(btnAssetsCode);   
            }
           btnArr.push(btnPrevious);
           btnArr.push(btnNext);
            
            smartWizardConfig.init(0,btnArr,theme='dark',animation='none',showPrevious=false,showNext=false);
           
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