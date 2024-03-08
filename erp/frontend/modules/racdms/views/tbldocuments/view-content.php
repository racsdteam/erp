



<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;
use yii\helpers\Url;
use yii\base\View;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

use common\models\User;
use common\models\UserHelper;
use common\models\UnitHelper;
use common\models\ErpOrgUnits;
use common\models\UserRoles;

use common\models\GroupsAccessList;
use common\models\UsersAccessList;
use common\models\RolesAccessList;
use common\models\Tblacls;
use common\models\Tblgroups;


use  frontend\assets\PdfTronViewerAsset;
PdfTronViewerAsset::register($this);


?>

 <?php

$full_path=$content->getContentPath();

$id=$content->id;



 ?>
 
 <style>
     
     .doc-meta{color: #6c757d;
   }
   
  
 </style>
 
 
 
 
  <div class="card card-success card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" 
                    href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true"> <i class="fa fa-th-list"></i> Document View</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" 
                    href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false"><i class="fas fa-user-lock"></i> Access Rights</a>
                  </li>
                  
                </ul>
              </div>
              <div class="card-body">
                  
                  <?php
                  if($doc->status){
                      $status="Checked-Out";
                      $class="badge badge-warning";
                      $ic_class="fa fa-arrow-circle-up";
                  }else{$status="Checked-In";
                       $class="badge badge-primary";
                        $ic_class="fa fa-arrow-circle-down";
                  }
           $user=UserHelper::getUserInfo($doc->owner) ;
   
           $pos=UserHelper::getPositionInfo($doc->owner);
  
           $author=$user['first_name']." ".$user['last_name']." / ".$pos['position']; 
                  ?>
             
             <div class="tab-content" id="custom-tabs-one-tabContent">
                 
                  <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                    
                    
                    <div class="row">
     
     
     <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
         
         <div class="bg-light mb-5 pl-2">
                   <span class="doc-meta">Name :</span> <?php echo $doc->name ?></br>
                   <span class="doc-meta">Author :</span> <?php echo  $author?></br>
                   <span class="doc-meta">Last Modified :</span> <?php echo $content->date ?></br>
                   <span class="doc-meta">Status :</span><span class="<?php echo $class ?>"><?= $status?>  <i class="<?php echo  $ic_class?>"></i></span> </br>
                   <span class="doc-meta">Comments :</span> <?php echo $doc->comment ?></br>
                   </div> 
                   
                   <div class="mb-4 bg-light">
                   <span class="doc-meta">File Name :</span>  <?php echo $content->orgFileName ?></br>
                   <span class="doc-meta">File Size :</span> <?php echo $content->getSize() ?></br>    
                       
                   </div>
                   
                   <div>
                       
                       <h5 class="mt-4 text-muted">Document Attachement(s)</h5>
              <ul class="list-unstyled bg-light">
                
                 <?php $files=$doc->getDocumentFiles();   ?> 
                  
                  <?php if(!empty($files)) : ?>
                  
                  <?php foreach($files as $file) :?>
                
                <li>
                  <a href="<?php echo $file->getPath()  ?>"   class="btn-link text-secondary doc-file">
                      <i class="<?php echo getIconByType($file->fileType) ?>"></i> <?= $file->orgFileName?></a>
                </li>
                
               
                <?php endforeach;?>
                
                 
                
                <?php else : ?>
                
                <p class="btn-link text-secondary">No Attachements Found</p>
                
                <?php endif;?>
              
              </ul>
                   </div>
                   
                   <div class="text-center mt-2 mb-2">
                
                <?=Html::a('<i class="fas fa-cloud-upload-alt"></i> Upload Attachement',
                                              Url::to(["tbldocumentfiles/create",'documentid'=>$doc->id,
                                           ])
                                          ,['class'=>'btn-success btn-sm active action-add-file  ','title'=>'Add New Attachement'] ); ?>
               
              </div>
        
        
         </div>
         
         
         
          <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 bg-light">
         
          
          <div  id="Contentpage<?php echo $content->id ?>" style="height: 600px;"></div>
        
        
         </div>
         
         
         </div>
                    
                    
             
                  </div>
                  
                  
         <!-- ----------------------------TAB2----------------------------------------------->  
         
          <div class="tab-pane fade access" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                  
               
    <!-------------------------------------------groups------------------------------------------------------------------------------>   
              
              
                 <div class="table-responsive">
              <table id="group-access-list" class="table  accessTable">
                <thead>
                <tr>
                  <th>Securitys Group</th>
                  <th>Restrict</th>
                  <th>Read</th>
                  <th>Read & Write</th>
                  <th>Full Control</th>
                  <th>Remove</th>
                 
                </tr>
                </thead>
                
             
              </table>
            </div>
            
          <?php  
       
      $groupModel=new GroupsAccessList();
     
                  ?> 
       
          <div  class="card-footer pb-0">          
            
        <?php $form = ActiveForm::begin([
                               'options' => ['class'=>'access-form'],
                               'id'=>'give-access-form', 
                               'enableClientValidation'=>true,
                               'action' => ['tbldocuments/add-access'],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               
                                 
                               ]) ?>
                             
    <?= $form->field($groupModel, 'target')->hiddenInput(['value'=>$doc->id])->label(false); ?>
    
     <div class="row">
        
        <div class="col-6">  
           
            <?php $items=ArrayHelper::map(Tblgroups::find()->all(), 'id',function($group){
           
             if($group->type==Tblgroups::UNIT_GROUP){
                 
                 $unitInfo=UnitHelper::getOrgUnitInfoByCode($group->name);
                 
                 if(!empty($unitInfo))
                 
                    return $unitInfo['unit_name']." ".$unitInfo['unit_level'];
                
             }else{
             
              return $group->name;    
                 
             }
             
             
      
      }); ?>
                   <?= $form->field($groupModel, 'group')->widget(Select2::classname(), [
    'data' =>$items,
    'options' => ['placeholder' => 'Select Group(s) ...','id'=>'group-select',
    
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>false
       
       
    ]
    
])->label(false)?> 

             </div>
            
            <div class="col-4">  
             <?php $items=[Tblacls::M_NONE=>"No Access",Tblacls::M_READ=>"Read",Tblacls::M_READWRITE=>"ReadWrite",Tblacls::M_ALL=>"Full Control"]; ?>
                   <?= $form->field($groupModel, 'access_mode')->widget(Select2::classname(), [
    'data' =>$items,
    'options' => ['placeholder' => 'Select Access Level ...','id'=>'access-select',
    
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>false
       
       
    ]
    
])->label(false)?> 
            </div>
    
    <div class="col-2"> 
            
             <div class="form-group">
        <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
    </div>
                </div>
            </div>
                           
                                 
         <?php ActiveForm::end(); ?>
           
            </div>     
     
 <!-------------------------------------------users------------------------------------------------------------------------------>   
              
              
                 <div class="table-responsive">
              <table id="user-access-list" class="table accessTable">
                <thead>
                <tr>
                  <th>Users</th>
                  <th>Restrict</th>
                  <th>Read</th>
                  <th>Read & Write</th>
                  <th>Full Control</th>
                  <th>Remove</th>
                 
                </tr>
                </thead>
                
             
              </table>
            </div>
            
          <?php  
       
      $userModel=new UsersAccessList();
     
                  ?> 
       
          <div  class="card-footer pb-0">          
            
        <?php $form = ActiveForm::begin([
                               'options' => ['class'=>'access-form'],
                               'id'=>'give-access-form2', 
                               'enableClientValidation'=>true,
                               'action' => ['tbldocuments/add-access'],
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               
                                 
                               ]) ?>
                             
    <?= $form->field($userModel, 'target')->hiddenInput(['value'=>$doc->id])->label(false); ?>
    
     <div class="row">
        
        <div class="col-6">  
           
           <?php $items=ArrayHelper::map(User::find()->all(), 'user_id',function($user){
      
         $pos=UserHelper::getPositionInfo($user->user_id);
         
         if(!$pos)
          return $user->first_name." ".$user->last_name; 
         
          return $user->first_name." ".$user->last_name." / ".$pos['position']; 
      
      }); ?>
                   <?= $form->field($userModel, 'user[]')->widget(Select2::classname(), [
    'data' =>$items,
    'options' => ['placeholder' => 'Select User(s) ...','id'=>'user-select',
    
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>true
       
       
    ]
    
])->label(false)?> 

             </div>
            
            <div class="col-4">  
             
             <?php $items=[Tblacls::M_NONE=>"No Access",Tblacls::M_READ=>"Read",Tblacls::M_READWRITE=>"ReadWrite",Tblacls::M_ALL=>"Full Control"]; ?>
                   <?= $form->field($userModel, 'access_mode')->widget(Select2::classname(), [
    'data' =>$items,
    'options' => ['placeholder' => 'Select Access Level ...','id'=>'level-select',
    
   ],
    'pluginOptions' => [
        'allowClear' => true,
        'multiple'=>false
       
       
    ]
    
])->label(false)?> 
            </div>
    
    <div class="col-2"> 
            
             <div class="form-group">
        <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
    </div>
                </div>
            </div>
                           
                                 
         <?php ActiveForm::end(); ?>
           
            </div>     
               
     
           
                  </div>
                 
                 
                 </div>
               
               </div>
               
               </div> 
               
               </div>
                  

 
 <?php
