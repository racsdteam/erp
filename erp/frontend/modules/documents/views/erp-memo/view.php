<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;

use yii\db\Query;
use kartik\detail\DetailView;
use common\models\ErpMemoAttachMerge;
use common\models\ErpMemoRequestForAction;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpTravelClearance;
use common\models\ErpMemoApproval;

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */
$this->title = 'Memo Review';
$this->params['breadcrumbs'][] = $this->title;


?>

<style>


 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 
  
.add-action{
    
    padding:10px;
} 
p.add-action{
   
  padding:15px; 
}

.myDiv{
	display:none;
}
</style>

<?php



$user=Yii::$app->user->identity->user_id;
$is_creator=$model->created_by==$user;
$can_edit=$model->status=='drafting' || $model->status=='rfa';
$is_drafting=$model->status=='drafting';



 $q=" SELECT m.*, c.categ as memo_type FROM erp_memo_categ as c
 inner join erp_memo  as m  on c.id=m.type  
 where m.id='".$model->id."' ";
     $com = Yii::$app->db->createCommand($q);
     $row = $com->queryOne();
    
     
     
     
$q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where pp.person_id='".$model->created_by."' ";

$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 

$label_class='label pull-left';

if($model->status=='drafting'){
    $label_class.=" ".'bg-pink';

}
            
