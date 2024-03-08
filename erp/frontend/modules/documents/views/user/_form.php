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
  
  
    
    
</style>


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

                       

                                <?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data'],
                                'id'=>'user-form', 
                               'enableClientValidation'=>true,
                              // 'action' => ['user/update?id='.Yii::$app->user->getId()],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               ]); ?>

                    <div class="row clearfix">

                         <div class="'col-lg-4 col-md-4 col-sm-12 col-xs-12">                     

                               
       <?= $form->field($model, 'photo_uploaded_file')->widget(FileInput::classname(), [
                                           
                                           
                                           'pluginOptions'=>['allowedFileExtensions'=>['jpg','png'],
                                           'showCaption' => false,
                                           'showRemove' => false,
                                           'showUpload' => false,
                                           'browseClass' => 'btn btn-primary btn-block',
                                           'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                           'browseLabel' =>  'Select Photo',
                                           
                                           'initialPreview'=>[ Html::img($previewURL,['class'=>' kv-preview-data file-preview-image', 
                                          'width'=>'auto','height'=>'auto','max-width'=>'100%','max-height'=>'100%','alt'=>' Missing', 'title'=>'missing'])],
                                          'overwriteInitial'=>true
                                          
                                         
                                        
                                        
                                        
                                        ],'options' => ['accept' => 'image/*']
                                              ])?>


                                    </div></div>
      
                                          <?= $form->field($model, 'first_name', ['template' => '
                       
                            <div class="input-group col-sm-12">
                            {input}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                                
                            </div>{error}{hint}
                    '])->textInput(['autofocus' => true])
                                ->input('text', ['placeholder'=>'FirstName']) ?>


 <?= $form->field($model, 'last_name', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       {input}
                           <span class="input-group-addon">
                               <span class="glyphicon glyphicon-user"></span>
                           </span>
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'LastName']) ?>
 

     <?= $form->field($model, 'phone', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       {input}
                           <span class="input-group-addon">
                               <span class="glyphicon glyphicon-earphone"></span>
                           </span>
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Phone']) ?>
                           


       <?= $form->field($model, 'email', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       {input}
                           <span class="input-group-addon">
                               <span class="glyphicon glyphicon-envelope"></span>
                           </span>
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Email']) ?>


                           <?php
                           
$lvs=ErpOrgLevels::find()->all();
$options=array();


foreach($lvs as $l){
    $data=array();
    $q1="SELECT * from erp_org_units as s  
    where unit_level={$l->id} ";
    $com1 = Yii::$app->db->createCommand($q1);
     $rows = $com1->queryAll();

     foreach($rows as $row){
         
       
        $data[$row['id']]=$row['unit_name'];
         
        
     }
     
    $options[strtoupper($l->level_name."s")]=$data;
    
   
   
   // $sbs=ErpOrgSubdivisions::find()->where(['subdiv_level'=>$l->id])->all();
   

}


$positions=ErpOrgPositions::find()->all();

//use yii\helpers\ArrayHelper;
$listData2=ArrayHelper::map($positions,'id','position');

echo $form->field($model, 'subdivision',['template' => '
                       
<div   class="input-group  col-sm-12">
{input}
    <span class="input-group-addon">
        <span class="glyphicon glyphicon-briefcase"></span>
    </span>
    
</div>{error}{hint}
'])->dropDownList(
    $options,
        ['prompt'=>'Select  organizational unit','class'=>['form-control  select2 org-unit']]
        )->label(false);


?>

<?php
echo $form->field($model, 'position',['template' => '
                       
<div  class="input-group col-sm-12">
{input}
    <span class="input-group-addon">
        <span class="glyphicon glyphicon-briefcase"></span>
    </span>
    
</div>{error}{hint}
'])->dropDownList(
        $listData2,
        ['prompt'=>'Select position','class'=>['form-control select2 unit-pos']]
        )->label(false);
?>

        <?= $form->field($model, 'username', ['template' => '
                       
                       <div class="input-group col-sm-12">
                       {input}
                           <span class="input-group-addon">
                               <span class="glyphicon glyphicon-user"></span>
                           </span>
                           
                       </div>{error}{hint}
               '])->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Username']) ?>
                           
                <?php if(Yii::$app->user->identity->user_level==User::ROLE_ADMIN) :?>           

<?= $form->field($model, 'user_level')->widget(Select2::classname(), [
    'data' =>[ ArrayHelper::map(UserRoles::find()->all(),'role_id', 'role_name') ],
    'options' => ['placeholder' => 'Select role...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])?>

<?php endif?>

                                          
                                        
                                        

                                           

                                          <div class="form-group" style="text-align:center;">
                                          
                                                  <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
                                         </div>

                                <?php ActiveForm::end(); ?>
                           
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical Layout | With Floating Label -->


         <!-- displaying view by NID AND PASSORT MODAL -->  
    
          
          <?php
         
$nextURL = Yii::$app->urlManager->createUrl('site/index') ;
$url=Url::to(['erp-units-positions/populate-positions']);


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


