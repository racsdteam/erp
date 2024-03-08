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


use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CaseInvolvedParty */
$this->title = 'Document Full Info';
$this->params['breadcrumbs'][] = $this->title;

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

//===========================================request info=================================================
$user=Yii::$app->user->identity->user_id;
$q3=" SELECT r.*  FROM erp_document_request_for_action as r 
where document={$model->id} and r.status='pending' ";
$command3 = Yii::$app->db->createCommand($q3);
$row3 = $command3->queryOne();

//=============================================doc sender position=============================

$q4=" SELECT p.position FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
where pp.person_id='".$row3['requested_by']."' ";
$command4= Yii::$app->db->createCommand($q4);
$row4 = $command4->queryOne();




//------------------------------------------------doc attachements---------------------------------------------------------------
/*
$pdf = new \Jurosh\PDFMerge\PDFMerger;
$q = new Query;
                                   $q->select([
                                       'doc_ver_attch.attach_id',
                                       
                                   ])->from('erp_document_version_attach as doc_ver_attch ')->join('INNER JOIN', 'erp_document_version as doc_version',
                                       'doc_version.id=doc_ver_attch.doc_version')->where(['document' =>$model->id]);
                       
                                   $command0 = $q->createCommand();
                                   $rows1= $command0->queryAll(); 


  foreach($rows1 as $row1)  {
    $query3 = new Query;
                                            $query3	->select([
                                                'attch_ver_upload.*'
                                                
                                            ])->from('erp_attachment_version as attch_ver ')->join('INNER JOIN', 'erp_attachment_version_upload as attch_ver_upload',
                                                'attch_ver.id=attch_ver_upload.attach_version')->where(['attch_ver.attachment' =>$row1['attach_id']])->orderBy([
                                                    'version_number' => SORT_DESC,
                                                    
                                                  ]);	;
                                
                                            $command3 = $query3->createCommand();
                                            $rows3= $command3->queryAll();
                                           $pdf->addPDF($rows3[0]['attach_upload'], 'all');

                                          

  } 
  // generate a unique file name to prevent duplicate filenames
 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
 $path_to_merge='uploads/documents/'. $unification.'.pdf';
    // call merge, output format `file`
  $pdf->merge('file', $path_to_merge);
  $model->doc_merge_url =$path_to_merge;
  $model->save(false);*/
//-------------------------------------------------------------------------------------------------------------------------------
                
$label_class='label pull-left';

if($model->status=='processing'){
    $label_class.=" ".'bg-pink';

}else{
    $label_class.=" ".'bg-green';

}
                                    
                                     $attributes = [
   

                                        [
                                        'columns' => [
                                            [
                                                
                                                'label'=>'Doc Type',
                                                'format'=>'raw',
                                                'value'=>Html::a($type_html,Url::to(['erp-document-attach-merge/view','id'=>$model->id]), ['class'=>'kv-author-link']),
                                                'displayOnly'=>true,
                                                'valueColOptions'=>['style'=>'width:30%']
                                    
                                            ],
                                          
                                            [
                                                    
                                               
                                                'label'=>'Document Code',
                                                'format'=>'raw',
                                                'value'=>'<kbd>'.$model->doc_code.'</kbd>',
                                                'displayOnly'=>true,
                                                'valueColOptions'=>['style'=>'width:30%']
                                            ],

                                           


                                           
                                           
                                            
                                            ],

                                           

                                        //
                                        ],

                                        [
                                                        
                                                   
                                            'label'=>'Doc Title',
                                            'value'=>$model->doc_title,
                                            'displayOnly'=>true,
                                            'valueColOptions'=>['style'=>'width:100%']
                                        ],
                                       
                                        [
                                            'attribute'=>'doc_description',
                                            'format'=>'raw',
                                            'value'=>'<span class="text-justify"><em>' .$model->doc_description . '</em></span>',
                                            'type'=>DetailView::INPUT_TEXTAREA, 
                                            'options'=>['rows'=>4],
                                          
                                        ],
                                
                                        [
                                            'columns' => [


                                                
                                                
                                                [
                                                    
                                               
                                                    'label'=>'Status',
                                                    'format'=>'raw',
                                                    'value'=>'<small style="padding:10px;" class="'.$label_class.'">'.$model->status.'</small>',
                                                    'displayOnly'=>true,
                                                    'valueColOptions'=>['style'=>'width:30%']
                                                ],
                                    
                                                [
                                                   
                                                   
                                                    'label'=>'Severity',
                                                    'value'=>$model->severity,
                                                    'displayOnly'=>true,
                                                    'valueColOptions'=>['style'=>'width:30%']
                                                ],
                                    
                                                
                                                ],
                                            
                                       ],
                                        
                                    
                                        [
                                            'columns' => [
                                                
                                                [
                                                    
                                               
                                                    'label'=>'Sent By',
                                                    'format'=>'raw',
                                                    'value'=>'<small style="padding:10px;" class="bg-blue">'.$row4['position'].'</small>',
                                                    'displayOnly'=>true,
                                                    'valueColOptions'=>['style'=>'width:30%']
                                                ],
                                    
                                                [
                                                   
                                                   
                                                    'label'=>'Date Sent',
                                                    'value'=>$row3['timestamp'],
                                                    'displayOnly'=>true,
                                                    'valueColOptions'=>['style'=>'width:30%']
                                                ],
                                    
                                                
                                                ],
                                            
                                       ],
                                            
                                      
                                      
                                      
                                                ];
                                     

