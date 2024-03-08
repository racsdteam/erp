<?php
use yii\helpers\Url;

use yii\helpers\Html;

use common\models\User;

use yii\db\Query;
use kartik\detail\DetailView;

use common\models\ErpDocumentRequestForAction;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use yii\widgets\ActiveForm;
/*
use frontend\assets\PdfTronAsset;
PdfTronAsset::register($this);
use frontend\assets\PdfTronAsset2;
PdfTronAsset2::register($this);*/
use frontend\assets\PdfTronViewerAsset;
PdfTronViewerAsset::register($this);
?>

<style>

.row{
    
   background:#525659; 
    
}   
#ErpRequisition-action label{
  margin-left:15px;
  padding:10px;
  color:black;
} 

#ErpRequisition-action label input{
  margin-left:15px;
  padding:10px;
  color:black;
} 
    
</style>


      
        <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul style="background:white;" class="nav nav-tabs">
                <li><a href="#tab_1" data-toggle="tab">Memo</a></li>
                <li><a href="#tab_4" data-toggle="tab">Memo Supporting Document(s)</a></li>
               <li class="active"><a href="#tab_2" data-toggle="tab">Travel Clearance</a></li>
              
               <?php if($model->status=='processing'):?> 
              <li><a href="#tab_3" data-toggle="tab">Work Flow Action</a></li>
             <?php endif;?> 
            
              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
           
           <?php 

$ser_domain='https://rac.co.rw';
$base_url=Yii::$app->request->baseUrl;


             
?>     
                  <div class="tab-pane" id="tab_1">
                 <?php
                 
                 
     $q1=" SELECT m.*  FROM erp_memo as m
 inner join erp_travel_clearance as t  on t.memo=m.id  
    where m.id=".$model->memo." and m.status='approved' ";
     $com1 = Yii::$app->db->createCommand($q1);
     $row1 = $com1->queryone();
      
      $url=Url::to(['erp-memo/view-pdf-modal','id'=>$row1['id']]);
             $full_path=$ser_domain.$url;
             $id=$row1['id'];
             $serverURL=Url::to(['erp-memo-annotations/annotations-handler']);
             echo $this->context->renderPartial('_viewer-partial', ['full_path'=>$full_path,'id'=>$id,'serverURL'=>$serverURL,'viewer_id'=>1]);                                         


?> 
              </div> 
              <div class="tab-pane active" id="tab_2">
                 <?php

             $url2=Url::to(['erp-travel-clearance/view-pdf-modal','id'=>$model->id]);
             $full_path2=$ser_domain.$url2;
             $id2=$model->id;
             $serverURL2=Url::to(['erp-travel-clearance-annotations/annotations-handler']);
             echo $this->context->renderPartial('_viewer-partial', ['full_path'=>$full_path2,'id'=>$id2,'serverURL'=>$serverURL2,'viewer_id'=>2]);

?> 
              </div>
                
             
              <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
               
               
 <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion0" href="#collapseThree2">
                      <i class="fa fa-gavel"></i> <span>About WorkFlow Actions</span>  
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree2" class="panel-collapse collapse in">
                    <div class="box-body">
              
           
          

<?php
    
   
    $form = ActiveForm::begin([
        'id'=>'action-form', 
    
       ]);

?> 


<div class="col-sm-12">
                  <?php 
                  $items=['a0'=>'Request for Action','a1'=>'Forward','a2'=>'Approve','a3'=>'Reject'];
                  
                  echo $form->field($model, 'action')->radioList($items,['class'=>'radio']);?>
                  
                  
</div>

<?php
   ActiveForm::end();

 ?> 
<!-- end form 1-->
<?php
    $form = ActiveForm::begin([
        'id'=>'search-party-form', 
         'action' => ['erp-travel-clearance/travel-clearance-request-action','id'=>$model->id],
        'method' => 'post'
       ]);

