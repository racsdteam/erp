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
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */
$this->title = 'Travel Clearance';
$this->params['breadcrumbs'][] = $this->title;

$modeltravel= new ErpTravelClearance();
$user=Yii::$app->user->identity->user_id;
$is_creator=$model->created_by==$user;
$can_edit=$model->status=='drafting' || $model->status=='rfa';
$is_drafting=$model->status=='drafting';


?>

<style>


#parent_div_1,.box-action{
    width:100%;
    /*height:120px;*/
    border:1px solid grey;
    border-radius:10px;
    border-style:dotted;
    /*margin-left:10px;*/
    margin-bottom:15px;
}
.child_div_1,child_div_2{
    position:relative;
    top:10px;
    left:10px;
}
.child_div_2{
    position:relative;
    top:-60px;
    left:70px;
    width:700px;
}

.child_div_3{
    position:relative;
    top:-90px;
    left:780px;
    
}

.rfa{
    width:50%;
    height:auto;
    /*background:yellow;*/
}

/*----------------------kv buttons-------------------------------------*/
.kv-action-delete{
display:none;

}

 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 
  
.add-action{
    
    padding:10px;
} 
p.add-action{
   
  padding:15px; 
}

</style>

<?php



 $q=" SELECT c.categ as memo_type FROM erp_memo_categ as c
 inner join erp_memo  as m  on c.id=m.type  
 where m.id='".$model->id."' ";
     $com = Yii::$app->db->createCommand($q);
     $row = $com->queryOne();

//-------------------------------------------------travel c creator    
     
$q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where pp.person_id='".$model->created_by."' ";

$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 