?>

 

<div class="well row clearfix">

    <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
       
          
    <div class="box box-default color-palette-box">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-tag"></i> Document Details</h3>
                </div>
           <div class="box-body">
               
        <div class="box box-warning  box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Removable</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <?php echo $row3['action_description'];?>
            </div>
            <!-- /.box-body -->
          </div>      

           
  
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

                  
           <?= DetailView::widget([
    'model'=>$model,
    'condensed'=>false,
    'hideIfEmpty'=>false,
    'hover'=>true,
    'mode'=>DetailView::MODE_VIEW,
    'panel' => [
                       'heading' => '&nbsp',
                       'type' => DetailView::TYPE_DEFAULT,
                       'headingOptions' => [
                          // 'template' => "$button1  {title}"
                       ]
                   ],
    'attributes'=>$attributes,
    
       
])?>

<?php 

$rows=array();


//==================================================all doc attachemnts regardless of versions============================
$query1 = new Query;
                                   $query1	->select([
                                       'doc_ver_attch.attach_id',
                                       
                                   ])->from('erp_document_version_attach as doc_ver_attch ')->join('INNER JOIN', 'erp_document_version as doc_version',
                                       'doc_version.id=doc_ver_attch.doc_version')->where(['doc_version.document' =>$model->id]);
                       
                                   $command1 = $query1->createCommand();
                                   $rows= $command1->queryAll(); 
                                 
                                                //-------------------------------------------attachements-------------------------------------------


                                                $i=0;       
                                               
?>


<div class="box-header">
<i class="glyphicon  glyphicon-duplicate"></i>

              <h3 class="box-title">Document Attachement(s)</h3>

             
            </div>

<p style="padding:10px;">

<?=Html::a('<i class="fa fa-plus-square"></i> <span>New Attachment</span>',
                                              Url::to(["erp-document-attachment/create",'id'=>$model->id,'flow'=>$flow
                                           ])
                                          ,['class'=>'btn-success btn-sm active kv-author-link','title'=>'Add Attachament(s)'] ); ?>

</p>