function getIconByType($type){
    
 $fileTypes=array("pdf"=>"far fa-file-pdf","doc"=>"far fa-file-word","docx"=>"far fa-file-word","ppt"=>"far fa-file-powerpoint","pptx"=>"far fa-file-powerpoint");  
 $fa_icon=null;
 
 foreach($fileTypes as $key=>$ficon){
     
     if($key==$type){
         
        $fa_icon=$ficon;
        break;
     }
     
    if(!$fa_icon){
        
       $fa_icon="far fa-file"  ;
    }
    
    
 }
   
   return $fa_icon; 
}

?>
 
 
   <?php

$serverURL=null;
$user_id=Yii::$app->user->identity->user_id;

$q2="SELECT u.first_name,u.last_name,pos.position,pos.position_code,s.signature,r.role_name from user  as u 
        inner join erp_persons_in_position  as pp on pp.person_id=u.user_id 
        inner join erp_org_positions as pos on pos.id=pp.position_id 
        inner join user_roles as r on r.role_id=u.user_level
        left join signature as s on u.user_id=s.user where pp.person_id={$user_id} and pp.status=1 ";
        $com2 = Yii::$app->db->createCommand($q2);
        $row = $com2->queryOne();
  //-----------------------------------------doc author-------------------------       
        // $author=$row['first_name']." ".$row['last_name']."/".$row['position'];
         $fn=$row['first_name'];
         $ln=$row['last_name'];
         $position=$row['position'];
         $pos_code_user=isset($row['position_code'])?$row['position_code']:'';
         $signature=$row['signature'];
         $role=$row['role_name'];
          
        

  $todate = date('Y-m-d');
  $todate=date('Y-m-d', strtotime($todate));
  //----------------------------check if interim for------------------------------------------>