?> 
<div class="col-sm-12 a a0">
<input type="hidden" id="actionId" name="ErpTravelClearance[action]" value="a0">   
<input type="hidden" id="docId" name="ErpTravelClearance[id]" value="<?=$model->id?>">
<?= $form->field($model, 'recipients')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
    'options' => ['placeholder' => 'Select ...','id'=>'recipients-select0'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Next Approval')?>                
                    
                    <?= $form->field($model, 'recipients_names')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(User::find()->all(), 'user_id', function($user){

      return $user->first_name." ".$user->last_name;
  })],
    'options' => ['placeholder' => 'Select names ...','id'=>'recipients-names0'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Next Approval Name')?> 
<textarea name="ErpTravelClearance[remark]" value="<?= $model->remark ?>" class="form-control" rows="3" placeholder="Action description..."></textarea>
<?= Html::submitButton('<i class="fa  fa-mail-reply-all"></i> Go ', ['class' => 'btn btn-primary ']) ?>
<?php
   ActiveForm::end();

 ?> 
</div>

<div class="col-sm-12 a a1">

<?php
    $form = ActiveForm::begin([
        'id'=>'search-party-form', 
        'action' => ['erp-travel-clearance/approve-action','id'=>$model->id],
    
       'method' => 'post'
       ]);

?>


                <input type="hidden" id="actionId" name="ErpTravelClearance[action]" value="a1">   
<input type="hidden" id="requisitionId" name="ErpTravelClearance[id]" value="<?=$model->id?>">     
                    
                    <?= $form->field($model, 'recipients')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
    'options' => ['placeholder' => 'Select...','id'=>'recipients-select'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Next Approval')?>                
                    
                    <?= $form->field($model, 'recipients_names')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(User::find()->all(), 'user_id', function($user){

      return $user->first_name." ".$user->last_name;
  })],
    'options' => ['placeholder' => 'Select names ...','id'=>'recipients-names'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Next Approval Name')?> 

<textarea name="ErpTravelClearance[remark]" value="<?php $model->remark ?>" class="form-control" rows="3" placeholder="Remark..."></textarea>

<?= Html::submitButton('<i class="fa   fa-check-square-o "></i> Approve ', ['class' => 'btn btn-primary ']) ?>
<?php
   ActiveForm::end();

 ?> 
</div>









                     </div>

                     </div>

                     </div>
<!-- end of work flow actions  -->





         </div>
                <div class="tab-pane" id="tab_4">
               
               
                <?php
                
             $url4=Url::to(['erp-memo/view-pdf-supporting-docs','id'=>$row1['id']]);
             $full_path4=$ser_domain.$url4;
             $id4=0;
             $serverURL4=Url::to(['erp-requisition2-annotations/annotations-handler']);
             echo $this->context->renderPartial('_viewer-partial', ['full_path'=>$full_path4,'id'=>$id4,'serverURL'=>$serverURL4,'viewer_id'=>4]);

?> 
              </div> 
           
              </div>
            
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
         
            
              
  


           

  <!--commenting   --> 

  


              
          <?php
$url=Url::to(['erp-persons-in-position/populate-names']);            
$script = <<< JS

 $(function () {
    //Initialize Select2 Elements
    $(".Select2").select2();
    //$(".select3").select2();
 });
 
 $('div.a').hide();

$(' input[type=radio][name="ErpTravelClearance[action]"]').on('change', function() {

if($(this).is(':checked')){

  var val=$(this).val();
         
 //alert(val);

$('div.'+val).show();
$('div.a').not('div.' + val).hide(); 
//$('div.search-input').not('div.' + text).find('input:text').val('');

}


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

//-----------------------select0------------------------------------
$('#recipients-select0').on('select2:select', function (e) {
    var ids=$(this).val();
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
    // $('#recipients-names').empty();
    $.each(array, function(i,e){
    $("#recipients-names0 option[value='" + e + "']").prop("selected", true);
    console.log(e);
   
});




//trigger change-------------otherwise not updating
$('#recipients-names0').trigger('change.select2');
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

//----------------------------------------------------------------------------

$('#recipients-select0').on('select2:unselect', function (e) {
  
  var ids=$(this).val();
  if(!jQuery.isEmptyObject(ids)){
  
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
     $('#recipients-names0').val([]);
    $.each(array, function(i,e){
    $("#recipients-names0 option[value='" + e + "']").prop("selected", true);
    console.log(e);
});


//trigger change-------------otherwise not updating
$('#recipients-names0').trigger('change.select2');

});

}else{ $('#recipients-names0').val([]);$('#recipients-names0').trigger('change.select2');}


    
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
$this->registerJs($script,$this::POS_HEAD);
?>

