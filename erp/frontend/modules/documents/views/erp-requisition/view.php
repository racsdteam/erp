<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;

use yii\db\Query;
use kartik\detail\DetailView;
use common\models\ErpRequisitionAttachMerge;
use common\models\ErpRequisitionRequestForAction;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpRequisitionFlow;
use common\models\ErpRequisitionApproval;

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */
$this->title = 'Requisition Review';
$this->params['breadcrumbs'][] = $this->title;

?>


<style>

.myDiv{
	display:none;
} 

 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  }
  
  tr.sect,h3.sect { background-color:#3c8dbc !important;color:white;}
  
.add-action{
    
    padding:25px;
} 
p.add-action{
   
  padding:25px; 
}

</style>


<?php

 $q=" SELECT c.type as req_type FROM erp_requisition_type  as c
 inner join erp_requisition  as r  on c.id=r.type  
 where r.type='".$model->type."' ";
     $com = Yii::$app->db->createCommand($q);
     $row = $com->queryOne();
     //var_dump($row);
     
     
$q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where pp.person_id='".$model->requested_by."' ";

$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 

$label_class='label pull-left';

if($model->approve_status=='approved'){
    $label_class.=" ".'bg-green';

}
            
else{
    $label_class.=" ".'bg-pink';

}
                                    
                                     $attributes = [
   

                                        [
                                                    
                                               
                                            'label'=>'Requisition Code',
                                            'format'=>'raw',
                                            'value'=>'<kbd>'.$model->requisition_code.'</kbd>',
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],

                                        [
                                                        
                                                   
                                            'label'=>'Requisition Title',
                                            'value'=>$model->title,
                                             'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],
                                       
                                            [
                                                
                                                'label'=>'Requisition For',
                                                'format'=>'raw',
                                                'value'=>'<small style="padding:10px ;border-radius:13px;" class="bg-green">'.$row['req_type'].'</small>',
                                                'displayOnly'=>true,
                                                'valueColOptions'=>['style'=>'width:100%']
                                    
                                            ],
                                          
                                      
                                        [
                                                   
                                                   
                                            'label'=>'Requested',
                                            'value'=>$model->requested_at,
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],

                                        [
                                                   
                                                   
                                            'label'=>'Requested By',
                                            'value'=>$row7['first_name']." ".$row7['last_name']." [".$row7['position']." ]",
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],

                                        [
                                                    
                                               
                                            'label'=>'Approve Status',
                                            'format'=>'raw',
                                            'value'=>'<small style="padding:10px;border-radius:13px;" class="'.$label_class.'">'.$model->approve_status.'</small>',
                                            //'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],

                                       
                            
                                
                                     
                                      
                                      
                                      
                                                ];
                                     

?>



<div class="well row clearfix">

    <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
        
          
    <div class="box box-default color-palette-box">
  
   <div class="box-header with-border">
              <h3 class="box-title fa"> <i class="fa fa-file"></i> Requisition  Details</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
             
            </div> <!-- end header-->
          
            <div class="box-body">
  
           <?php if (Yii::$app->session->hasFlash('success')): ?>
  
           <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-thumbs-o-up"></i></h4>
                <?php  echo Yii::$app->session->getFlash('success')  ?>
              </div>

<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('failure')): ?>
 
 <div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                 <?php  echo Yii::$app->session->getFlash('failure')  ?>
               </div>
 
 
         <?php endif; ?> 
         
         

          

     

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
    'hover'=>false,
    'striped' => false,
    
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

                    

 
  <div class="box box-default collapsed-box">
               
                   <div class="box-header with-border">
              <h3 class="box-title fa"> <i class="fa fa-opencart"></i>About Requested Items</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
                    <div class="box-body">

                    
       
       
       <?php 
       $q50 = new Query;
$q50	->select([
    't.*'
    
])->from('erp_requisition_items as t')->where(['requisition_id' =>$model->id])	;

$command50 = $q50->createCommand();
$rows50= $command50->queryAll(); 
//var_dump($rows50);
$i=0;       
       ?>
<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       
                                        <th>#</th>
                                          <th>Designation</th>
                                        <th>Specs</th>
                                          <th>UoM(unit of measurement)</th>
                                             <th>Quantity</th>
                                             <th>Badget Code</th>
                                                <th>Unit Price</th>
                                                   <th>Total Price</th>
                                                   <th>UPDATE</th>
                                                   <th>DELETE</th>
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                     
                                  <?php foreach($rows50 as $row5):?>
                                   <?php $i++;  ?>
                                   
                                     <tr>
                                     <td>
                                     <?php echo   $i; ?>
                 
                                     </td>
                                         <td><?php echo $row5["designation"] ; ?></td>
                                          <td><?php echo $row5["specs"]; ?></td>
                                          <td><?php echo $row5["uom"]; ?></td>
                                          <td><?php echo $row5["quantity"]; ?></td>
                                          <td><?php echo $row5["badget_code"]; ?></td>
                                           <td><?php echo $row5["unit_price"]; ?></td>
                                            <td><?php echo $row5["total_amount"]; ?> <?= $model->currency_type ?></td>
                                          
                                             <td> 
                                                 <?=Html::a('<i class="fa fa-edit"></i>',
                                              Url::to(["erp-requisition-items/update",'id'=>$row5['id'],'req-id'=>$model->id,
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-update','title'=>'Update Requisition item Info' ] ); ?> </td>
                                            <td> 
                                                 <?=Html::a('<i class="fa fa-remove"></i>',
                                                Url::to(["erp-requisition-items/delete",'id'=>$row5['id']
                                           ])
                                          ,['class'=>'btn-danger btn-sm active action-delete','data-method' => 'POST','title'=>'Delete Requisition item Info'] ); ?> </td>
                                          
                                     
                                           
                                            
                                        </tr>
                                    
                                    <?php endforeach;?>
                                    
                                    
                                        


                                    </tbody>
                                </table>
 </div>
 
 



                    </div>
                    </div>
                    


  

    

          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title fa"> <i class="fa fa-paperclip"></i> Attachement(s)</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body box-body table-responsive no-padding">
                <p class="add-action">

<?=Html::a('<i class="fa fa-plus-square"></i> <span>Add Attachment</span>',
                                              Url::to(["erp-requisition-attachement/create",'tr_id'=>$model->id,'context'=>'view'
                                           ])
                                          ,['class'=>'btn-success btn-sm active action-create ','title'=>'Add New Attachment'] ); ?>
</p>
             
       
       <?php 
     $q52 = new Query;
$q52	->select([
    'att.*',
    
])->from('erp_requisition_attachement as att')->join( 'INNER JOIN', 
                'erp_requisition as r',
                'r.id =att.pr_id'
            )->where(['att.pr_id' =>$model->id])	;

$command52 = $q52->createCommand();
$rows52= $command52->queryAll();
$i=0;


       ?>

              

<table class="table table-hover">
                                    <thead>
                                        <tr>
                                       
                                      
                                       <th>#</th>
                                        <th>Name</th>
                                        <th>Creator </th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                        <th>Action</th>
                                        
                                        
                                       
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
    
                                     
                                  <?php foreach($rows52 as $row5):?>
                                   <?php $i++;  ?>
                                   
                                     <tr>
                                     
                                     
                                     <td>
                                     <?php echo $i; ?>
                 
                                     </td>
                                           
                                          

                                             <td><?php 
                                             
                                             $temp= explode(".",   $row5["attach_name"] );
   $ext = end($temp); 
                                         if(strtolower($ext) =='pdf'){
                                        echo '<i class="fa fa-fw fa-file-pdf-o margin-r-5"></i>'.$row5["attach_name"];
                                             
                                             
                                         }
                                         else if(strtolower($ext) =='jpg'){
                                         echo '<i class="fa fa-file-photo-o margin-r-5"></i>'.$row5["attach_name"];     
                                             
                                         }
                                         else if(strtolower($ext) =='png'){
                                           echo '<i class="fa fa-file-photo-o margin-r-5"></i>'.$row5["attach_name"];   
                                             
                                         }else{
                                          echo '<i class="fa fa-fw fa-file-pdf-o margin-r-5"></i>'.$row5["attach_name"];    
                                         }
                                         
                                         
                                         ?></td>
                            
                                          
                                           
                                            <td><?php 
                                            
                                              $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where pp.person_id='".$row5["created_by"]."' ";  
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne();
                                            
                                            echo $row7['first_name']."".$row7['last_name']."[".$row7['position']."]";
                                            ?>
                                        
                                        
                                        
                                        
                                        </td>
                                           
                                             <td><?php echo $row5["created"]; ?></td>
                                            
 <td> 
                                                 <?=Html::a('<i class="fa fa-eye"></i>',
                                              Url::to(["erp-requisition-attachement/view-pdf",'id'=>$row5['id'],'tr_id'=>$model->id
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-view','title'=>'View Attachment' ] ); ?> </td>
                                            
                                            <td> 
                                                 <?=Html::a('<i class="fa fa-trash"></i>',
                                              Url::to(["erp-requisition-attachement/delete",'id'=>$row5['id'],'tr_id'=>$model->id
                                           ])
                                          ,['class'=>'btn-danger btn-sm active delete-action','title'=>'Delete Attachemnt','data-can-delete'=>$model->approve_status=='drafting' ] ); ?> </td>
                                          
                                        
                                           
                                            
                                        </tr>
                                    
                                    <?php endforeach;?>
                                    
                                           
                                    
                                        


                                    </tbody>
                                </table>
           
            <!-- /.box-body -->
         
                    
       </div>
        </div>

<div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title fa"> <i class="fa fa-file-text"></i> Work Flow Action(s) </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
          
            <div class="box-body">
  
  <?php $model1= new ErpRequisitionApproval()  ?>    
            
<?php
    
   
    $form = ActiveForm::begin([
        'id'=>'action-form1', 
    'options' => [
	//	'class' => 'radio',
		
	],
       ]);

?> 

         
     
      <?= $form->field($model1, 'action',[
                'template' => "{label}\n<div class='col-md-12 radio'>{input}</div>\n{hint}\n{error}",
                   'labelOptions' => [ 'class' => '' ]])->radio(['label' => 'Request For Correction', 'value' => 1, 'uncheckValue' => null,'disabled'=>true]) ?>
       
        <?=  $form->field($model, 'action',[
                    'template' => "{label}\n<div class='col-md-12 radio'>{input}</div>\n{hint}\n{error}",
                    'labelOptions' => [ 'class' => '' ]])->radio(['label' => 'Forward', 'value' => 2, 'uncheckValue' => null, ]) ?>
       <?= $form->field($model, 'action',[
                    'template' => "{label}\n<div class='col-md-12 radio'>{input}</div>\n{hint}\n{error}",
                    'labelOptions' => [ 'class' => '' ]])->radio(['label' => 'Approve', 'value' => 3, 'uncheckValue' => null,'disabled'=>false]) ?>
       
                  

<?php
   ActiveForm::end();
                            
 ?>                  
                  
              <div id="form1" class="myDiv">
	<h3>Select Recipient(s)</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form1', 
         'action' => ['erp-requisition-approval/work-flow'],
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

 <?= $form->field($model1, 'tr_id')->hiddenInput(['value'=>$model->id])->label(false);?>
     <?= $form->field($model1, 'action')->hiddenInput(['value'=>'rfa'])->label(false);?>

<?= Html::submitButton('<i class="glyphicon glyphicon-send"></i> Send ', ['class' => 'btn btn-primary ']) ?>


<?php
   ActiveForm::end();

 ?>
</div>    
                        
                   
<!--  --------------------------forward------------------------------------------------------>

    <div id="form2" class="myDiv">
	<h3>Select Recipient(s)</h3>
	
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form2', 
         'action' => ['erp-requisition-approval/work-flow'],
        'method' => 'post'
       ]);

?>


  <?= $form->field($model1, 'position')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
    'options' => ['placeholder' => 'Select Employee(s) ...','id'=>'employees-select0'
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
    'options' => ['placeholder' => 'Employee(s) Names...','id'=>'employees-names0'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Employee(s) Names')?> 

<?= $form->field($model1, 'remark')->textarea(['rows' => '6']) ?>
  <?= $form->field($model1, 'pr_id')->hiddenInput(['value'=>$model->id])->label(false);?>
     <?= $form->field($model1, 'action')->hiddenInput(['value'=>'forward'])->label(false);?>
<?= Html::submitButton('<i class="glyphicon glyphicon-send"></i> forward ', ['class' => 'btn btn-primary ']) ?>	
<?php
   ActiveForm::end();

 ?>
</div>  

<!-- -----------------approve--------------------------------------->
<div id="form3" class="myDiv">
	<h3>Select Recipient(s)</h3>
	<?php
    $form = ActiveForm::begin([
        'id'=>'work-form3', 
         'action' => ['erp-requisition-approval/work-flow'],
        'method' => 'post'
       ]);

?>

  	<?= $form->field($model1, 'position')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
    'options' => ['placeholder' => 'Select Employee(s) ...','id'=>'employees-select1'
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
    'options' => ['placeholder' => 'Employee(s) Names...','id'=>'employees-names1'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label('Employee(s) Names')?> 
   <?= $form->field($model1, 'remark')->textarea(['rows' => '6']) ?>
 <?= $form->field($model1, 'pr_id')->hiddenInput(['value'=>$model->id])->label(false);?>
     <?= $form->field($model1, 'action')->hiddenInput(['value'=>'approve'])->label(false);?>
  

<?= Html::submitButton('<i class="glyphicon glyphicon-check"></i>Approve', ['class' => 'btn btn-primary ']) ?>
<?php
   ActiveForm::end();

 ?>
</div> 
          </div><!--end body -->
         
        </div> <!-- /.box solid --> 
         </div>
</div>

           

  <!--commenting   --> 

  


                </div> <!--box body   --> 

                      
                     
                      </div><!-- end col wraper  -->  
            </div><!-- end row wraper  -->
          

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
$url3=Url::to(['document-viewer','id'=>$model->id]); 
$url4=Url::to(['erp-document-attach-merge/view','id'=>$model->id]); 
$script = <<< JS

$(function() {
   
   $('input:radio[name="ErpRequisition[action]"]').each(function () { $(this).prop('checked', false); });
});

 $('input[type="radio"]').click(function(){
    	var value = $(this).val(); 
        $("div.myDiv").hide();
        $("#form"+value).show();
    });

 
    
  $('.action-delete').on('click',function () {


var disabled=$(this).attr('disabled');
var flag=false;
if(disabled){
    
swal("You are not allowed to delete this item!", "", "error");
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
 
 
  
  

//----------------------------selec0----------------------------------------------------------
 $('#employees-select0').on('select2:select', function (e) {
    var ids=$(this).val();
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
    // $('#employees-names').empty();
    $.each(array, function(i,e){
    $("#employees-names0 option[value='" + e + "']").prop("selected", true);
    console.log(e);
   
});

//trigger change-------------otherwise not updating
$('#employees-names0').trigger('change.select2');
    });
});

$('#employees-select0').on('select2:unselect', function (e) {
  
  var ids=$(this).val();
  if(!jQuery.isEmptyObject(ids)){
  
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
     $('#employees-names0').val([]);
    $.each(array, function(i,e){
    $("#employees-names0 option[value='" + e + "']").prop("selected", true);
    console.log(e);
});


//trigger change-------------otherwise not updating
$('#employees-names0').trigger('change.select2');

});

}else{ $('#employees-names0').val([]);$('#employees-names0').trigger('change.select2');}
   
});


//---------------------------------select1--------------------------------------------------
$('#employees-select1').on('select2:select', function (e) {
    var ids=$(this).val();
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
    // $('#employees-names').empty();
    $.each(array, function(i,e){
    $("#employees-names1 option[value='" + e + "']").prop("selected", true);
    console.log(e);
   
});

//trigger change-------------otherwise not updating
$('#employees-names1').trigger('change.select2');
    });
});

$('#employees-select1').on('select2:unselect', function (e) {
  
  var ids=$(this).val();
  if(!jQuery.isEmptyObject(ids)){
  
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
     $('#employees-names1').val([]);
    $.each(array, function(i,e){
    $("#employees-names1 option[value='" + e + "']").prop("selected", true);
    console.log(e);
});


//trigger change-------------otherwise not updating
$('#employees-names1').trigger('change.select2');

});

}else{ $('#employees-names1').val([]);$('#employees-names1').trigger('change.select2');}

});







JS;
$this->registerJs($script);

?>