$q8="SELECT * from erp_person_interim where  person_in_interim={$user_id} 
and date_from <= '$todate' and date_to >= '$todate'";
$command8= Yii::$app->db->createCommand($q8);
$row1 = $command8->queryOne();
$pos_code_int='';
 
if(!empty($row1)){
    
//---------------------get position code---------------------------------------
$q3="SELECT p.* from erp_org_positions as p inner join erp_persons_in_position as pp on pp.position_id=p.id where pp.person_id={$row1['person_interim_for']} ";
        $com3= Yii::$app->db->createCommand($q3);
        $row2 = $com3->queryOne();
       
        if(!empty($row2) && isset($row2['position_code'])){
            
            $pos_code_int= $row2['position_code'];
        }
}

$ajaxUrl=Url::to(['tbldocuments/access-list']);
$removeUrl=Url::to(['tbldocuments/remove-access']);

$doc=$doc->id;

$script = <<< JS

$(function() {
   
  
var fn="{$fn}";
var ln="{$ln}";
var role="{$role}";
var position="{$position}";
var pos_code_u="{$pos_code_user}";
var pos_code_int="{$pos_code_int}";
var signature="{$signature}";


var user = {fn: fn, ln:ln,role:role, pos:position,pos_code_u:pos_code_u,pos_code_int:pos_code_int,signature: signature};


showViewer( '{$full_path}','{$serverURL}','{$id}',user,'Contentpage{$id}' );

//-----------------------------Modal------------------------------------------------------

 $('.action-add-file').click(function () {
        var url = $(this).attr('href');
$('.modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('.modal-action #defaultModalLabel').text($(this).attr('title'));
return false;
                        
 
        }); 
   
   
    
  var tableGroups=$('#group-access-list').DataTable({
     "paging":false,
     "lengthChange":false,
      "searching":false,
      "ordering": true,
      "info":false,
      "autoWidth": false,
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'ajax': {
          'url':'{$ajaxUrl}',
           data: {action: 'groups',id:'{$doc}'},
      },
      'columns': [
         { data: 'group_name' },
         { data: 'restrict' },
         { data: 'read' },
         { data: 'readwrite' },
         { data: 'fullaccess' },
          {
      "data": null,
      "defaultContent":""
    }
      ],
       columnDefs: [
        { 
            targets: [1,2,3,4],
            searchable: false,
            orderable: false,
            render: function(data, type, full, meta){
              
             
              
               if(type === 'display'){
                  
                  checked=data?'checked':'';
                  
                  id='groupMode'+meta.row +""+ meta.col;
                  name='groupRadio'+full.group_id;
                
                  data='<div class="custom-control custom-radio">'+
                      '<input class="custom-control-input"  type="radio" id="'+id+'" name="'+name+'" value="' + data + '"'+ checked + '>'+
                      '<label for="'+id+'" class="custom-control-label"></label>'+
                      '</div>';
                        
                  //data = '<input type="radio" name="'+full.group_id+'" value="' + data + '"'+ checked + '>';      
               }

               return data;
            }
        },
        { 
            targets: [5],
            searchable: false,
            orderable: false,
            render: function(data, type, full, meta){
              
               
              var action;
               if(type === 'display'){
              
               var url='{$removeUrl}';
               var group_id=full.group_id; 
               var target='{$doc}';
               
               action = '<a class="action-remove-access" href="'+url+'" data-target="'+target+'" data-grouporuserid="'+group_id+'"  data-is-user=0  title="Remove Permission" >'+
               '<i class="far fa-trash-alt">'+'</i></a>';      
               }

               return  action;
            }
        }
    ]
    });
    
 
 //---------------------------------------------------------------------------------------------------------------
 
    
  var tableUsers=$('#user-access-list').DataTable({
     "paging":false,
     "lengthChange":false,
      "searching":false,
      "ordering": true,
      "info":false,
      "autoWidth": false,
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'ajax': {
          'url':'{$ajaxUrl}',
           data: {action: 'users',id:'{$doc}'},
      },
      'columns': [
         { data: 'user' },
         { data: 'restrict' },
         { data: 'read' },
         { data: 'readwrite' },
         { data: 'fullaccess' },
          {
      "data": null,
      "defaultContent":""
    }
      ],
       columnDefs: [
        { 
            targets: [1,2,3,4],
            searchable: false,
            orderable: false,
            render: function(data, type, full, meta){
              
            
              
               if(type === 'display'){
                  
                  checked=data?'checked':'';
                  id='UserMode'+meta.row+""+ meta.col;
                  name='UserRadio'+full.user_id;
                
                  data='<div class="custom-control custom-radio">'+
                      '<input class="custom-control-input"  type="radio" id="'+id+'" name="'+name+'" value="' + data + '"'+ checked + '>'+
                      '<label for="'+id+'" class="custom-control-label"></label>'+
                      '</div>';
                    
               }

               return data;
            }
        },
        { 
            targets: [5],
            searchable: false,
            orderable: false,
            render: function(data, type, full, meta){
              
               var url='{$removeUrl}';
               var user_id=full.user_id; 
               var target='{$doc}';
               
              
              var action;
               if(type === 'display'){
              
               action = '<a class="action-remove-access" href="'+url+'" data-target="'+target+'" data-grouporuserid="'+user_id+'"  data-is-user=1  title="Remove Permission" >'+
               '<i class="far fa-trash-alt">'+'</i></a>';     
               }

               return  action;
            }
        }
    ]
    });
 
  //--------------------give access form submit-------------------------------------------
  
  $('.access-form').on('beforeSubmit', function(event) {

  
    var \$form = $(this);
    var formData = new FormData(\$form [0]);// to be able to send file
   
    $.ajax({
        url: \$form.attr("action"),  //Server script to process data
        type: 'POST',

        // Form data
        data: formData,

       // beforeSend: beforeSendHandler, // its a function which you have to define

        success: function(response) {
           
            response=JSON.parse(response);
          
          
           if(response.data.flag==true){
        
           Swal.fire(
      'Success!',
     response.data.message,
      'success'
    )
         
          
          if(response.data.target==='users'){
              
             tableUsers.ajax.reload( null, false);  
          }
          else if(response.data.target==='groups'){
              
             tableGroups.ajax.reload( null, false);    
          }else{
              
               tableUsers.ajax.reload( null, false); 
               tableGroups.ajax.reload( null, false); 
          }
         
            
           }else{

            toastr.error(response.data.error);

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

$('.accessTable').on('click', '.action-remove-access', function (e) {
 
   e.preventDefault();
   var url=$(this).attr('href');
   var target=$(this).attr('data-target');
   var grouporuserid=$(this).attr('data-grouporuserid');
   var isuser=$(this).attr('data-is-user');
   
   var grouporuser=isuser==1?"user":"group"
  
   Swal.fire({
 title: "Are you sure?",
  text: "You want to remove this "+grouporuser+"!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, remove it!'
}).then((result) => {
  if (result.value) {
    
      $.post(url,{ 
                    target:target,
                    grouporuserid:grouporuserid,
                    isuser:isuser
                }, ).done(function(response){
                     console.log(response)
                   response=JSON.parse(response);
      
      if(response.data.flag==true){
          
          Swal.fire(
      'Deleted!',
      isuser==1? 'user has been deleted!' :' group has been deleted !',
      'success'
    )
    
    if(response.data.target==='users'){
       
       tableUsers.ajax.reload( null, false);    
        
    }else{
        
         tableGroups.ajax.reload( null, false);  
    }
          
      }else{
       
       Swal.fire(
      'Error!',
       response.data.error,
      'error'
    )
      }
     
});
  }
})
   
   return false;
   
    
});

   
});



JS;
$this->registerJs($script);
?>




