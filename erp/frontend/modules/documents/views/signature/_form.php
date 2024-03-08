<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use softark\duallistbox\DualListbox;
use kartik\select2\Select2;
use yii\helpers\Url;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\User;
use yii\db\Query;

?>
<style>
    
  .file-preview,.btn-file{
      
     width:300px;
  }
  
  
    
    
</style>
       <?php if($model->signature!==''){
 $previewURL=Yii::$app->request->baseUrl . '/' .$model->signature;

                        } else{

                            $previewURL=Yii::$app->request->baseUrl . '/' ."img/user-avatar.png";

                        } 
                     
                       
                        ?>
<div class="signature-form">



      <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion0" href="#collapseFour">
                      <i class="material-icons">folder_shared</i><span> About Recipient(s)</span> 
                      </a>
                    </h4>
                  </div>
                  <div id="collapseFour" class="panel-collapse in collapse">
                    <div class="box-body">
                        <?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data'],
                                'id'=>'user-profile-update-form', 
                               'enableClientValidation'=>true,
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               ]); ?>
  
                    <?php
$query = new Query;
$query	->select([
    'p.*',
    
])->from('erp_org_positions as p ');

$command = $query->createCommand();
$rows= $command->queryAll();

$options=ArrayHelper::map($rows,'id','position');

//-----------------------------------------names---------------------------------------------------------------------

                    
   ?>                 
                    
                    <?= $form->field($model, 'position')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
    'options' => ['placeholder' => 'Select recipients ...','id'=>'recipients-select'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])?>                
                    
                    <?= $form->field($model, 'user')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(User::find()->all(), 'user_id', function($user){

      return $user->first_name." ".$user->last_name;
  })],
    'options' => ['placeholder' => 'Select names ...','id'=>'recipients-names'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])?> 
   <?= $form->field($model, 'signature_uploaded_file')->widget(FileInput::classname(), [
                                           
                                           
                                           'pluginOptions'=>['allowedFileExtensions'=>['jpg','png'],
                                           'showCaption' => false,
                                           'showRemove' => false,
                                           'showUpload' => false,
                                           'browseClass' => 'btn btn-primary btn-block',
                                           'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                           'browseLabel' =>  'Select Signature Image',
                                           
                                           'initialPreview'=>[ Html::img($previewURL,['class'=>' kv-preview-data file-preview-image', 
                                          'width'=>'auto','height'=>'auto','max-width'=>'100%','max-height'=>'100%','alt'=>' Missing', 'title'=>'missing'])],
                                          'overwriteInitial'=>true
                                          
                                         
                                        
                                        
                                        
                                        ],'options' => ['accept' => 'image/*']
                                              ])?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
  </div>
    </div>
      </div>




</div>
    <?php
$url=Url::to(['erp-persons-in-position/populate-names']);            
$script = <<< JS

 $(function () {
    //Initialize Select2 Elements
    $(".Select2").select2();
    //$(".select3").select2();
 });

$('#recipients-select').on('select2:select', function (e) {
    var ids=$(this).val();
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
    // $('#recipients-names').empty();
    $.each(array, function(i,e){
    $("#recipients-names option[value='" + e + "']").prop("selected", true);
    console.log(e);
   
});

//trigger change-------------otherwise not updating
$('#recipients-names').trigger('change.select2');
    });
});

$('#recipients-select').on('select2:unselect', function (e) {
  
  var ids=$(this).val();
  if(!jQuery.isEmptyObject(ids)){
  
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
     $('#recipients-names').val([]);
    $.each(array, function(i,e){
    $("#recipients-names option[value='" + e + "']").prop("selected", true);
    console.log(e);
});


//trigger change-------------otherwise not updating
$('#recipients-names').trigger('change.select2');

});

}else{ $('#recipients-names').val([]);$('#recipients-names').trigger('change.select2');}


    
});



$('.submit').on('click', function(event) {
    
  if($('#recipients-names').val()==''){
      
      swal({
        title: "No Recipient(s) Selected?",
        text: "The document will be shared to who you report to !",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Share ",
        closeOnConfirm: false
    }, function () {
    
       
      $('#dynamic-form').submit();
    });
    
    return false;
  }
 
    
});


JS;
$this->registerJs($script);
?>