elseif($model->status=='processing'){
    $label_class.=" ".'bg-orange';

}else if($model->status=='denied'){
    $label_class.=" ".'bg-red';

}else{
    $label_class.=" ".'bg-green';

}
                                    
                                     $attributes = [
   

                                        [
                                                    
                                               
                                            'label'=>'Memo Code',
                                            'format'=>'raw',
                                            'value'=>'<kbd>'.$row['memo_code'].'</kbd>',
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],

                                        [
                                                        
                                                   
                                            'label'=>'Memo Title',
                                            'value'=>$row['title'],
                                             'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],
                                       
                                            [
                                                
                                                'label'=>'Memo For',
                                                'format'=>'raw',
                                                'value'=>'<small style="padding:10px ;border-radius:13px;" class="bg-orange">'.$row['memo_type'].'</small>',
                                                'displayOnly'=>true,
                                                'valueColOptions'=>['style'=>'width:100%']
                                    
                                            ],
                                          
                                      
                                       
                                        [
                                            'attribute'=>'description',
                                            'format'=>'raw',
                                            'value'=>'<span class="text-justify"><em>' .$row['description'] . '</em></span>',
                                            'type'=>DetailView::INPUT_TEXTAREA, 
                                            'options'=>['rows'=>6],
                                          
                                        ],

                                        
                                        [
                                                   
                                                   
                                            'label'=>'Created',
                                            'value'=>$row['created_at'],
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],

                                        [
                                                   
                                                   
                                            'label'=>'Created By',
                                            'value'=>$row7['first_name']." ".$row7['last_name']." [".$row7['position']." ]",
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],

                                        [
                                                    
                                               
                                            'label'=>'Status',
                                            'format'=>'raw',
                                            'value'=>'<small style="padding:10px;border-radius:13px;" class="'.$label_class.'">'.$row['status'].'</small>',
                                            //'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],

                                       
                            
                                
                                     
                                      
                                      
                                      
                                                ];
                                     

?>



<div class="well row clearfix">

    <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
        
    
               
   

   <?php if (Yii::$app->session->hasFlash('success')){

$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  

   }
  

  
  ?>
  
  <?php if (Yii::$app->session->hasFlash('failure')): ?>
 
<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
                <?php  echo Yii::$app->session->getFlash('failure')  ?>
              </div>


        <?php endif; ?>
  
         
<div class="col-xs-12">
          <div class="box box-solid ">
            <div class="box-header with-border">
              <h3 class="box-title fa"> <i class="fa fa-file-text-o"></i> Memo Details</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
             
            </div> <!-- end header-->
          
            <div class="box-body">
                
                  
           <?= DetailView::widget([
    'model'=>$model,
    'condensed'=>false,
    'hideIfEmpty'=>false,
    'hover'=>false,
    'striped' => false,
    
    'responsive' =>true,
    'mode'=>DetailView::MODE_VIEW,
  
    'attributes'=>$attributes,
    
       
])?>
                </div>

                 </div>
         </div>


   <div class="col-xs-12">
           <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title fa"> <i class="fa fa-folder-open-o"></i> Memo Supporting Document(s) </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <div class="box-body">
           
           <p style="padding:10px 0">
               
             <?=Html::a('<i class="fa fa-plus-square"></i> <span>Upload New  Document(s)</span>',
                                              Url::to(["erp-memo-supporting-doc/create",'memo'=>$model->id
                                           ])
                                          ,['class'=>'btn-success btn-sm active action-create','title'=>'Add Supporting Doc(s)'] ); ?>  
               
           </p>     
      
                
            <?php     $q = new Query;
                                               $q->select([
                                                   'support_doc.*',
                                                   
                                               ])->from('erp_memo_supporting_doc as support_doc ')->where(['memo' =>$model->id]);
                                   
                                               $command0 = $q->createCommand();
                                               $rows1= $command0->queryAll();
                                               $i=0;
                                               
                                               
                                               ?>
                                               

<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       
                                        <th>#</th>
                                        <th>Document Title</th>
                                        <th>Document Name</th>
                                        <th>Uploaded</th>
                                         <th>Uploaded By</th>
                                      
                                      
                                       <th>View</th>
                                       
                                        <th>Delete</th>
                                        
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                     
                                  <?php foreach($rows1 as $row5):?>
                                   <?php $i++;?>
                                   
                                     <tr>
                                     <td>
                                     <?php echo $i ; ?>
                 
                                     </td>
                                           
                                            <td><?php 
                                            
                                    echo '<small style="padding:5px ;border-radius:5px;" class="bg-grey">'.  $row5["title"] .'</small>';  ?></td>

                                             <td><?php 
                                             
                                             
                                             
                                             echo '<small style="padding:5px ;border-radius:5px;" class="bg-grey">'.  $row5["doc_name"] .'</small>';
                                             
                                            ?></td>
                                            
                                          
                                        <td><?php echo $row5["uploaded"]; ?></td>
                                          <td><?php 
                                          
                                          
                                          $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id
                                           where pp.person_id='".$row5['uploaded_by']."' ";
                                           $command7= Yii::$app->db->createCommand($q7);
                                             $row7 = $command7->queryOne();
                                            
                                          
                                          echo $row7["first_name"]." ".$row7['last_name']." [".$row7['position']."]"; ?></td>
                                           
                                           
                                            
                                             <td> 
                                                 <?=Html::a('<i class="fa fa-eye"></i>',
                                             Url::to(["erp-memo-supporting-doc/view",'id'=>$row5['id']
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-view-doc','title'=>'View Attachment Info' ] ); ?> </td>

                                          
                                            <td> 
                                                 <?=Html::a('<i class="fa fa-remove"></i>',
                                             Url::to(["erp-memo-supporting-doc/delete",'id'=>$row5['id']
                                           ])
                                          ,['class'=>'btn-danger btn-sm active action-delete-doc','title'=>'Delete Attachment Info','disabled'=>!($is_creator && $is_drafting)] ); ?> </td>
                                          
                                        
                                           
                                            
                                        </tr>
                                    
                                    <?php endforeach;?>
                                    
                                    
                                        


                                    </tbody>
                                </table>
 </div>

                
                </div>

                 </div>
         </div>        


<div class="col-xs-12">
           <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title fa"> <i class="fa fa-folder-open-o"></i> Work Flow Action(s) </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <div class="box-body">
          
         <?php 
         
       $model1=new  ErpMemoApproval(); 
                 // $items=['1'=>'Request for Action','2'=>'Forward','3'=>'Approve','4'=>'Reject'];
                  
                  //echo $form->field($model, 'action')->radioList($items,['class'=>'radios']);?>
                  
     <!--           not working in modal                            -->            
     <?php // $form->field($model, 'action',[
                    //'template' => "{label}\n<div class='col-md-12 radio'>{input}</div>\n{hint}\n{error}",
                    //'labelOptions' => [ 'class' => '' ]])->radio(['label' => 'Request for Correction', 'value' => 1, 'uncheckValue' => null]) ?>
      <? php //$form->field($model, 'action',[
                    //'template' => "{label}\n<div class='col-md-12 radio'>{input}</div>\n{hint}\n{error}",
                   // 'labelOptions' => [ 'class' => '' ]])->radio(['label' => 'Forward', 'value' => 2, 'uncheckValue' => null]) ?>
       <?php // $form->field($model, 'action',[
                    //'template' => "{label}\n<div class='col-md-12  radio'>{input}</div>\n{hint}\n{error}",
                    //'labelOptions' => [ 'class' => '' ]])->radio(['label' => 'Approve', 'value' => 3, 'uncheckValue' => null]) ?>
       <?php
    $form = ActiveForm::begin();

?>
         
      <?=  $form->field($model1, 'action',[
                    'template' => "{label}\n<div class='col-md-12'>{input}</div>\n{hint}\n{error}",
                    'labelOptions' => [ 'class' => '' ]])->radio(['label' => 'Confirm & Forward', 'value' => 2, 'uncheckValue' => null]) ?>
  <?php
   ActiveForm::end();

 ?>     
                   
<!--  --------------------------forward------------------------------------------------------>

    <div id="form2" class="myDiv">
	<h3>Select Recipient(s)</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form2', 
         'action' => ['erp-memo-approval/work-flow'],
        'method' => 'post'
       ]);

?>

     
     
  <?= $form->field($model1, 'position')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
    'options' => ['placeholder' => 'Select Employee(s) ...','id'=>'employees-select'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Employee(s) Position')?>                
                    
                    <?= $form->field($model1, 'employee')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(User::find()->all(), 'user_id', function($user){

      return $user->first_name." ".$user->last_name;
  })],
    'options' => ['placeholder' => 'Employee(s) Names...','id'=>'employees-names'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Employee(s) Names')?> 

<?= $form->field($model1, 'remark')->textarea(['rows' => '6']) ?>

  <?= $form->field($model1, 'memo_id')->hiddenInput(['value'=>$model->id])->label(false);?>
<?= $form->field($model1, 'action')->hiddenInput(['value'=>'cforward'])->label(false);?>

<?= Html::submitButton('<i class="glyphicon glyphicon-send"></i> forward ', ['class' => 'btn btn-primary ']) ?>	
<?php
   ActiveForm::end();

 ?>
</div> 
                
                </div>

                 </div>
         </div> 

               
            </div><!-- end row wraper  -->
          
            </div>

 

<?php
$url=Url::to(['erp-persons-in-position/populate-names']);  
$url2=Url::to(['update','id'=>$model->id,'flow'=>$flow]);
$url3=Url::to(['erp-memo/view-pdf','id'=>$model->id]); 
$url4=Url::to(['erp-memo/view-pdf','id'=>$model->id]); 
$script = <<< JS

$(document).ready(function(){
    
    $('input:radio[name="ErpMemoApproval[action]"]').each(function () { $(this).prop('checked', false); });
    
    $('input[type="radio"]').click(function(){
    	var value = $(this).val(); 
        $("div.myDiv").hide();
        $("#form"+value).show();
    });
}); 


$(function() {
   
   $('input:radio[name="ErpMemoApproval[action]"]').each(function () { $(this).prop('checked', false); });
});

//-----------------------------------------------adding requisition----------------------------------
  $('.add-action').click(function () {



var url = $(this).attr('href'); 
 
$('#modal-action').modal('show')
   .find('.modal-body')
   .load(url);
 $('#modal-action .modal-title').text($(this).attr('title'));
return false;
                      

       });
  
  
  //-------------------------view support doc------------------------------------------------------------
  $('.action-view-doc').click(function () {



var url = $(this).attr('href'); 
 
$('#modal-action').modal('show')
   .find('.modal-body')
   .load(url);
 $('#modal-action .modal-title').text($(this).attr('title'));
return false;
                      

       });
//--------------------------------------------updating supporting doc---------------------------------------------

  $('.action-delete-doc').on('click',function () {


var disabled=$(this).attr('disabled');



if(disabled){
    
swal("You are not allowed to delete  this document!", "", "error");
return false;
}else{
    
var url=$(this).attr('href');
  
    swal({
        title: "Are you sure?",
        text: "You want to delete this document",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Delete ",
        closeOnConfirm: false
    }, function () {
        
      
// make post to yii2--delete----if not u get error action 

$.post(url, function(data, status){
    
   if(data){
        swal("Document Deleted !", "", "success");
        location.reload();
   }else{
       
       swal("Unable to delete document !", "", "error");
   }
    
  });
        
    });
  
  
 

}



return false;
  });
     
 
 //----------------------------update--------------------------------------------
 
 $('.action-update').on('click',function () {


var disabled=$(this).attr('disabled');



if(disabled){
    
swal("You are not allowed to update  this item!", "", "error");
return false;
}else{
    
var url=$(this).attr('href');
  
 $('#modal-action').modal('show')
   .find('.modal-body')
   .load(url);
   
  $('#modal-action .modal-title').text($(this).attr('title'));

 

}



return false;
  });
     
       
 //---------------------------------------delete item-------------------------------------------------------      
   
    $('.action-delete').on('click',function () {


var disabled=$(this).attr('disabled');

if(disabled){
    
swal("You are not allowed to delete  this item!", "", "error");
return false;
}else{
    
var url=$(this).attr('href');
  
    swal({
        title: "Are you sure?",
        text: "You want to delete this item",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Delete ",
        closeOnConfirm: false
    }, function () {
        
       flag=true;
console.log(flag);
// make post to yii2--delete----if not u get error action 

$.post(url, function(data, status){
    
   if(data){
        swal("Deleted !", "", "success");
        location.reload();
   }else{
       
       swal("Unable to delete !", "", "error");
   }
    
  });
        
    });
  
  
 

}



return false;
  });      
       
  
      



$('#employees-select').on('select2:select', function (e) {
    var ids=$(this).val();
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
    // $('#employees-names').empty();
    $.each(array, function(i,e){
    $("#employees-names option[value='" + e + "']").prop("selected", true);
    console.log(e);
   
});

//trigger change-------------otherwise not updating
$('#employees-names').trigger('change.select2');
    });
});

$('#employees-select').on('select2:unselect', function (e) {
  
  var ids=$(this).val();
  if(!jQuery.isEmptyObject(ids)){
  
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
     $('#employees-names').val([]);
    $.each(array, function(i,e){
    $("#employees-names option[value='" + e + "']").prop("selected", true);
    console.log(e);
});


//trigger change-------------otherwise not updating
$('#employees-names').trigger('change.select2');

});

}else{ $('#employees-names').val([]);$('#employees-names').trigger('change.select2');}

});

//------------------------------------update doc link-------------------------------------------



JS;
$this->registerJs($script);

?>