//------------------------------------------tc employee---------------------------------------------------------
$q99=" SELECT p.position,u.first_name,u.last_name  FROM  user as u  
  inner join erp_persons_in_position as pp  on pp.person_id=u.user_id
 inner join erp_org_positions as p  on p.id=pp.position_id
 where u.user_id='".$model->employee."'";
 $com99 = Yii::$app->db->createCommand($q99);
 $row99 = $com99->queryOne();



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
                                                    
                                               
                                            'label'=>'Tc Code',
                                            'format'=>'raw',
                                            'value'=>'<kbd>'.$model->tc_code.'</kbd>',
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],
                                        
                                          [
                                                        
                                                   
                                            'label'=>'Name',
                                            'value'=>$row99['first_name']." ".$row99['last_name'],
                                             'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],

                                        [
                                                        
                                                   
                                            'label'=>'Title',
                                            'value'=>$row99['position'],
                                             'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],
                                       
                                           /* [
                                                
                                                'label'=>'Memo For',
                                                'format'=>'raw',
                                                'value'=>'<small style="padding:10px ;border-radius:13px;" class="bg-orange">'.$row['memo_type'].'</small>',
                                                'displayOnly'=>true,
                                                'valueColOptions'=>['style'=>'width:100%']
                                    
                                            ],*/
                                          
                                      
                                        [
                                                        
                                                   
                                            'label'=>'Destination',
                                            'value'=>$model->Destination,
                                             'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],
                                         
                                      
[
                                                
                                                'label'=>'Reason',
                                                'format'=>'raw',
                                                'value'=>'<small style="padding:10px ;border-radius:13px;" class="bg-orange">'.$model->reason.'</small>',
                                                'displayOnly'=>true,
                                                'valueColOptions'=>['style'=>'width:100%']
                                    
                                            ],
                                             [
                                                   
                                                   
                                            'label'=>'Departure Date',
                                            'value'=>$model->departure_date,
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],
                                             [
                                                   
                                                   
                                            'label'=>'Return Date',
                                            'value'=>$model->return_date,
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],
                                             [
                                                   
                                                   
                                            'label'=>'Travel Expenses',
                                            'value'=>$model->travel_expenses,
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],
                                             [
                                                   
                                                   
                                            'label'=>'Flight',
                                            'value'=>$model->flight,
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],
                                        
                                        [
                                                   
                                                   
                                            'label'=>'Created',
                                            'value'=>$model->created_at,
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
                                            'value'=>'<small style="padding:10px;border-radius:13px;" class="'.$label_class.'">'.$model->status.'</small>',
                                            //'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],

                                       
                            
                                
                                     
                                      
                                      
                                      
                                                ];
                                     

?>



<div class="well row clearfix">

    <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
        
          
    <div class="box box-default color-palette-box">
               
           <div class="box-body">
               
   

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
  
         


         
         
         <div class="box-group" id="accordion0">
          

           <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion0" href="#collapseThree">
                      <i class="fa fa-paper-plane"></i> Travel Clearance Details 
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse in">
                    <div class="box-body">


         <?php 
 $button1 = Html::a('<i class="glyphicon glyphicon-pencil"></i>', Url::to(['actualizar', 'id' => $model->id]), [
    'title' => 'Actualizar',
    'class' => 'pull-right detail-button',
]);
 
 ?> 

                  
           <?= DetailView::widget([
    'model'=>$model,
    'condensed'=>false,
    'hideIfEmpty'=>false,
    'hover'=>true,
    'striped' =>true,
    
    'responsive' =>true,
    'mode'=>DetailView::MODE_VIEW,
    'panel' => [
                       'heading' => '&nbsp',
                       'type' => DetailView::TYPE_DEFAULT,
                       'headingOptions' => [
                          //'template' => " $button1  {title}"
                       ]
                   ],
                    'template' => '{view}',
    'attributes'=>$attributes,
    
       
])?>
                    </div>
                    </div>
                    </div>
                    
 
 
  <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion0" href="#collapseThree11">
                      <i class="fa  fa-money"></i> ClaimForm Details  
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree11" class="panel-collapse collapse">
                    <div class="box-body">

 
                  

<p class="add-action">

<?=Html::a('<i class="fa fa-plus-square"></i> <span>New ClaimeForm</span>',
                                              Url::to(["erp-requisition/create",'id'=>$model->id
                                           ])
                                          ,['class'=>'btn-success btn-sm active add-action','title'=>'Add New Requisition'] ); ?>

</p>
   
   
     
       
       <?php 
       $q50 = new Query;
$q50	->select([
    'r.*','t.type as req_for'
    
])->from('erp_requisition as r')->join('INNER JOIN', 'erp_requisition_type as t',
't.id=r.type')->where(['reference_memo' =>$model->id])	;

$command50 = $q50->createCommand();
$rows50= $command50->queryAll(); 
       
       ?>
<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       
                                        <th>Requisition Code</th>
                                        <th>Title</th>
                                        <th>Requisition For</th>
                                        <th>Requested</th>
                                        <th>Requested by</th>
                                        <th>Approve Status</th>
                                        <th>Tender On Proc Plan</th>
                                         <th>View</th>
                                        <th>Update</th>
                                        <th>Delete</th>
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                     
                                  <?php foreach($rows50 as $row5):?>
                                   
                                   
                                     <tr  class="<?php if($row5['is_new']==1){echo 'new';}else{echo 'read';}  ?>">
                                     <td>
                                     <?= Html::a('<i class="fa fa-file"></i>'." ".$row5["requisition_code"],Url::to(['erp-requisition/view','id'=>$row5["id"]]), ['class'=>'kv-author-linkx']) ?>
                                     
                                   
                 
                                     </td>
                                           
                                          

                                             <td><?php echo $row5["title"] ; ?></td>
                                            <td><?php 
                                         
                                       echo  '<small style="padding:10px;border-radius:13px;" class="label pull-left bg-green">'.$row5["req_for"].'</small>';
                                         
                                          ?>
                                        
                                        </td>
                                          
                                        <td><?php echo $row5["requested_at"]; ?></td>
                                            
                                            
                                            <td><?php 
                                              $q7=" SELECT * FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                            where pp.person_id='".$row5['requested_by']."' ";
                                            $command7= Yii::$app->db->createCommand($q7);
                                            $row7 = $command7->queryOne(); 
                                            
                                            
                                            $user0=User::find()->where(['user_id'=>$row5['requested_by']])->One();
                                            if($user0!=null){
                                               echo $user0->first_name." ".$user0->last_name."[".$row7['position']."]";  
                                            }else{
                                                
                                                echo $row7['position'];
                                            }
                                            
                                            
                                            
                                            
                                            
                                            ?>
                                        
                                        
                                         <td><?php echo $row5["approve_status"] ; ?></td>
                                         
                                          <td><?php if($row5["is_tender_on_proc_plan"]=="1"){ 
                                              echo  '<small style="padding:10px;border-radius:13px;" class="label pull-left bg-green">'.'Yes'.'</small>';
                                          }else{ echo  '<small style="padding:10px;border-radius:13px;" class="label pull-left bg-pink">'.'No'.'</small>';}  ; ?></td>
                                        
                                        </td>
                                           
                                            
                                           <td> 
                                                 <?=Html::a('<i class="fa fa-eye"></i>',
                                              Url::to(["erp-requisition/view-pdf",'id'=>$row5['id'],'doc'=>$model->id
                                           ])
                                          ,['class'=>'btn-info btn-sm active kv-author-link','title'=>'View Requisition Info' ] ); ?> </td>

                                             <td> 
                                                 <?=Html::a('<i class="fa fa-edit"></i>',
                                             Url::to(["erp-requisition/update",'id'=>$row5['id'],
                                           ])
                                          ,['class'=>'btn-success btn-sm active action-update','title'=>'Update Requisition Info' ] ); ?> </td>
                                            <td> 
                                                 <?=Html::a('<i class="fa fa-remove"></i>',
                                             Url::to(["erp-requisition/delete",'id'=>$row5['id']
                                           ])
                                          ,['class'=>'btn-danger btn-sm active action-delete','title'=>'Delete Requisition Info'] ); ?> </td>
                                          
                                     
                                           
                                            
                                        </tr>
                                    
                                    <?php endforeach;?>
                                    
                                    
                                        


                                    </tbody>
                                </table>
 </div>


                    </div>
                    </div>
                    </div>
 

          


                </div> <!--box body   --> 

                      
                     
                      </div><!-- end col wraper  -->  
            </div><!-- end row wraper  -->
          
            </div>
            </div>

 <!--modal -->           
 <div class="modal modal-info" id="modal-action">
          <div class="modal-dialog  modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
              <div  id="modalContent"> <div style="text-align:center"><img src="<?=Yii::$app->request->baseUrl?>/img/m-loader.gif"></div></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

<?php
$url=Url::to(['erp-persons-in-position/populate-names']);  
$url2=Url::to(['update','id'=>$model->id,'flow'=>$flow]);
$url3=Url::to(['erp-memo/view-pdf','id'=>$model->id]); 
$url4=Url::to(['erp-memo/view-pdf','id'=>$model->id]); 
$script = <<< JS

$(function() {
   
   $('input:radio[name="ErpMemo[action]"]').each(function () { $(this).prop('checked', false); });
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
       
  
  //--------------------------------------------------view-----------------------------------------
    
 
  
    $('.kv-action-view').click(function () {



//var url = $(this).attr('href'); 
 
$('#modal-action').modal('show')
   .find('.modal-body')
   .load('{$url4}');
   
  $('#modal-action .modal-title').text($(this).attr('title'));
return false;
                      
// $('#select-person-type-modal.in').modal('hide') 
       });
  
  
    $('.kv-action-update').click(function () {

    window.location.href='$url2';

       });
       
//----------------------------------------------------------------------------print ---------------------------------------


 $('.kv-action-print').click(function () {

 
$('#modal-action').modal('show')
   .find('.modal-body')
   .load('{$url3}');
   
  $('#modal-action .modal-title').text($(this).attr('title'));
return false;
                      
// $('#select-person-type-modal.in').modal('hide') 
       });
       
       
//---------------------------------------------------------------------save----------------------------------------------------------------       
       
   $('.kv-action-save').click(function () {



//var url = $(this).attr('href'); 
 
$('#modal-action').modal('show')
   .find('.modal-body')
   .load('{$url3}');
   
  $('#modal-action .modal-title').text($(this).attr('title'));
return false;
                      
// $('#select-person-type-modal.in').modal('hide') 
       });     
       
 
  
  $('.kv-author-link').click(function () {

var url = $(this).attr('href'); 
 
$('#modal-action').modal('show')
   .find('.modal-body')
   .load(url);
   
  $('#modal-action .modal-title').text($(this).attr('title'));
return false;
                      
// $('#select-person-type-modal.in').modal('hide') 
       });
    


//-----------------------------create ----------------------------------------

$('.action-create').click(function () {



var url = $(this).attr('href'); 
 
$('#modal-action').modal('show')
   .find('.modal-body')
   .load(url);
   
  $('#modal-action .modal-title').text($(this).attr('title'));
return false;
                      
// $('#select-person-type-modal.in').modal('hide') 
       });


 $('#modal-action').on('hidden.bs.modal', function () {
        // remove the bs.modal data attribute from it
        //$(this).removeData('bs.modal');
        // and empty the modal-content element
       $('#modal-action .modal-body').empty();
       $('#modal-action .modal-body').html('<div style="text-align:center"><img src="/erp/img/m-loader.gif"></div>'); 
    });

//---------------------------------------------------------------------------------

$('div.a').hide();

$(' input[type=radio][name="ErpMemo[action]"]').on('change', function() {

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

//------------------------------------update doc link-------------------------------------------



JS;
$this->registerJs($script);

?>