<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       
                                        <th>Visibility</th>
                                        <th>Title</th>
                                        <th>Attachement</th>
                                        <th>Attached by</th>
                                        <th>Date And Time Attached</th>
                                        <th>Update</th>
                                        <th>Delete</th>
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                    <?php foreach($rows as $row) {
                                   $q5 = new Query;
                                   $q5	->select([
                                       'attch.*'
                                       
                                   ])->from('erp_document_attachment as attch ')->where(['attch.id' =>$row['attach_id']])	;
                       
                                   $command5 = $q5->createCommand();
                                   $rows5= $command5->queryAll(); 
                                   $i=0;       
                                  

                                  ?>
                                     
                                  <?php foreach($rows5 as $row):?>
                                    <?php   $i++;?>
        
                                     <tr>
                                     <td>
                                    <?php $merg= ErpDocumentAttachMerge::find()->where(['attachement'=>$row['id']])->One();   ?>     
                                   
                                     <div class="checkbox">
                    <label>
                      <input id="checkbox1" type="checkbox" name="status"  
                      data-url="<?=Url::to(['erp-document-attach-merge/change-status','attach_id'=>$row['id'],'doc_id'=>$model->id]) ?>" <?php  if($merg->visible=='1'){echo 'checked';} ?>>
                     
                    </label>
                  </div>
                 
                </td>
                                           
                                          

                                             <td><?php echo $row["attach_title"] ; ?></td>
                                            <td><?php 
                                           $user= Yii::$app->user->identity->user_id;
                                            $q6 = new Query;
                                            $q6	->select([
                                                'attch_ver_upload.*'
                                                
                                            ])->from('erp_attachment_version as attch_ver ')->join('INNER JOIN', 'erp_attachment_version_upload as attch_ver_upload',
                                                'attch_ver.id=attch_ver_upload.attach_version')->where(['attch_ver.attachment' =>$row['id']])->orderBy([
                                                    'version_number' => SORT_DESC,
                                                    
                                                  ]);	;
                                
                                            $command6 = $q6->createCommand();
                                            $rows6= $command6->queryAll(); 
                                            
                                           if(!empty( $rows6)){?>

                                         <a title="View Document" class="kv-author-link" href="<?=Url::to(['erp-document/view-doc','url'=>$rows6[0]['attach_upload']])?>"              >
                                            <?php echo '<i class="fa fa-fw fa-file-pdf-o"></i>'." ".$rows6[0]['file_name']?>
                                          
                                          
                                          </a> 
                                          
                                          <?php }?>
                                        
                                        </td>
                                          
                                           
                                            <td><?php 
                                            
                                            $q7=" SELECT p.position FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                            where pp.person_id='".$row['user']."' ";
                                            $command7= Yii::$app->db->createCommand($q7);
                                            $row7 = $command7->queryOne(); 
                                            
                                            
                                            echo $row7['position'];
                                            
                                            
                                            
                                            
                                            ?>
                                        
                                        
                                        
                                        
                                        </td>
                                            <td><?php echo $row["timestamp"]; ?></td>

                                             <td> 
                                                 <?=Html::a('<i class="fa fa-edit"></i>',
                                              Yii::$app->urlManager->createUrl(["erp-document-attachment/update",'id'=>$row['id'],'doc'=>$model->id,'flow'=>$flow,
                                           ])
                                          ,['class'=>'btn-info btn-sm active kv-author-link','title'=>'View Attachment Info','disabled'=>$user!=$row['user'] ] ); ?> </td>
                                            <td> 
                                                 <?=Html::a('<i class="fa fa-remove"></i>',
                                              Yii::$app->urlManager->createUrl(["erp-document-attachment/delete",'id'=>$row['id'],'doc'=>$model->id,'flow'=>$flow
                                           ])
                                          ,['class'=>'btn-danger btn-sm active del-attach','title'=>'View Attachment Info','disabled'=>$user!=$row['user']] ); ?> </td>
                                          
                                         
                                           
                                            
                                        </tr>
                                    
                                    <?php endforeach;?>
                                    
                                    
                                          <?php }?>


                                    </tbody>
                                </table>
 </div>


  <div class="box box-action box-default color-palette-box">
                
           <div class="box-body">
           
           <?php if(Yii::$app->user->identity->user_image!==''){
 $imageURL=Yii::$app->request->baseUrl . '/' ."img/avatar-user.png";

//$imageURL=Yii::$app->request->baseUrl . '/' .Yii::$app->user->identity->user_image;

                       } else{

                           $imageURL=Yii::$app->request->baseUrl . '/' ."img/avatar-user.png";

                       } ?>  
          
<!--center the design           -->

<?php
    
   // $model1 = new ErpDocumentRequestForAction(); 
    $form = ActiveForm::begin([
        'id'=>'search-party-form', 
         'action' => ['erp-document/document-action','id'=>$model->id,'flow'=>$flow],
    
       'method' => 'post'
       ]);

?> 


      
<div class="col-sm-12">
                  <?php 
                  $items=['a0'=>'Forward'];
                  
                  echo $form->field($model, 'action')->radioList($items,['class'=>'radio']);?>
                  
                  
</div>

<?php
   ActiveForm::end();

 ?> 
<!-- end form 1-->
<?php
    $form = ActiveForm::begin([
        'id'=>'search-party-form', 
         'action' => ['erp-document/forward-after-correction','id'=>$model->id,'flow'=>$flow],
    
       'method' => 'post'
       ]);

?>

                    
<div class="col-sm-12 a a0">
    
<input type="hidden" id="recipientId" name="recipient" value="<?=$row3['requested_by']?>">   
<input type="hidden" id="docId" name="ErpDocument[id]" value="<?=$model->id?>">

<?= $form->field($model, 'recipients')->widget(Select2::classname(), [
    'data' => [ ArrayHelper::map(ErpOrgPositions::find()->all(), 'id', 'position') ],
    'options' => ['placeholder' => 'Select recipients ...','id'=>'recipients-select'
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])?>                
                    
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
    
])?>         
<textarea name="ErpDocument[remark]" value="<?= $model->remark ?>" class="form-control" rows="3" placeholder="Remark..."></textarea>
<?= Html::submitButton('<i class="fa fa-mail-forward"></i> Forward ', ['class' => 'btn btn-primary ']) ?>
<?php
   ActiveForm::end();

 ?> 
</div>







                                


                          
                         
            </div> 
            
            </div>

  <!--commenting   --> 

  
  
  


                </div> <!--box body   --> 

                      
                     
                      </div><!-- end col wraper  -->  
            </div><!-- end row wraper  -->
          
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

$script = <<< JS

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
 $('.kv-author-link').click(function () {

//showErrorMessage('error');


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
       $('#modal-action .modal-body').html('<div style="text-align:center"><img src="/mirror/images/m-loader.gif"></div>'); 
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




//using delegate events
$('.del-attach').on('click', function() {

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
          
          

            showSuccessMessage(response['message']);
            location.reload();
          
          
            
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
        processData: false,
       
    });

        
    

        
    });
  
  
 return false;
});

//---------------------------------------------------------updating the attach----------------------------------------------------



JS;
$this->registerJs($script);

?>
