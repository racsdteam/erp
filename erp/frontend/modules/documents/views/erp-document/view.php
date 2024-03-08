<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;

use yii\db\Query;
use kartik\detail\DetailView;
use common\models\ErpDocumentAttachMerge;
use common\models\ErpDocumentRequestForAction;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpDocument;

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */
$this->title = 'Document Review';
$this->params['breadcrumbs'][] = $this->title;

?>

<style>


</style>

<?php

//================================doc type=================================================
$q1 = new Query;
                                     $q1->select([
                                         'doc_type.type'
                                         
                                     ])->from('erp_document_type as doc_type ')->where(['doc_type.id' =>$model->type])	;
                         
                                     $command1 = $q1->createCommand();
                                     $row1= $command1->queryOne();
$type_html='<small style="padding:10px;border-radius:13px;" class="label pull-left bg-green">'.'<i class="fa fa-file-pdf-o"></i>'."  ".$row1['type'].'</small>';
//==========================================doc version========================================

$q2 = new Query;
$q2->select([
    'rev.version_number'
    
])->from('erp_document_version as rev')->where(['rev.document' =>$model->id])->orderBy(['version_number' => SORT_DESC]);
$command2 = $q2->createCommand();
$rows2= $command2->queryAll();//$row2[0] lastest version



