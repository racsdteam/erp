<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\file\FileInput;
use kartik\checkbox\CheckboxX;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use common\models\UserRoles;
use common\models\User;
use common\models\ErpOrgPositions;
use common\models\ErpOrgLevels;
use common\models\ErpOrgSubdivisions;
use kartik\detail\DetailView;
//use dosamigos\datepicker\DatePicker;


//use kartik\form\ActiveForm;






/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    
  .file-preview,.btn-file{
      
     width:300px;
  }
  
  .box{
      
      color:black;
  }
    
    
</style>

<?Php


  
  $attributes = [
   

                                       
                                        [
                                                        
                                                   
                                            'label'=>'First Name',
                                            'value'=>$model->first_name,
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],
                                       
                                          [
                                                        
                                                   
                                            'label'=>'Last Name',
                                            'value'=>$model->last_name,
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],  
                                          
                                       [
                                                        
                                                   
                                            'label'=>'User Name',
                                            'value'=>$model->username,
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],
                                       [
                                                        
                                                   
                                            'label'=>'Phone',
                                            'value'=>$model->phone,
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],
                                        [
                                                        
                                                   
                                            'label'=>'Email',
                                            'value'=>$model->email,
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],
                                         

                                       [
                                                        
                                                   
                                            'label'=>'Unit/Department/Office',
                                            'value'=>$model->subdivision,
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],
                                        [
                                                        
                                                   
                                            'label'=>'Position',
                                            'value'=>$model->position,
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],
                                
                                     
                                      
                                      
                                      
                                                ];

?>
<div class="row">



                <div class="<?php if(!$isAjax){echo 'col-lg-8 col-md-8 col-sm-12 col-xs-12 col-md-offset-2';}else{ echo 'col-lg-12 col-md-12 col-sm-12 col-xs-12';}  ?>  ">
                    
                    <div class="box box-default color-palette-box">
                        

                    <div class="box-header with-border">
                            <h1>
                                Profile Information
                               
                            </h1>
                            
                        </div>
                        <div class="box-body">

                        

                        <?php if (Yii::$app->session->hasFlash('success')): ?>
  
                                  <?php 
                                $msg=  Yii::$app->session->getFlash('success');
                                $code=1;
                                  echo '<script type="text/javascript">';
                                  echo 'showSuccessMessage("'.$msg.'");';
                                  echo '</script>';
                                  
                                  
                                  ?>
                        
  
                        <?php endif; ?>
                        
                        <?php if ($model->hasErrors()):  
                                $msg='';
                                foreach($model->getErrors() as $attribute=>$error)
                                {
                                
                                   foreach($error as $message){
                                
                                    $msg.=$message.'\r\n';
                                   }
                                }
                                $code=0;
                                     
                                        echo '<script type="text/javascript">';
                                        echo 'showAutoCloseTimerMessage(0,"'.$msg.'");';
                                        echo '</script>';
                            ?>
                                 <!--  <div class="alert alert-danger alert-dismissable">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                         <h4><i class="icon fa fa-check"></i>Error!</h4>
                                        
                                   </div>-->
                                         
                        <?php endif; ?>


                        <?php if($model->user_image!==''){
 $previewURL=Yii::$app->request->baseUrl . '/' .$model->user_image;

                        } else{

                            $previewURL=Yii::$app->request->baseUrl . '/' ."img/user-avatar.png";

                        } 
                     
                       
                        ?>

                       

               <?= DetailView::widget([
'model'=>$model,
'condensed'=>false,
//'hideIfEmpty'=>true,
'hover'=>true,

'bootstrap'=>true,
//'striped'=>false,
'mode'=>DetailView::MODE_VIEW,
'panel' => [
                       'heading' => '&nbsp',
                       'type' => DetailView::TYPE_DEFAULT,
                       'headingOptions' => [
                           'template' => '<img  src="'.$previewURL.'" class="img-circle" width="190" height="190">'
                       ]
                   ],
'attributes'=>$attributes,

])?>

                               
                           
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical Layout | With Floating Label -->


         <!-- displaying view by NID AND PASSORT MODAL -->  
    
          
          <?php
         
$nextURL = Yii::$app->urlManager->createUrl('site/index') ;



$script = <<< JS
var strvalue = "";
$.fn.modal.Constructor.prototype.enforceFocus = $.noop;//to be able to search through select2

$(document).ready(function()
                            {
                              //$(".select2").select2();
            
            $("select").select2({
 //-------------------------------------------for it to be responsive----------------------------------------------------- 
 width: '100%' 
});
                                   
            
            
                            });
                            
                            $('.org-unit').on('select2:select', function (e) {
    var unit=$(this).val();
    console.log(unit);
    $.get('{$url}',{ unit : unit },function(data){
     console.log(data);
    
  var select = $('.unit-pos');
                select.find('option').remove().end();
                
      select.html(data);         

//trigger change-------------otherwise not updating
$('.unit-pos').trigger('change.select2');
    });
});




$('#user-profile-update-form').on('beforeSubmit', function(event) {
       
    
    
    var \$form = $(this);
    var formData = new FormData(\$form [0]);// to be able to send file
    console.log(formData);
    $.ajax({
        url: \$form.attr("action"),  //Server script to process data
        type: 'POST',

        // Form data
        data: formData,

       // beforeSend: beforeSendHandler, // its a function which you have to define

        success: function(response) {
          
          //alert(response);
          
           if(response['success']==true){
        
            showSuccessMessage("Personal Profile Updated!");

             window.location.href='{$nextURL}';      
         
          
            
           }else{

            showErrorMessage(response['message']);

           }
        },

        error: function(){
            alert('ERROR at PHP side!!');
        },


        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false
    });

  
return false;//prevent the modal from exiting
});



JS;
$this->registerJs($script);

?>