$status=$model->status;
 if( $status=='processing'){
                                                 
                                                 $label_class="label pull-left bg-pink";
                                             }else if($status=='closed'){
                                                  $label_class="label pull-left bg-red";
                                             }else if($status=='rfa'){
                                                  $label_class="label pull-left bg-orange";
                                                 
                                             }   
                                             else{$label_class="label pull-left bg-green";}
                                             
                                            
                                    
                                     $attributes = [
   

                                        [
                                                    
                                               
                                            'label'=>'Document Code',
                                            'format'=>'raw',
                                            'value'=>'<kbd>'.$model->doc_code.'</kbd>',
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],

                                        [
                                                        
                                                   
                                            'label'=>'Doc Title',
                                            'value'=>$model->doc_title,
                                            //'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],
                                       
                                            [
                                                
                                                'label'=>'Doc Type',
                                                'format'=>'raw',
                                                'value'=>Html::a($type_html,Url::to(['erp-document-attach-merge/view','id'=>$model->id]), ['class'=>'kv-author-link']),
                                              //  'displayOnly'=>true,
                                                'valueColOptions'=>['style'=>'width:100%']
                                    
                                            ],
                                          
                                      
                                       
                                        [
                                            'attribute'=>'doc_description',
                                            'format'=>'raw',
                                            'value'=>'<span class="text-justify"><em>' .$model->doc_description . '</em></span>',
                                            'type'=>DetailView::INPUT_TEXTAREA, 
                                            'options'=>['rows'=>4],
                                          
                                        ],

                                        
                                       /* [
                                                   
                                                   
                                            'label'=>'Sent',
                                            'value'=>$row3[0]['time_sent'],
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],*/

                                       /* [
                                                    
                                               
                                            'label'=>'Sent By',
                                            'format'=>'raw',
                                            'value'=>'<small style="padding:10px ;border-radius:13px;" class="bg-green">'.$user6->first_name." ".$user6->last_name." [".$row6['position']."]".'</small>',
                                            //'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],*/

                                        [
                                                    
                                               
                                            'label'=>'Status',
                                            'format'=>'raw',
                                            'value'=>'<small style="padding:10px;border-radius:13px;" class="'.$label_class.'">'.$status.'</small>',
                                            //'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],

                                        [
                                                   
                                                   
                                            'label'=>'Severity',
                                            'value'=>$model->severity,
                                           // 'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:30%']
                                        ],
                            
                                
                                     
                                      
                                      
                                      
                                                ];
                                     

?>



<div class="well row clearfix">

    <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
        
          
    <div class="box box-default color-palette-box">
               
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
         
         
         <div class="box-group" id="accordion0">
          

           <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion0" href="#collapseThree">
                      <i class="material-icons">folder_open</i><span>About Document</span>  
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
                    </div>
                    </div>
                    </div>
<!--  about attachemnts-->

           <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion0" href="#collapseThree1">
                      <i class="material-icons">folder_open</i><span>About Attachements</span>  
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree1" class="panel-collapse collapse in">
                    <div class="box-body">

                    <p style="padding:10px;">

<?php if ($model->status!='closed'): ?>

<?=Html::a('<i class="fa fa-plus-square"></i> <span>New Attachment</span>',
                                              Url::to(["erp-document-attachment/create",'id'=>$model->id
                                           ])
                                          ,['class'=>'btn-success btn-sm active action-create','title'=>'Add Attachament(s)'] ); ?>

</p>

<?php endif?> 
                    <?php 





//--------------------------------------------------all document attachements-------------------------------------------------
$q50 = new Query;
$q50	->select([
    'attach.*'
    
])->from('erp_document_attach_merge as attch_merge ')->join('INNER JOIN', 'erp_document_attachment as attach',
'attach.id=attch_merge.attachement')->where(['document' =>$model->id])	;

$command50 = $q50->createCommand();
$rows50= $command50->queryAll(); 



$i=0;      
                                               
?>
<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Attachement</th>
                                        <th>Attached</th>
                                        <th>Attached by</th>
                                      
                                       
                                        <th>Update</th>
                                        <th>Delete</th>
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                     
                                  <?php foreach($rows50 as $row5):?>
                                   <?php $i++;  ?>
                                   
                                     <tr>
                                     <td>
                                     <?php echo $i; ?>
                 
                                     </td>
                                           
                                          

                                             <td><?php echo $row5["attach_title"] ; ?></td>
                                            <td><?php 
                                           $user= Yii::$app->user->identity->user_id;
                                           
            //------------------------------------------------------att versions------------------------------------------
            
            $q5 = new Query;
                                            
                                           $q5 = new Query;
                                            $q5	->select([
                                                'vers.*'
                                                
                                            ])->from('erp_attachment_version as vers ')->where(['attachment' =>$row5['id']])->orderBy([
  'timestamp' => SORT_DESC,
  
]);
                                
                                            $command5 = $q5->createCommand();
                                            
                                            $row1= $command5->queryAll();
                                          
                                            
      //------------------------------------------------version upload-----------------------------------------                                      
                                            $q6 = new Query;
                                            $q6	->select([
                                                'attch_ver_upload.*'
                                                
                                            ])->from('erp_attachment_version_upload as attch_ver_upload ')->join('INNER JOIN', 'erp_attachment_version as attch_ver',
                                                'attch_ver.id=attch_ver_upload.attach_version')->where(['attch_ver_upload.attach_version' =>$row1[0]['id']]);
                                
                                            $command6 = $q6->createCommand();
                                            $row6= $command6->queryOne(); 
                                           
                                           if(!empty( $row6)){?>

                                         <a title="View Document" class="kv-author-link" href="<?=Url::to(['erp-document-attachment/view','id'=>$row5['id'],'attach'=>$row6['id']])?>">
                                            <?php echo '<i class="fa fa-fw fa-file-pdf-o"></i>'." ".$row6['file_name']    ?>
                                          
                                          
                                          </a> 
                                          
                                          <?php }?>
                                        
                                        </td>
                                          
                                        <td><?php echo $row5["timestamp"]; ?></td>
                                            <td><?php 
                                            
                                            $q7=" SELECT * FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                            where pp.person_id='".$row5['user']."' ";
                                            $command7= Yii::$app->db->createCommand($q7);
                                            $row7 = $command7->queryOne(); 
                                            
                                            $user0=User::find()->where(['user_id'=>$row7['person_id']])->One();
                                            if($user0!=null){
                                               echo $user0->first_name." ".$user0->last_name."[".$row7['position']."]";  
                                            }else{
                                                
                                                echo $row7['position'];
                                            }
                                            
                                            
                                            
                                            
                                            
                                            ?>
                                        
                                        
                                        
                                        
                                        </td>
                                           
                                            
                                            

                                             <td> 
                                             
                                             <?php 
                                             
                                             if( $user==$row5['user']&& $model->status=='rfa' ){
                                                 
                                                 $disabled=false;
                                             }else if($user==$row5['user']&& $model->status=='drafting'){
                                                 $disabled=false;
                                             }else{
                                                 $disabled=true;
                                             }
                                             
                                            
                                             
                                             ?>
                                                 <?=Html::a('<i class="fa fa-edit"></i>',
                                              Url::to(["erp-document-attachment/update",'id'=>$row5['id'],'doc'=>$model->id,'flow'=>$flow,
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-update1','title'=>'View Attachment Info','disabled'=>$disabled ] ); ?> </td>
                                            <td> 
                                                 <?=Html::a('<i class="fa fa-remove"></i>',
                                              Url::to(["erp-document-attachment/delete",'id'=>$row5['id'],'doc'=>$model->id,'flow'=>$flow
                                           ])
                                          ,['class'=>'btn-danger btn-sm active delete-action','title'=>'View Attachment Info','disabled'=>$disabled ] ); ?> </td>
                                          
                                        
                                           
                                            
                                        </tr>
                                    
                                    <?php endforeach;?>
                                    
                                    
                                        


                                    </tbody>
                                </table>
 </div>


                    </div>
                    </div>
                    </div>
<!--  end of about att-->


<?php if ($model->status!='closed'): ?>
 <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion0" href="#collapseThree2">
                      <i class="material-icons">folder_open</i><span>About WorkFlow Actions</span>  
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree2" class="panel-collapse collapse in">
                    <div class="box-body">
              
              
           <?php if(Yii::$app->user->identity->user_image!==''){
 $imageURL=Yii::$app->request->baseUrl . '/' ."img/avatar-user.png";

//$imageURL=Yii::$app->request->baseUrl . '/' .Yii::$app->user->identity->user_image;

                       } else{

                           $imageURL=Yii::$app->request->baseUrl . '/' ."img/avatar-user.png";

                       } ?>  
          
<!--center the design           -->

 










                     </div>

                     </div>

                     </div>
<!-- end of work flow actions  -->
<?php endif; ?>
<div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion0" href="#collapseThree4">
                      <i class="material-icons">comment</i><span>About Comment(s)</span>  
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree4" class="panel-collapse collapse in">
                    <div class="box-body">


  
  <div  class="row">
<div  class="col-sm-12">

 
        </div>

       
        <div class="col-sm-12">
        <?php   
        
        $query = new Query;
        $query	->select([
            'doc_com.*',
            
        ])->from('erp_document_remark as doc_com ')->where(['doc_com.document' =>$model->id])->orderBy([
                'timestamp' => SORT_DESC,
                
              ]);

        $command = $query->createCommand();
        $rows= $command->queryAll();
        
        

        ?>  
        
 <?php if(!empty($rows)) : ?> 
 
 <?php foreach($rows as $row):?>
  <?php 

$q7=" SELECT p.position FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
where pp.person_id='".$row['author']."' ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 


$dateValue = strtotime($row['timestamp']);                     
$yr = date("Y",$dateValue) ." "; 
$mon = date("M",$dateValue)." "; 
$date = date("d",$dateValue);   
$time=date("H:i A",$dateValue);

?>      
        <!-- The time line -->
          <ul class="timeline">
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-pink">
                    <?=$date?>  <?=$mon?>.  <?=$yr?>
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <li>

            <?php
            $user=User::find()->where(['user_id'=>$row['author']])->One();
            
            $baseurl=Yii::$app->request->baseUrl;
            
                $user_image=''; 
                $name='';
               
                if($user!=null) {
                    $user_image=$user->user_image; 
                    $name=$user->first_name." ".$user->last_name;
                }
                if($user_image!=''){
                    $user_image=$baseurl.'/'.$user_image; 
                   
                }else{$user_image= $baseurl.'/img/avatar-user.png';}
                
                ?>
           
            <img src="<?=$user_image ?>" class="img-circle" width="52" height="52" alt="User Image">

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <?=$time  ?></span>

                <h3 class="timeline-header"><a href="#"><?= $name." [".$row7['position']."]" ?></a> commented on the document!</h3>

                <div class="timeline-body">
                 <?=$row['remark']  ?>
                </div>
                <div class="timeline-footer">
                 
                </div>
              </div>
            </li>
            <!-- END timeline item -->
            
           
           
            <!-- END timeline item -->
            <li>
              <i class="fa fa-clock-o bg-gray"></i>
            </li>
          </ul>
            <?php endforeach; ?> 
          <?php endif; ?>  
        </div>
        <!-- /.col -->
        </div>

                       </div>

                          </div>

                             </div>




         </div>


           

  <!--commenting   --> 

  


                </div> <!--box body   --> 

                      
                     
                      </div><!-- end col wraper  -->  
            </div><!-- end row wraper  -->
          
            </div>



<?php
$url=Url::to(['erp-persons-in-position/populate-names']);  
$url2=Url::to(['update','id'=>$model->id,'flow'=>$flow]);
$url3=Url::to(['erp-document/pdf-viewer','id'=>$model->id]); 
$url4=Url::to(['erp-document/pdf-viewer','id'=>$model->id]); 
$script = <<< JS

$(function() {
    $(' input[type=radio][name="ErpDocument[action]"]').each(function () { $(this).attr('checked', false); });
});


$("input[name='status']").change(function() {
       
   var status;
       
        if($(this).is(":checked")) {
           
    var r = confirm("attachement will be include in the document!");
    if (r == true) {
      visible=1;
    } else {
        $(this).prop('checked',false);
    } 
        }else{

          var r = confirm("attachement will not be included in the document!");
    if (r == true) {
      visible=0;
    } else {
        $(this).prop('checked',true);
    }    

        }

     
     $.ajax({
        url:$(this).attr('data-url')+'&'+jQuery.param({ status:visible}),  //Server script to process data
      // url: \$form.attr("action"),
       
        type: 'get',
        

       // beforeSend: beforeSendHandler, // its a function which you have to define

        success: function(response) {
        
       console.log(response);
       if(response==1){

            swal("Done !", "", "success");
       }else{
        swal("Failed !", "", "error");

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
              
    });
    
  $('.delete-action').on('click',function () {


var disabled=$(this).attr('disabled');

if(typeof disabled !=='undefined'){
    
swal("You are not Allowed to Delete It Now!", "", "error");
return false;
}else{
    
var url=$(this).attr('href');
  
    swal({
        title: "Are you sure?",
        text: "You want to delete attachement",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Delete ",
        closeOnConfirm: false
    }, function () {
        
     $.ajax({
      
        url: url,  //Server script to process data
        type: 'POST',

        // Form data
       // data: formData,

       // beforeSend: beforeSendHandler, // its a function which you have to define

        success: function(response) {
          
         console.log(response);
         
     
          
           if(response['success']==true){
          
          
swal(response['message'], "", "success");
            //showSuccessMessage();
            location.reload();
          
          
            
           }else{

swal(response['message'], "", "error");
       
            //showErrorMessage(response['message']);
           

           }
        },

        error: function(){
            alert('ERROR at PHP side!!');
        },


        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false,
       
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
  
  //-----------------------------------update doc----------------------------------
  
  
 
  
    $('.kv-action-update').click(function () {



//var url = $(this).attr('href'); 
 
$('#modal-action').modal('show')
   .find('.modal-body')
   .load('{$url2}');
   
  $('#modal-action .modal-title').text($(this).attr('title'));
return false;
                      
// $('#select-person-type-modal.in').modal('hide') 
       });
       
//----------------------------------------------------------------------------print ---------------------------------------


 $('.kv-action-print').click(function () {



//var url = $(this).attr('href'); 
 
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
    
    
 $('.action-update1').click(function () {


var disabled=$(this).attr('disabled');

if(typeof disabled !=='undefined'){
    
swal("You are Not Allowed To Update It now !", "", "error");
return false;
}


var url = $(this).attr('href'); 
 
$('#modal-action').modal('show')
   .find('.modal-body')
   .load(url);
   
  $('#modal-action .modal-title').text($(this).attr('title')); 
return false;
                      
// $('#select-person-type-modal.in').modal('hide') 
       });


//-----------------------------update----------------------------------------

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

$(' input[type=radio][name="ErpDocument[action]"]').on('change', function() {

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

//------------------------------second select----------------------------------------------------
$('#recipients-selectz').on('select2:select', function (e) {
    var ids=$(this).val();
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
    // $('#recipients-names').empty();
    $.each(array, function(i,e){
    $("#recipients-namesz option[value='" + e + "']").prop("selected", true);
    console.log(e);
   
});

//trigger change-------------otherwise not updating
$('#recipients-namesz').trigger('change.select2');
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
//-------------------unselect 2------------------------------------------------------------------
$('#recipients-selectz').on('select2:unselect', function (e) {
  
  var ids=$(this).val();
  if(!jQuery.isEmptyObject(ids)){
  
    console.log(ids);
    $.get('{$url}',{ ids : ids },function(data){
     console.log(data);
     var array = JSON.parse(data);
     console.log(array);
     $('#recipients-namesz').val([]);
    $.each(array, function(i,e){
    $("#recipients-namesz option[value='" + e + "']").prop("selected", true);
    console.log(e);
});


//trigger change-------------otherwise not updating
$('#recipients-namesz').trigger('change.select2');

});

}else{ $('#recipients-namesz').val([]);$('#recipients-namesz').trigger('change.select2');}

});
//------------------------------------update doc link-------------------------------------------



JS;
$this->registerJs($script);

?>
